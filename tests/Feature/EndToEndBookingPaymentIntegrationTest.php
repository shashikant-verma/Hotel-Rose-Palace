<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use App\Models\WebhookEvent;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Exception;

class EndToEndBookingPaymentIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected RoomType $roomType;
    protected Room $room101;
    protected Room $room102;
    protected string $keyId = 'rzp_test_e2e_key_111';
    protected string $keySecret = 'test_e2e_secret_222';
    protected string $webhookSecret = 'test_e2e_webhook_333';

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('razorpay.key_id', $this->keyId);
        Config::set('razorpay.key_secret', $this->keySecret);
        Config::set('razorpay.webhook_secret', $this->webhookSecret);
        Config::set('razorpay.currency', 'INR');
        Config::set('razorpay.reservation_duration_minutes', 30);

        // Setup Room Types and 2 Physical Rooms
        $this->roomType = RoomType::create([
            'name' => 'Royal Heritage Suite',
            'slug' => 'royal-heritage-suite',
            'description' => 'Palatial room with royal decor',
            'base_price' => 3000,
            'max_occupancy' => 2,
            'is_active' => true,
        ]);

        $this->room101 = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '101',
            'current_price' => 3000,
            'is_available' => true,
        ]);

        $this->room102 = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '102',
            'current_price' => 3000,
            'is_available' => true,
        ]);
    }

    /**
     * Test 1: Full 11-step customer booking-to-payment lifecycle
     */
    public function test_complete_customer_booking_to_payment_lifecycle()
    {
        $checkIn = Carbon::tomorrow()->startOfDay();
        $checkOut = Carbon::tomorrow()->addDays(2)->startOfDay(); // 2 nights
        $customerMobile = '9876543210';
        $customerEmail = 'priya.sharma@example.com';
        $customerName = 'Priya Sharma';

        // Step 1: Customer searches for available rooms
        $availResponse = $this->postJson(route('booking.check-availability'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => $this->roomType->id,
        ]);

        $availResponse->assertStatus(200);
        $availResponse->assertJsonPath('success', true);
        $availResponse->assertJsonPath('availability.available_rooms', 2);
        $availResponse->assertJsonPath('availability.nights', 2);
        // Pricing: 2 nights * 3000 = 6000 + 12% GST (720) = 6720
        $availResponse->assertJsonPath('pricing.grand_total', 6720);

        // Step 2 & 3: Customer with verified OTP submits booking details
        $storeResponse = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $customerMobile,
            'verified_at' => now()->timestamp,
        ])->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => $this->roomType->id,
            'quantity' => 1,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'total_guests' => 2,
            'special_requests' => 'Quiet room on upper floor',
        ]);

        $storeResponse->assertStatus(302);
        $booking = Booking::latest()->first();
        $this->assertNotNull($booking);

        // Step 4: Verify backend pricing and temporary reservation state
        $this->assertEquals(6000.00, $booking->base_amount);
        $this->assertEquals(720.00, $booking->tax_amount);
        $this->assertEquals(6720.00, $booking->total_amount);
        $this->assertEquals('pending', $booking->payment_status);

        // Step 5: Temporary room allocation is created and linked to the booking
        $allocations = RoomAllocation::where('booking_id', $booking->id)->get();
        $this->assertCount(1, $allocations);
        $this->assertEquals('temporary', $allocations->first()->allocation_status);

        // Step 6 & 7: Customer reaches payment checkout -> Razorpay Order created
        $mockOrderId = 'order_e2e_live_456';
        Http::fake([
            'https://api.razorpay.com/v1/orders' => Http::response([
                'id' => $mockOrderId,
                'entity' => 'order',
                'amount' => 672000, // 6720 * 100 paise
                'currency' => 'INR',
                'status' => 'created',
            ], 200),
        ]);

        $checkoutResponse = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $customerMobile,
        ])->get(route('booking.payment', ['booking' => $booking->id]));

        $checkoutResponse->assertStatus(200);
        $checkoutResponse->assertViewIs('booking.payment');
        $checkoutResponse->assertViewHas('checkoutData', function ($data) use ($mockOrderId) {
            return $data['order_id'] === $mockOrderId &&
                   $data['amount'] === 672000 &&
                   $data['currency'] === 'INR';
        });

        // Step 8 & 9: Customer completes payment on checkout -> Verification
        $mockPaymentId = 'pay_e2e_success_789';
        $validSignature = hash_hmac('sha256', "{$mockOrderId}|{$mockPaymentId}", $this->keySecret);

        Http::fake([
            "https://api.razorpay.com/v1/payments/{$mockPaymentId}" => Http::response([
                'id' => $mockPaymentId,
                'order_id' => $mockOrderId,
                'amount' => 672000,
                'currency' => 'INR',
                'status' => 'captured',
                'method' => 'upi',
                'vpa' => 'priya@okhdfcbank',
                'fee' => 13440,
                'tax' => 2419,
            ], 200),
        ]);

        $verifyResponse = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $customerMobile,
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => $mockPaymentId,
            'razorpay_order_id' => $mockOrderId,
            'razorpay_signature' => $validSignature,
        ]);

        $verifyResponse->assertRedirect(route('booking.status', ['booking' => $booking->id]));
        $verifyResponse->assertSessionHas('success');

        // Step 10 & 11: Booking confirmed, payment captured, temporary allocation converted to confirmed
        $freshBooking = $booking->fresh();
        $this->assertEquals('paid', $freshBooking->payment_status);
        $this->assertEquals('confirmed', $freshBooking->booking_status);
        $this->assertEquals($mockPaymentId, $freshBooking->razorpay_payment_id);
        $this->assertTrue($freshBooking->isConfirmed());

        $freshAllocation = $allocations->first()->fresh();
        $this->assertEquals('confirmed', $freshAllocation->allocation_status);

        $this->assertDatabaseHas('payments', [
            'booking_id' => $freshBooking->id,
            'razorpay_order_id' => $mockOrderId,
            'razorpay_payment_id' => $mockPaymentId,
            'status' => 'captured',
            'amount' => 6720.00,
        ]);
    }

    /**
     * Test 2: Unpaid bookings cannot be treated as successfully confirmed bookings
     */
    public function test_unpaid_booking_cannot_be_treated_as_confirmed()
    {
        $booking = Booking::create([
            'booking_reference' => 'BK_UNPAID_123',
            'customer_name' => 'Rahul Verma',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'check_in_date' => Carbon::tomorrow(),
            'check_out_date' => Carbon::tomorrow()->addDays(2),
            'base_amount' => 6000,
            'tax_amount' => 720,
            'total_amount' => 6720,
            'razorpay_order_id' => 'TEMP_UNPAID',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        RoomAllocation::create([
            'booking_id' => $booking->id,
            'room_id' => $this->room101->id,
            'check_in_date' => Carbon::tomorrow(),
            'check_out_date' => Carbon::tomorrow()->addDays(2),
            'allocation_status' => 'temporary',
        ]);

        // Unpaid booking should report awaiting payment status, NOT confirmed
        $this->assertEquals('pending_payment', $booking->status);
        $this->assertFalse($booking->isConfirmed());

        // Status view displays Awaiting Payment
        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
        ])->get(route('booking.status', ['booking' => $booking->id]));

        $response->assertStatus(200);
        $response->assertSee('Awaiting Payment');
        $response->assertSee('Payment Pending');
    }

    /**
     * Test 3: Duplicate payment prevention (re-checkout blocked for already paid booking)
     */
    public function test_duplicate_payment_prevention_for_already_paid_booking()
    {
        $booking = Booking::create([
            'booking_reference' => 'BK_PAID_ALREADY',
            'customer_name' => 'Amit Shah',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'check_in_date' => Carbon::tomorrow(),
            'check_out_date' => Carbon::tomorrow()->addDays(2),
            'base_amount' => 6000,
            'tax_amount' => 720,
            'total_amount' => 6720,
            'razorpay_order_id' => 'order_paid_already',
            'razorpay_payment_id' => 'pay_completed_999',
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        // Attempting to access payment page for an already paid booking redirects to status
        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
        ])->get(route('booking.payment', ['booking' => $booking->id]));

        $response->assertRedirect(route('booking.status', ['booking' => $booking->id]));
        $response->assertSessionHas('info');
    }

    /**
     * Test 4: Payment failure logs attempt and keeps booking pending for retry
     */
    public function test_payment_failure_handling_and_retry_readiness()
    {
        $booking = Booking::create([
            'booking_reference' => 'BK_FAIL_TEST',
            'customer_name' => 'Sunil Gupta',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'check_in_date' => Carbon::tomorrow(),
            'check_out_date' => Carbon::tomorrow()->addDays(2),
            'base_amount' => 6000,
            'tax_amount' => 720,
            'total_amount' => 6720,
            'razorpay_order_id' => 'order_fail_attempt',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
        ])->post(route('booking.payment.failed', ['booking' => $booking->id]), [
            'error_code' => 'PAYMENT_CANCELLED_BY_USER',
            'error_description' => 'Customer dismissed checkout',
        ]);

        $response->assertRedirect(route('booking.payment', ['booking' => $booking->id]));
        $response->assertSessionHas('warning');

        // Booking remains pending so the customer can retry within hold window
        $this->assertEquals('pending', $booking->fresh()->payment_status);
        $this->assertDatabaseHas('payment_logs', [
            'booking_id' => $booking->id,
            'event' => 'payment.cancelled_by_user',
        ]);
    }

    /**
     * Test 5: Expired reservation with late payment prevents overbooking with verified auto-refund
     */
    public function test_late_successful_payment_after_hold_expiry_prevents_overbooking_and_auto_refunds()
    {
        $checkIn = Carbon::tomorrow();
        $checkOut = Carbon::tomorrow()->addDays(2);

        $booking = Booking::create([
            'booking_reference' => 'BK_HOLD_EXPIRED',
            'customer_name' => 'Meera Patel',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'base_amount' => 6000,
            'tax_amount' => 720,
            'total_amount' => 6720,
            'razorpay_order_id' => 'order_late_expired',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        $orderId = 'order_late_expired';
        $paymentId = 'pay_late_captured_111';

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $orderId,
            'amount' => 6720.00,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        // Both physical rooms are now booked by other confirmed guests
        RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->room101->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);

        RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->room102->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);

        $validSignature = hash_hmac('sha256', "{$orderId}|{$paymentId}", $this->keySecret);

        // Mock Razorpay payment fetch and refund API (returns 'processed')
        Http::fake([
            "https://api.razorpay.com/v1/payments/{$paymentId}" => Http::response([
                'id' => $paymentId,
                'order_id' => $orderId,
                'amount' => 672000,
                'currency' => 'INR',
                'status' => 'captured',
            ], 200),
            "https://api.razorpay.com/v1/payments/{$paymentId}/refund" => Http::response([
                'id' => 'rfnd_auto_confirmed_999',
                'payment_id' => $paymentId,
                'amount' => 672000,
                'status' => 'processed',
            ], 200),
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $validSignature,
        ]);

        $response->assertRedirect(route('booking.status', ['booking' => $booking->id]));
        $response->assertSessionHas('error');

        // Overbooking is prevented: booking cancelled, 100% refund confirmed
        $freshBooking = $booking->fresh();
        $this->assertEquals('cancelled', $freshBooking->booking_status);
        $this->assertEquals('refunded', $freshBooking->payment_status);

        $this->assertDatabaseHas('payments', [
            'booking_id' => $booking->id,
            'status' => 'refunded',
            'refund_id' => 'rfnd_auto_confirmed_999',
            'refund_status' => 'processed',
        ]);
    }

    /**
     * Test 6: Refund failure / gateway pending safely tracks 'refund_pending' without crashing
     */
    public function test_refund_gateway_error_safely_tracks_refund_pending_for_reconciliation()
    {
        $checkIn = Carbon::tomorrow();
        $checkOut = Carbon::tomorrow()->addDays(2);

        $booking = Booking::create([
            'booking_reference' => 'BK_REFUND_FAIL_SAFE',
            'customer_name' => 'Karan Malhotra',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'base_amount' => 6000,
            'tax_amount' => 720,
            'total_amount' => 6720,
            'razorpay_order_id' => 'order_refund_fail_safe',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        $orderId = 'order_refund_fail_safe';
        $paymentId = 'pay_refund_fail_222';

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => $orderId,
            'amount' => 6720.00,
            'currency' => 'INR',
            'status' => 'created',
        ]);

        // Make inventory 0
        RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->room101->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);
        RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->room102->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);

        $validSignature = hash_hmac('sha256', "{$orderId}|{$paymentId}", $this->keySecret);

        // Mock fetch payment success, but refund API throws a gateway error 500
        Http::fake([
            "https://api.razorpay.com/v1/payments/{$paymentId}" => Http::response([
                'id' => $paymentId,
                'order_id' => $orderId,
                'amount' => 672000,
                'currency' => 'INR',
                'status' => 'captured',
            ], 200),
            "https://api.razorpay.com/v1/payments/{$paymentId}/refund" => Http::response([
                'error' => [
                    'code' => 'GATEWAY_ERROR',
                    'description' => 'Downstream bank gateway timeout',
                ],
            ], 500),
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
        ])->post(route('booking.payment.verify', ['booking' => $booking->id]), [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $validSignature,
        ]);

        $response->assertRedirect(route('booking.status', ['booking' => $booking->id]));

        // Overbooking is STILL prevented; refund status is marked as 'refund_pending' for admin attention
        $freshBooking = $booking->fresh();
        $this->assertEquals('cancelled', $freshBooking->booking_status);
        $this->assertEquals('pending', $freshBooking->payment_status);

        $this->assertDatabaseHas('payments', [
            'booking_id' => $booking->id,
            'status' => 'refund_pending',
            'refund_status' => 'failed',
        ]);
    }
}
