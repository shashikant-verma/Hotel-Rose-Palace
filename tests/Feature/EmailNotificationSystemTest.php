<?php

namespace Tests\Feature;

use App\Console\Commands\TestEmailCommand;
use App\Mail\BookingCancelledMail;
use App\Mail\BookingConfirmedMail;
use App\Mail\GeneralInquiryReceived;
use App\Mail\OtpMail;
use App\Mail\PaymentReceiptMail;
use App\Mail\RefundProcessedMail;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use App\Models\User;
use App\Services\CancellationService;
use App\Services\OtpService;
use App\Services\PaymentProcessingService;
use App\Services\RefundProcessingService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use ReflectionClass;
use Tests\TestCase;

class EmailNotificationSystemTest extends TestCase
{
    use RefreshDatabase;

    protected RoomType $roomType;
    protected Room $room;
    protected string $testKeyId = 'rzp_test_mock_key_123';
    protected string $testKeySecret = 'test_secret_mock_secret_456';
    protected string $testWebhookSecret = 'test_webhook_secret_789';

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('razorpay.key_id', $this->testKeyId);
        Config::set('razorpay.key_secret', $this->testKeySecret);
        Config::set('razorpay.webhook_secret', $this->testWebhookSecret);
        Config::set('razorpay.currency', 'INR');
        Config::set('razorpay.reservation_duration_minutes', 30);

        $this->roomType = RoomType::create([
            'name' => 'Royal Heritage Suite',
            'slug' => 'royal-heritage-suite',
            'description' => 'Opulent suite with palace courtyard view',
            'base_price' => 5000,
            'max_occupancy' => 2,
            'is_active' => true,
        ]);

        $this->room = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '101',
            'current_price' => 5000,
            'is_available' => true,
        ]);
    }

    /**
     * Helper to create test booking
     */
    protected function createBooking(array $overrides = []): Booking
    {
        static $seq = 100;
        $seq++;

        $checkIn = Carbon::tomorrow();
        $checkOut = Carbon::tomorrow()->addDays(2);
        $baseAmount = 10000.00;
        $taxAmount = 1200.00;
        $totalAmount = 11200.00;

        $booking = Booking::create(array_merge([
            'booking_reference' => 'BK' . now()->format('YmdHis') . $seq,
            'customer_name' => 'Meera Rajput',
            'customer_email' => 'meera@example.com',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'num_adults' => 2,
            'num_children' => 0,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'base_amount' => $baseAmount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'razorpay_order_id' => 'order_mail_test_' . $seq,
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ], $overrides));

        RoomAllocation::create([
            'booking_id' => $booking->id,
            'room_id' => $this->room->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'temporary',
            'allocated_at' => now(),
        ]);

        return $booking;
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 1. TRANSACTIONAL EMAIL DISPATCH ON PAYMENT VERIFICATION
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Test booking confirmation and payment receipt emails are sent after verified payment.
     */
    public function test_booking_confirmation_and_payment_receipt_emails_dispatched_on_verified_payment(): void
    {
        Mail::fake();

        $booking = $this->createBooking();
        $orderId = $booking->razorpay_order_id;
        $paymentId = 'pay_verified_12345';

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $orderId,
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        $validSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->testKeySecret);

        Http::fake([
            "https://api.razorpay.com/v1/payments/{$paymentId}" => Http::response([
                'id' => $paymentId,
                'order_id' => $orderId,
                'amount' => (int) ($booking->total_amount * 100),
                'currency' => 'INR',
                'status' => 'captured',
                'method' => 'card',
                'card' => ['last4' => '4242', 'network' => 'Visa'],
            ], 200),
        ]);

        $response = $this->withSession([
            'verified_email' => $booking->customer_email,
            'otp_verified' => true,
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $validSignature,
        ]);

        $response->assertRedirect(route('booking.status', ['booking' => $booking->id]));

        // Assert BookingConfirmedMail queued to customer
        Mail::assertQueued(BookingConfirmedMail::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->customer_email) &&
                   $mail->booking->id === $booking->id &&
                   str_contains($mail->envelope()->subject, $booking->booking_reference);
        });

        // Assert PaymentReceiptMail queued to customer
        Mail::assertQueued(PaymentReceiptMail::class, function ($mail) use ($booking, $paymentId) {
            return $mail->hasTo($booking->customer_email) &&
                   $mail->payment->razorpay_payment_id === $paymentId;
        });

        // Assert timestamp tracking updated in DB
        $freshBooking = $booking->fresh();
        $freshPayment = $payment->fresh();
        $this->assertNotNull($freshBooking->confirmation_email_sent_at);
        $this->assertNotNull($freshPayment->receipt_email_sent_at);
    }

    /**
     * Test unverified payments do NOT send confirmation or receipt emails.
     */
    public function test_unverified_payment_does_not_send_emails(): void
    {
        Mail::fake();

        $booking = $this->createBooking();
        $orderId = $booking->razorpay_order_id;
        $paymentId = 'pay_tampered_67890';

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $orderId,
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        $invalidSignature = 'tampered_invalid_signature_hash';

        $response = $this->withSession([
            'verified_email' => $booking->customer_email,
            'otp_verified' => true,
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $invalidSignature,
        ]);

        $response->assertRedirect(route('booking.payment', ['booking' => $booking->id]));

        // Assert no emails were dispatched
        Mail::assertNotQueued(BookingConfirmedMail::class);
        Mail::assertNotQueued(PaymentReceiptMail::class);
        Mail::assertNothingSent();

        $freshBooking = $booking->fresh();
        $this->assertNull($freshBooking->confirmation_email_sent_at);
        $this->assertEquals('pending', $freshBooking->payment_status);
    }

    /**
     * Test duplicate payment verification or repeat webhook does NOT send duplicate emails (Idempotency).
     */
    public function test_duplicate_payment_verification_does_not_resend_emails(): void
    {
        Mail::fake();

        $booking = $this->createBooking([
            'confirmation_email_sent_at' => now(),
            'payment_status' => 'paid',
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_already_recorded',
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'captured',
            'receipt_email_sent_at' => now(),
        ]);

        // Attempt second dispatch via service
        $paymentService = app(PaymentProcessingService::class);
        $paymentService->dispatchPaymentSuccessEmails($booking, $payment);

        // Neither email should be queued or sent again
        Mail::assertNotQueued(BookingConfirmedMail::class);
        Mail::assertNotQueued(PaymentReceiptMail::class);
        Mail::assertNothingSent();
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 2. CANCELLATION EMAIL DISPATCH & IDEMPOTENCY
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Test cancellation email is sent when manager approves cancellation.
     */
    public function test_cancellation_email_dispatched_on_approved_cancellation(): void
    {
        Mail::fake();

        $manager = User::factory()->create([
            'role' => 'manager',
            'email' => 'manager@hotelrosepalace.com',
        ]);

        $booking = $this->createBooking([
            'payment_status' => 'paid',
            'booking_status' => 'cancellation_requested',
            'cancellation_status' => 'pending',
            'cancellation_requested_at' => now(),
            'cancellation_percentage' => 0,
            'eligible_refund_amount' => 0.00,
        ]);

        $cancellationService = app(CancellationService::class);
        $result = $cancellationService->approveCancellation($booking, $manager, 'Customer change of schedule');

        $this->assertTrue($result['success']);

        Mail::assertQueued(BookingCancelledMail::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->customer_email) &&
                   $mail->booking->id === $booking->id;
        });

        $this->assertNotNull($booking->fresh()->cancellation_email_sent_at);
    }

    /**
     * Test repeated cancellation dispatch does not send duplicate emails.
     */
    public function test_repeated_cancellation_dispatch_does_not_resend_email(): void
    {
        Mail::fake();

        $booking = $this->createBooking([
            'payment_status' => 'paid',
            'booking_status' => 'cancelled',
            'cancellation_status' => 'approved',
            'cancellation_email_sent_at' => now(),
        ]);

        $cancellationService = app(CancellationService::class);
        $cancellationService->dispatchCancellationEmails($booking, 'not_applicable');

        Mail::assertNotQueued(BookingCancelledMail::class);
        Mail::assertNothingSent();
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 3. REFUND EMAIL DISPATCH (PROCESSED, PENDING, FAILED)
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Test refund processed email dispatched when refund succeeds immediately.
     */
    public function test_refund_processed_email_dispatched_on_successful_refund(): void
    {
        Mail::fake();

        $booking = $this->createBooking(['payment_status' => 'paid']);
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_refund_123',
            'amount' => 11200.00,
            'currency' => 'INR',
            'status' => 'captured',
        ]);

        // Mock Razorpay reconciliation (no existing refunds) and refund creation (status processed)
        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_refund_123/refunds' => Http::response(['items' => []], 200),
            'https://api.razorpay.com/v1/payments/pay_refund_123/refund' => Http::response([
                'id' => 'rfnd_success_999',
                'entity' => 'refund',
                'amount' => 1120000,
                'currency' => 'INR',
                'payment_id' => 'pay_refund_123',
                'status' => 'processed',
            ], 200),
        ]);

        $refundService = app(RefundProcessingService::class);
        $result = $refundService->processRefund($booking, 1120000, 'Customer approved cancellation');

        $this->assertTrue($result['success']);
        $this->assertEquals('processed', $result['status']);

        Mail::assertQueued(RefundProcessedMail::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->customer_email) &&
                   $mail->refundStatus === 'processed' &&
                   $mail->refundAmount == 11200.00 &&
                   $mail->refundId === 'rfnd_success_999';
        });

        $this->assertNotNull($payment->fresh()->refund_email_sent_at);
    }

    /**
     * Test refund pending email dispatched with pending status (not claimed as completed).
     */
    public function test_refund_pending_email_dispatched_with_pending_status(): void
    {
        Mail::fake();

        $booking = $this->createBooking(['payment_status' => 'paid']);
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_refund_pending_456',
            'amount' => 11200.00,
            'currency' => 'INR',
            'status' => 'captured',
        ]);

        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_refund_pending_456/refunds' => Http::response(['items' => []], 200),
            'https://api.razorpay.com/v1/payments/pay_refund_pending_456/refund' => Http::response([
                'id' => 'rfnd_pending_888',
                'entity' => 'refund',
                'amount' => 1120000,
                'currency' => 'INR',
                'payment_id' => 'pay_refund_pending_456',
                'status' => 'pending',
            ], 200),
        ]);

        $refundService = app(RefundProcessingService::class);
        $result = $refundService->processRefund($booking, 1120000, 'Customer approved cancellation');

        $this->assertTrue($result['success']);
        $this->assertEquals('pending', $result['status']);

        Mail::assertQueued(RefundProcessedMail::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->customer_email) &&
                   $mail->refundStatus === 'pending' &&
                   $mail->refundId === 'rfnd_pending_888';
        });
    }

    /**
     * Test refund failed email dispatched with failed status.
     */
    public function test_refund_failed_email_dispatched_with_failed_status(): void
    {
        Mail::fake();

        $booking = $this->createBooking(['payment_status' => 'paid']);
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_refund_fail_789',
            'amount' => 11200.00,
            'currency' => 'INR',
            'status' => 'captured',
        ]);

        Http::fake([
            'https://api.razorpay.com/v1/payments/pay_refund_fail_789/refunds' => Http::response(['items' => []], 200),
            'https://api.razorpay.com/v1/payments/pay_refund_fail_789/refund' => Http::response([
                'error' => ['description' => 'Gateway connectivity failure', 'code' => 'GATEWAY_ERROR'],
            ], 500),
        ]);

        $refundService = app(RefundProcessingService::class);
        $result = $refundService->processRefund($booking, 1120000, 'Customer approved cancellation');

        $this->assertFalse($result['success']);

        Mail::assertQueued(RefundProcessedMail::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->customer_email) &&
                   $mail->refundStatus === 'failed';
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 4. OTP SYNCHRONOUS DELIVERY & SHOULD_QUEUE SPECIFICATION
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Test OTP email is dispatched synchronously with valid 6-digit code.
     */
    public function test_otp_email_is_synchronous_and_contains_valid_code(): void
    {
        Mail::fake();

        $otpService = app(OtpService::class);
        $result = $otpService->generateAndSendOtp('guest@example.com', 'booking');

        $this->assertTrue($result['success']);

        Mail::assertSent(OtpMail::class, function ($mail) {
            return $mail->hasTo('guest@example.com') &&
                   preg_match('/^\d{6}$/', $mail->otp) === 1;
        });

        // Ensure OtpMail does NOT implement ShouldQueue (synchronous delivery)
        $reflection = new ReflectionClass(OtpMail::class);
        $this->assertFalse(
            $reflection->implementsInterface(ShouldQueue::class),
            'OtpMail must NOT implement ShouldQueue so guests receive OTP instantly.'
        );
    }

    /**
     * Test transactional mailables implement ShouldQueue and $afterCommit = true.
     */
    public function test_transactional_mailables_implement_should_queue_and_after_commit(): void
    {
        $queuedMailables = [
            BookingConfirmedMail::class,
            PaymentReceiptMail::class,
            BookingCancelledMail::class,
            RefundProcessedMail::class,
            GeneralInquiryReceived::class,
        ];

        foreach ($queuedMailables as $mailableClass) {
            $reflection = new ReflectionClass($mailableClass);
            
            $this->assertTrue(
                $reflection->implementsInterface(ShouldQueue::class),
                "{$mailableClass} must implement ShouldQueue."
            );

            $this->assertTrue(
                $reflection->hasProperty('afterCommit'),
                "{$mailableClass} must have \$afterCommit via Queueable."
            );

            $this->assertEquals(
                3,
                $reflection->getDefaultProperties()['tries'] ?? null,
                "{$mailableClass} must configure \$tries = 3."
            );

            $this->assertEquals(
                30,
                $reflection->getDefaultProperties()['backoff'] ?? null,
                "{$mailableClass} must configure \$backoff = 30."
            );
        }

        $booking = $this->createBooking();
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'ord_test_q',
            'amount' => 1000,
            'currency' => 'INR',
            'status' => 'captured',
        ]);
        $inquiry = ContactMessage::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '9876543210',
            'subject' => 'General Question',
            'message' => 'Queue test message',
        ]);

        $this->assertTrue((new BookingConfirmedMail($booking))->afterCommit);
        $this->assertTrue((new PaymentReceiptMail($booking, $payment))->afterCommit);
        $this->assertTrue((new BookingCancelledMail($booking))->afterCommit);
        $this->assertTrue((new RefundProcessedMail($booking, $payment, 'processed', 1000.0))->afterCommit);
        $this->assertTrue((new GeneralInquiryReceived($inquiry))->afterCommit);
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 5. EMAIL TEMPLATES & LUXURY BRANDING
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Test email templates render expected luxury branding, fonts, and content.
     */
    public function test_email_templates_render_luxury_branding_and_content(): void
    {
        $booking = $this->createBooking();
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $booking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_render_test',
            'amount' => 11200.00,
            'currency' => 'INR',
            'status' => 'captured',
            'payment_method' => 'card',
        ]);

        // 1. BookingConfirmedMail
        $confirmedMail = new BookingConfirmedMail($booking);
        $confirmedHtml = $confirmedMail->render();
        $this->assertStringContainsString('#6E2C3A', $confirmedHtml);
        $this->assertStringContainsString('Hotel Rose Palace', $confirmedHtml);
        $this->assertStringContainsString($booking->booking_reference, $confirmedHtml);
        $this->assertStringContainsString('Meera Rajput', $confirmedHtml);

        // 2. PaymentReceiptMail
        $receiptMail = new PaymentReceiptMail($booking, $payment);
        $receiptHtml = $receiptMail->render();
        $this->assertStringContainsString('#6E2C3A', $receiptHtml);
        $this->assertStringContainsString('Official Payment Receipt', $receiptHtml);
        $this->assertStringContainsString('pay_render_test', $receiptHtml);
        $this->assertStringContainsString('11,200.00', $receiptHtml);

        // 3. BookingCancelledMail
        $cancelledMail = new BookingCancelledMail($booking);
        $cancelledHtml = $cancelledMail->render();
        $this->assertStringContainsString('#6E2C3A', $cancelledHtml);
        $this->assertStringContainsString('Booking Cancellation Confirmation', $cancelledHtml);
        $this->assertStringContainsString($booking->booking_reference, $cancelledHtml);

        // 4. RefundProcessedMail
        $refundMail = new RefundProcessedMail($booking, $payment, 'processed', 11200.00, 'rfnd_render_123');
        $refundHtml = $refundMail->render();
        $this->assertStringContainsString('#6E2C3A', $refundHtml);
        $this->assertStringContainsString('Refund Processed', $refundHtml);
        $this->assertStringContainsString('rfnd_render_123', $refundHtml);
        $this->assertStringContainsString('11,200.00', $refundHtml);
    }

    // ═══════════════════════════════════════════════════════════════════════
    // 6. ARTISAN TEST EMAIL COMMAND & CONFIGURATION
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Test email:test command with valid recipient executes successfully.
     */
    public function test_email_test_artisan_command_with_valid_recipient(): void
    {
        $this->artisan('email:test', ['recipient' => 'test@example.com'])
            ->expectsOutputToContain('Hotel Rose Palace — Email System Operational Verification')
            ->expectsOutputToContain('Recipient: test@example.com')
            ->assertExitCode(0);
    }

    /**
     * Test email:test command with invalid recipient fails with validation error.
     */
    public function test_email_test_artisan_command_with_invalid_recipient(): void
    {
        $this->artisan('email:test', ['recipient' => 'invalid-email-string'])
            ->expectsOutputToContain('Invalid recipient email address')
            ->assertExitCode(1);
    }

    /**
     * Test mail configuration handles scheme normalization and casts port to integer.
     */
    public function test_mail_configuration_handles_scheme_and_casts_port(): void
    {
        $smtpConfig = config('mail.mailers.smtp');

        // Port must be an integer
        $this->assertIsInt($smtpConfig['port']);

        // Scheme must be null or valid symfony scheme ('smtp' or 'smtps')
        $this->assertTrue(
            is_null($smtpConfig['scheme']) || in_array($smtpConfig['scheme'], ['smtp', 'smtps'], true),
            'Scheme must be null, smtp, or smtps to prevent Symfony Mailer UnsupportedSchemeException.'
        );

        // Brevo config in services
        $this->assertArrayHasKey('brevo', config('services'));
        $this->assertArrayHasKey('api_key', config('services.brevo'));
    }
}
