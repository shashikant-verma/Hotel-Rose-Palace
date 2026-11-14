<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerBookingManagementTest extends TestCase
{
    use RefreshDatabase;

    protected RoomType $roomType;
    protected Room $room101;
    protected string $mobileA = '9876543210';
    protected string $mobileB = '9999999999';

    protected function setUp(): void
    {
        parent::setUp();

        $this->roomType = RoomType::create([
            'name' => 'Presidential Suite',
            'slug' => 'presidential-suite',
            'description' => 'Luxury suite with terrace',
            'base_price' => 5000,
            'max_occupancy' => 2,
            'is_active' => true,
        ]);

        $this->room101 = Room::create([
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
        static $counter = 0;
        $counter++;
        
        return Booking::create(array_merge([
            'booking_reference' => 'BK' . now()->format('YmdHis') . rand(100, 999),
            'customer_name' => 'Ananya Iyer',
            'customer_email' => 'ananya@example.com',
            'customer_mobile' => $this->mobileA,
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'num_adults' => 2,
            'num_children' => 0,
            'check_in_date' => Carbon::tomorrow(),
            'check_out_date' => Carbon::tomorrow()->addDays(2),
            'base_amount' => 10000.00,
            'tax_amount' => 1200.00,
            'total_amount' => 11200.00,
            'razorpay_order_id' => 'order_test_' . time() . '_' . $counter,
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ], $overrides));
    }

    /**
     * Test 1: OTP-verified customer can view booking history
     */
    public function test_otp_verified_customer_can_view_booking_history()
    {
        $booking1 = $this->createBooking(['booking_reference' => 'BK_HIST_001']);
        $booking2 = $this->createBooking(['booking_reference' => 'BK_HIST_002']);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.index'));

        $response->assertStatus(200);
        $response->assertViewIs('customer.bookings.index');
        $response->assertSee('BK_HIST_001');
        $response->assertSee('BK_HIST_002');
        $response->assertSee($this->mobileA);
    }

    /**
     * Test 2: Unverified customer cannot access booking history
     */
    public function test_unverified_customer_cannot_access_booking_history()
    {
        $response = $this->get(route('customer.bookings.index'));

        $response->assertRedirect(route('otp.send.form', ['purpose' => 'manage_bookings']));
        $response->assertSessionHas('error');
    }

    /**
     * Test 3: Customer can view their own booking details
     */
    public function test_customer_can_view_own_booking_details()
    {
        $booking = $this->createBooking(['booking_reference' => 'BK_OWN_DETAILS']);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.show', ['booking' => $booking->id]));

        $response->assertStatus(200);
        $response->assertViewIs('customer.bookings.show');
        $response->assertSee('BK_OWN_DETAILS');
        $response->assertSee('Ananya Iyer');
        $response->assertSee('₹11,200.00');
    }

    /**
     * Test 4: Customer cannot access another customer's booking (Anti-IDOR)
     */
    public function test_customer_cannot_access_another_customers_booking()
    {
        // Booking belongs to Customer B
        $bookingOther = $this->createBooking([
            'customer_mobile' => $this->mobileB,
            'customer_name' => 'Stranger Customer',
            'booking_reference' => 'BK_STRANGER_001',
        ]);

        // Customer A tries to access Customer B's booking
        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.show', ['booking' => $bookingOther->id]));

        $response->assertStatus(403);
    }

    /**
     * Test 5: Booking history displays correct payment status
     */
    public function test_booking_history_displays_correct_payment_status()
    {
        $paidBooking = $this->createBooking([
            'booking_reference' => 'BK_PAID_001',
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
        ]);

        $pendingBooking = $this->createBooking([
            'booking_reference' => 'BK_PENDING_001',
            'payment_status' => 'pending',
            'booking_status' => 'confirmed',
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee('Confirmed');
        $response->assertSee('Pending Payment');
    }

    /**
     * Test 6: Unpaid booking is not displayed as confirmed and cannot access confirmation receipt
     */
    public function test_unpaid_booking_cannot_access_confirmation_receipt()
    {
        $unpaidBooking = $this->createBooking([
            'booking_reference' => 'BK_UNPAID_CONF_TEST',
            'payment_status' => 'pending',
            'booking_status' => 'confirmed',
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.confirmation', ['booking' => $unpaidBooking->id]));

        // Redirects to details page with warning
        $response->assertRedirect(route('customer.bookings.show', ['booking' => $unpaidBooking->id]));
        $response->assertSessionHas('warning');

        // On details page, unpaid status is displayed as Awaiting Payment with Pay button
        $detailsResponse = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.show', ['booking' => $unpaidBooking->id]));

        $detailsResponse->assertStatus(200);
        $detailsResponse->assertSee('Awaiting Payment');
        $detailsResponse->assertSee('Pay Now');
    }

    /**
     * Test 7: Successfully paid booking displays confirmation receipt
     */
    public function test_successfully_paid_booking_displays_confirmation_receipt()
    {
        $paidBooking = $this->createBooking([
            'booking_reference' => 'BK_CONFIRMED_VOUCHER',
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
            'razorpay_payment_id' => 'pay_receipt_valid_999',
        ]);

        Payment::create([
            'booking_id' => $paidBooking->id,
            'razorpay_order_id' => $paidBooking->razorpay_order_id,
            'razorpay_payment_id' => 'pay_receipt_valid_999',
            'amount' => 11200.00,
            'currency' => 'INR',
            'status' => 'captured',
            'method' => 'card',
            'card_network' => 'Visa',
            'card_last4' => '4242',
            'captured_at' => now(),
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.confirmation', ['booking' => $paidBooking->id]));

        $response->assertStatus(200);
        $response->assertViewIs('customer.bookings.confirmation');
        $response->assertSee('BK_CONFIRMED_VOUCHER');
        $response->assertSee('Confirmed');
        $response->assertSee('pay_receipt_valid_999');
        $response->assertSee('Official Booking Voucher');
    }

    /**
     * Test 8: Failed payment displays the correct status
     */
    public function test_failed_payment_displays_correct_status()
    {
        $failedBooking = $this->createBooking([
            'booking_reference' => 'BK_FAILED_ATTEMPT',
            'payment_status' => 'pending',
            'booking_status' => 'confirmed',
        ]);

        Payment::create([
            'booking_id' => $failedBooking->id,
            'razorpay_order_id' => $failedBooking->razorpay_order_id,
            'amount' => 11200.00,
            'currency' => 'INR',
            'status' => 'failed',
            'error_code' => 'BAD_REQUEST_ERROR',
            'error_description' => 'Payment declined by bank',
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.index', ['tab' => 'failed']));

        $response->assertStatus(200);
        $response->assertSee('BK_FAILED_ATTEMPT');
        $response->assertSee('Payment Failed');
    }

    /**
     * Test 9: Cancelled booking displays correctly
     */
    public function test_cancelled_booking_displays_correctly()
    {
        $cancelledBooking = $this->createBooking([
            'booking_reference' => 'BK_CANCELLED_001',
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'Guest cancelled travel plans',
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.index', ['tab' => 'cancelled']));

        $response->assertStatus(200);
        $response->assertSee('BK_CANCELLED_001');
        $response->assertSee('Cancelled');
    }

    /**
     * Test 10: Booking history pagination works
     */
    public function test_booking_history_pagination_works()
    {
        // Create 15 bookings for Customer A
        for ($i = 1; $i <= 15; $i++) {
            $this->createBooking([
                'booking_reference' => 'BK_PAGE_' . sprintf('%03d', $i),
                'created_at' => now()->subMinutes(15 - $i),
            ]);
        }

        // Page 1: contains 10 items
        $page1Response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.index', ['page' => 1]));

        $page1Response->assertStatus(200);
        $page1Response->assertSee('BK_PAGE_015');

        // Page 2: contains remaining 5 items
        $page2Response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.index', ['page' => 2]));

        $page2Response->assertStatus(200);
        $page2Response->assertSee('BK_PAGE_001');
    }

    /**
     * Test 11: Empty booking history displays correctly
     */
    public function test_empty_booking_history_displays_correctly()
    {
        // Authenticated with a mobile number that has zero bookings
        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => '9123456789',
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee('No Bookings Found');
        $response->assertSee('Browse & Book Rooms');
    }

    /**
     * Test 12: Booking details do not expose sensitive payment information
     */
    public function test_booking_details_do_not_expose_sensitive_payment_information()
    {
        $booking = $this->createBooking([
            'booking_reference' => 'BK_SECURITY_CHECK',
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'razorpay_order_id' => 'order_sec_123',
            'razorpay_payment_id' => 'pay_sec_456',
            'razorpay_signature' => 'secret_hmac_signature_hash_do_not_leak',
            'amount' => 11200.00,
            'currency' => 'INR',
            'status' => 'captured',
            'payload' => [
                'secret_merchant_key' => 'super_secret_merchant_token',
                'internal_routing' => 'private_datacenter_ip_10.0.0.1',
            ],
            'raw_response' => [
                'acquirer_data' => ['auth_code' => '998877'],
            ],
            'captured_at' => now(),
        ]);

        $response = $this->withSession([
            'otp_verified' => true,
            'verified_mobile' => $this->mobileA,
            'verified_at' => now()->timestamp,
        ])->get(route('customer.bookings.show', ['booking' => $booking->id]));

        $response->assertStatus(200);
        // Exposes public reference
        $response->assertSee('pay_sec_456');

        // Does NOT leak internal signatures, secrets or payload
        $response->assertDontSee('secret_hmac_signature_hash_do_not_leak');
        $response->assertDontSee('super_secret_merchant_token');
        $response->assertDontSee('private_datacenter_ip');
    }
}
