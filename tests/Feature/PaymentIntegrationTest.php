<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use App\Models\WebhookEvent;
use App\Services\PaymentProcessingService;
use App\Services\RazorpayService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected RoomType $roomType;
    protected Room $room1;
    protected Room $room2;
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
        Config::set('razorpay.reservation_duration_minutes', 15);

        // Seed room types & rooms
        $this->roomType = RoomType::create([
            'name' => 'Deluxe Suite',
            'slug' => 'deluxe-suite',
            'description' => 'Luxury room with city view',
            'base_price' => 2500,
            'max_occupancy' => 2,
            'is_active' => true,
        ]);

        $this->room1 = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '101',
            'current_price' => 2500,
            'is_available' => true,
        ]);

        $this->room2 = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '102',
            'current_price' => 2500,
            'is_available' => true,
        ]);
    }

    /**
     * Helper to create a test booking
     */
    protected function createBooking(array $overrides = []): Booking
    {
        $checkIn = Carbon::tomorrow();
        $checkOut = Carbon::tomorrow()->addDays(2);
        $baseAmount = 5000.00; // 2 nights * 2500
        $taxAmount = 600.00;   // 12% GST
        $totalAmount = 5600.00;

        $booking = Booking::create(array_merge([
            'booking_reference' => 'BK' . now()->format('YmdHis') . rand(100, 999),
            'customer_name' => 'Aditi Sharma',
            'customer_email' => 'aditi@example.com',
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
            'razorpay_order_id' => 'TEMP_BK12345',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ], $overrides));

        // Create temporary room allocation
        RoomAllocation::create([
            'booking_id' => $booking->id,
            'room_id' => $this->room1->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'temporary',
            'allocated_at' => now(),
        ]);

        return $booking;
    }

    /**
     * Test 1: Razorpay Order creation using trusted backend amount (converted to paise)
     */
    public function test_razorpay_order_created_with_trusted_backend_amount()
    {
        $booking = $this->createBooking();

        Http::fake([
            'https://api.razorpay.com/v1/orders' => Http::response([
                'id' => 'order_mock_12345',
                'entity' => 'order',
                'amount' => 560000, // 5600 INR = 560000 paise
                'currency' => 'INR',
                'status' => 'created',
            ], 200),
        ]);

        $response = $this->withSession([
            'verified_mobile' => $booking->customer_mobile,
            'otp_verified' => true,
        ])->get(route('booking.payment', ['booking' => $booking->id]));

        $response->assertStatus(200);
        $response->assertViewIs('booking.payment');
        $response->assertViewHas('checkoutData', function ($data) {
            return $data['amount'] === 560000 &&
                   $data['currency'] === 'INR' &&
                   $data['order_id'] === 'order_mock_12345' &&
                   $data['key'] === 'rzp_test_mock_key_123';
        });

        // Verify order saved to payments and bookings tables
        $this->assertDatabaseHas('payments', [
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'order_mock_12345',
            'amount' => 5600.00,
            'status' => 'created',
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'razorpay_order_id' => 'order_mock_12345',
        ]);
    }

    /**
     * Test 2: Prevent duplicate order creation by reusing active order within reservation window
     */
    public function test_active_razorpay_order_is_reused_within_reservation_window()
    {
        $booking = $this->createBooking(['razorpay_order_id' => 'order_existing_111']);

        // Create an existing active payment record
        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'order_existing_111',
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
            'created_at' => now()->subMinutes(2),
        ]);

        Http::fake(); // No HTTP calls should be made since order is reused

        $response = $this->withSession([
            'verified_mobile' => $booking->customer_mobile,
            'otp_verified' => true,
        ])->get(route('booking.payment', ['booking' => $booking->id]));

        $response->assertStatus(200);
        $response->assertViewHas('checkoutData', function ($data) {
            return $data['order_id'] === 'order_existing_111';
        });

        Http::assertNothingSent();
    }

    /**
     * Test 3: Anti-IDOR security check blocks unauthorized customer from accessing payment page
     */
    public function test_anti_idor_blocks_unauthorized_user()
    {
        $booking = $this->createBooking(['customer_mobile' => '9876543210']);

        // Authenticated with a different mobile number
        $response = $this->withSession([
            'verified_mobile' => '9111111111',
            'otp_verified' => true,
        ])->get(route('booking.payment', ['booking' => $booking->id]));

        $response->assertStatus(403);
    }

    /**
     * Test 4: Cryptographic verification rejects invalid HMAC-SHA256 signature
     */
    public function test_payment_verification_rejects_invalid_signature()
    {
        $booking = $this->createBooking(['razorpay_order_id' => 'order_secure_999']);

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'order_secure_999',
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        $invalidSignature = 'tampered_fake_signature_hash';

        $response = $this->withSession([
            'verified_mobile' => $booking->customer_mobile,
            'otp_verified' => true,
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => 'pay_test_001',
            'razorpay_order_id' => 'order_secure_999',
            'razorpay_signature' => $invalidSignature,
        ]);

        $response->assertRedirect(route('booking.payment', ['booking' => $booking->id]));
        $response->assertSessionHas('error');

        // Assert booking is NOT confirmed
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'payment_status' => 'pending',
        ]);
    }

    /**
     * Test 5: Valid signature confirms booking, captures payment, and updates allocations to confirmed
     */
    public function test_payment_verification_succeeds_with_valid_signature()
    {
        $booking = $this->createBooking(['razorpay_order_id' => 'order_valid_777']);
        $paymentId = 'pay_valid_888';
        $orderId = 'order_valid_777';

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $orderId,
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        // Generate legitimate HMAC-SHA256 signature
        $validSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->testKeySecret);

        // Mock Razorpay fetchPayment API returning matching amount
        Http::fake([
            "https://api.razorpay.com/v1/payments/{$paymentId}" => Http::response([
                'id' => $paymentId,
                'order_id' => $orderId,
                'amount' => 560000,
                'currency' => 'INR',
                'status' => 'captured',
                'method' => 'upi',
                'vpa' => 'aditi@upi',
                'fee' => 11200,
                'tax' => 2016,
            ], 200),
        ]);

        $response = $this->withSession([
            'verified_mobile' => $booking->customer_mobile,
            'otp_verified' => true,
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $validSignature,
        ]);

        $response->assertRedirect(route('booking.status', ['booking' => $booking->id]));
        $response->assertSessionHas('success');

        // Verify booking state
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
            'razorpay_payment_id' => $paymentId,
        ]);

        // Verify payment record state
        $this->assertDatabaseHas('payments', [
            'booking_id' => $booking->id,
            'razorpay_payment_id' => $paymentId,
            'status' => 'captured',
            'method' => 'upi',
        ]);

        // Verify room allocations are confirmed
        $this->assertDatabaseHas('room_allocations', [
            'booking_id' => $booking->id,
            'allocation_status' => 'confirmed',
        ]);
    }

    /**
     * Test 6: Payment verification is idempotent (re-verification does not duplicate or error)
     */
    public function test_payment_verification_is_idempotent()
    {
        $booking = $this->createBooking([
            'razorpay_order_id' => 'order_idem_111',
            'razorpay_payment_id' => 'pay_idem_222',
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'order_idem_111',
            'razorpay_payment_id' => 'pay_idem_222',
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'captured',
        ]);

        $validSignature = hash_hmac('sha256', 'order_idem_111|pay_idem_222', $this->testKeySecret);

        // Calling verify again on already paid booking
        $response = $this->withSession([
            'verified_mobile' => $booking->customer_mobile,
            'otp_verified' => true,
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => 'pay_idem_222',
            'razorpay_order_id' => 'order_idem_111',
            'razorpay_signature' => $validSignature,
        ]);

        $response->assertRedirect(route('booking.status', ['booking' => $booking->id]));
        $response->assertSessionHas('success');
    }

    /**
     * Test 7: Expired reservation with unavailable room triggers safe auto-refund (no overbooking)
     */
    public function test_expired_reservation_with_unavailable_room_triggers_auto_refund()
    {
        $booking = $this->createBooking(['razorpay_order_id' => 'order_expired_hold']);
        $paymentId = 'pay_late_capture_999';
        $orderId = 'order_expired_hold';

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $orderId,
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        // Release the booking's temporary allocation to simulate hold expiry
        RoomAllocation::where('booking_id', $booking->id)->update([
            'allocation_status' => 'released',
        ]);

        // Now allocate all rooms to another confirmed booking to make inventory 0
        $otherBooking = Booking::create([
            'booking_reference' => 'BK_OTHER_OCCUPIED',
            'customer_name' => 'Other Guest',
            'customer_email' => 'other@example.com',
            'customer_mobile' => '9999999999',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 2,
            'num_adults' => 2,
            'num_children' => 0,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
            'base_amount' => 10000,
            'tax_amount' => 1200,
            'total_amount' => 11200,
            'razorpay_order_id' => 'order_other_1',
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        RoomAllocation::create([
            'booking_id' => $otherBooking->id,
            'room_id' => $this->room1->id,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
            'allocation_status' => 'confirmed',
        ]);

        RoomAllocation::create([
            'booking_id' => $otherBooking->id,
            'room_id' => $this->room2->id,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
            'allocation_status' => 'confirmed',
        ]);

        $validSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->testKeySecret);

        // Mock Razorpay fetchPayment and refundPayment APIs
        Http::fake([
            "https://api.razorpay.com/v1/payments/{$paymentId}" => Http::response([
                'id' => $paymentId,
                'order_id' => $orderId,
                'amount' => 560000,
                'currency' => 'INR',
                'status' => 'captured',
            ], 200),
            "https://api.razorpay.com/v1/payments/{$paymentId}/refund" => Http::response([
                'id' => 'rfnd_auto_123',
                'payment_id' => $paymentId,
                'amount' => 560000,
                'status' => 'processed',
            ], 200),
        ]);

        $response = $this->withSession([
            'verified_mobile' => $booking->customer_mobile,
            'otp_verified' => true,
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $validSignature,
        ]);

        $response->assertRedirect(route('booking.status', ['booking' => $booking->id]));
        $response->assertSessionHas('error');

        // Assert overbooking was PREVENTED: booking cancelled and refunded
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'booking_status' => 'cancelled',
            'payment_status' => 'refunded',
        ]);

        $this->assertDatabaseHas('payments', [
            'booking_id' => $booking->id,
            'status' => 'refunded',
            'refund_id' => 'rfnd_auto_123',
        ]);
    }

    /**
     * Test 8: Webhook rejects unverified signature
     */
    public function test_webhook_rejects_invalid_signature()
    {
        $payload = json_encode([
            'event' => 'payment.captured',
            'event_id' => 'evt_fake_001',
        ]);

        $response = $this->call(
            'POST',
            route('webhooks.razorpay'),
            [],
            [],
            [],
            [
                'HTTP_X-Razorpay-Signature' => 'invalid_webhook_signature',
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload
        );

        $response->assertStatus(400);
        $response->assertJson(['status' => 'error']);
    }

    /**
     * Test 9: Webhook processes payment.captured and handles duplicates idempotently
     */
    public function test_webhook_payment_captured_processes_and_is_idempotent()
    {
        $booking = $this->createBooking(['razorpay_order_id' => 'order_webhook_123']);

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'order_webhook_123',
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        $webhookData = [
            'entity' => 'event',
            'event' => 'payment.captured',
            'event_id' => 'evt_captured_unique_1',
            'payload' => [
                'payment' => [
                    'entity' => [
                        'id' => 'pay_webhook_captured_99',
                        'order_id' => 'order_webhook_123',
                        'amount' => 560000,
                        'currency' => 'INR',
                        'status' => 'captured',
                        'method' => 'card',
                    ],
                ],
            ],
        ];

        $rawBody = json_encode($webhookData);
        $validSignature = hash_hmac('sha256', $rawBody, $this->testWebhookSecret);

        // 1st Webhook delivery
        $response1 = $this->call(
            'POST',
            route('webhooks.razorpay'),
            [],
            [],
            [],
            [
                'HTTP_X-Razorpay-Signature' => $validSignature,
                'CONTENT_TYPE' => 'application/json',
            ],
            $rawBody
        );

        $response1->assertStatus(200);

        // Assert booking confirmed
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        $this->assertDatabaseHas('webhook_events', [
            'event_id' => 'evt_captured_unique_1',
        ]);
        $this->assertTrue(WebhookEvent::where('event_id', 'evt_captured_unique_1')->first()->isProcessed());

        // 2nd Webhook delivery (duplicate/retry)
        $response2 = $this->call(
            'POST',
            route('webhooks.razorpay'),
            [],
            [],
            [],
            [
                'HTTP_X-Razorpay-Signature' => $validSignature,
                'CONTENT_TYPE' => 'application/json',
            ],
            $rawBody
        );

        $response2->assertStatus(200);
        $response2->assertJson(['status' => 'success', 'message' => 'Webhook event already processed (idempotent)']);
    }

    /**
     * Test 10: Webhook handles payment.failed safely
     */
    public function test_webhook_handles_payment_failed()
    {
        $booking = $this->createBooking(['razorpay_order_id' => 'order_fail_333']);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'order_fail_333',
            'amount' => $booking->total_amount,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        $webhookData = [
            'entity' => 'event',
            'event' => 'payment.failed',
            'event_id' => 'evt_failed_001',
            'payload' => [
                'payment' => [
                    'entity' => [
                        'id' => 'pay_failed_444',
                        'order_id' => 'order_fail_333',
                        'amount' => 560000,
                        'currency' => 'INR',
                        'status' => 'failed',
                        'error_code' => 'BAD_REQUEST_ERROR',
                        'error_description' => 'Card was declined by bank',
                    ],
                ],
            ],
        ];

        $rawBody = json_encode($webhookData);
        $validSignature = hash_hmac('sha256', $rawBody, $this->testWebhookSecret);

        $response = $this->call(
            'POST',
            route('webhooks.razorpay'),
            [],
            [],
            [],
            [
                'HTTP_X-Razorpay-Signature' => $validSignature,
                'CONTENT_TYPE' => 'application/json',
            ],
            $rawBody
        );

        $response->assertStatus(200);

        // Assert payment recorded as failed
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'failed',
            'error_code' => 'BAD_REQUEST_ERROR',
            'error_description' => 'Card was declined by bank',
        ]);
    }
}
