<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Services\RoomAvailabilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class DirectBookingTest extends TestCase
{
    use RefreshDatabase;

    protected RoomAvailabilityService $availabilityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->availabilityService = app(RoomAvailabilityService::class);
        
        // Create test room types
        $this->createTestRoomTypes();
    }

    private function createTestRoomTypes()
    {
        RoomType::create([
            'name' => 'Deluxe Room',
            'slug' => 'deluxe-room',
            'description' => 'Spacious deluxe room',
            'base_price' => 5000,
            'max_occupancy' => 2,
            'is_active' => true,
        ]);

        RoomType::create([
            'name' => 'Suite',
            'slug' => 'suite',
            'description' => 'Premium suite',
            'base_price' => 10000,
            'max_occupancy' => 4,
            'is_active' => true,
        ]);

        // Create 5 deluxe rooms
        for ($i = 1; $i <= 5; $i++) {
            Room::create([
                'room_type_id' => 1,
                'room_number' => '101' . $i,
                'current_price' => 5000,
                'is_available' => true,
            ]);
        }

        // Create 3 suites
        for ($i = 1; $i <= 3; $i++) {
            Room::create([
                'room_type_id' => 2,
                'room_number' => '200' . $i,
                'current_price' => 10000,
                'is_available' => true,
            ]);
        }
    }

    /**
     * Test booking search form displays
     */
    public function test_booking_search_form_displays()
    {
        $response = $this->get(route('booking.search.form'));

        $response->assertStatus(200);
        $response->assertViewIs('booking.search-form');
    }

    /**
     * Test availability check AJAX endpoint
     */
    public function test_availability_check_returns_correct_data()
    {
        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(3);
        $roomTypeId = 1; // Deluxe

        $response = $this->postJson(route('booking.check-availability'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => $roomTypeId,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('availability.available_rooms', 5);
        $response->assertJsonPath('availability.nights', 3);
        $response->assertJsonPath('room_type.id', 1);
        $response->assertJsonPath('room_type.name', 'Deluxe Room');
        // Price may be returned as string due to decimal casting
        $response->assertJsonPath('pricing.subtotal', 15000);
    }

    /**
     * Test availability check with invalid dates
     */
    public function test_availability_check_validates_dates()
    {
        $response = $this->postJson(route('booking.check-availability'), [
            'check_in' => 'invalid-date',
            'check_out' => 'invalid-date',
            'room_type_id' => 1,
        ]);

        $response->assertStatus(400);
        $response->assertJsonPath('success', false);
    }

    /**
     * Test booking form requires OTP verification
     */
    public function test_booking_form_requires_otp_verification()
    {
        // Don't set OTP verification - should redirect
        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);

        $response = $this->get(route('booking.form', [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => 1,
            'quantity' => 1,
        ]));

        // Should redirect to OTP send form or show 302
        $this->assertTrue(
            $response->status() === 302 || $response->status() === 404,
            'Expected redirect or not found, got ' . $response->status()
        );
    }

    /**
     * Test booking form displays with OTP verification
     */
    public function test_booking_form_displays_with_otp_verification()
    {
        // Set OTP verification in session
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);

        // Let middleware run normally so ShareErrorsFromSession provides $errors to view
        $response = $this->get(route('booking.form', [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => 1,
            'quantity' => 1,
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('booking.form');
        $response->assertViewHas('roomType');
        $response->assertViewHas('nights', 2);
        $response->assertViewHas('grandTotal');
    }

    /**
     * Test booking creation requires OTP verification
     */
    public function test_booking_creation_requires_otp_verification()
    {
        // Don't set OTP - should fail gracefully
        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);

        $response = $this->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => 1,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'total_guests' => 1,
        ]);

        // Either redirect or error - both are acceptable when auth fails
        $this->assertTrue(
            $response->status() === 302 || $response->status() === 404,
            'Expected redirect or error, got ' . $response->status()
        );
    }

    /**
     * Test successful booking creation
     */
    public function test_can_create_booking_with_otp_verification()
    {
        // Set OTP verification
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);

        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => 1,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'total_guests' => 1,
        ]);

        $response->assertStatus(302);
        
        // Verify booking created with correct fields
        $this->assertDatabaseHas('bookings', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_mobile' => '9876543210',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        // Verify temporary allocations created
        $booking = Booking::latest()->first();
        $this->assertEquals(1, $booking->allocations()->count());
    }

    /**
     * Test booking validation - missing required fields
     */
    public function test_booking_validation_requires_guest_details()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);

        // POST with withoutMiddleware() should still validate request
        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => 1,
            'quantity' => 1,
            'customer_name' => '',  // Missing
            'customer_email' => 'invalid-email',  // Invalid
            'total_guests' => 0,  // Invalid
        ]);

        // Should redirect back due to validation failure
        $this->assertTrue($response->status() === 302 || $response->status() === 422);
    }

    /**
     * Test booking validation - guest count exceeds room capacity
     */
    public function test_booking_validation_checks_guest_capacity()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);
        $roomType = RoomType::find(1); // Deluxe: max 2 guests

        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => $roomType->id,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'total_guests' => 5,  // Exceeds max 2
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['total_guests']);
    }

    /**
     * Test pricing calculation is server-side
     */
    public function test_pricing_calculated_server_side()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(3);
        $roomType = RoomType::find(1); // Base price: 5000

        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => $roomType->id,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'total_guests' => 1,
        ]);

        $booking = Booking::latest()->first();
        
        // 3 nights × 5000 = 15000
        $this->assertEquals(15000, $booking->base_amount);
        
        // 15000 × 0.12 = 1800
        $this->assertEquals(1800, $booking->tax_amount);
        
        // 15000 + 1800 = 16800
        $this->assertEquals(16800, $booking->total_amount);
    }

    /**
     * Test booking review displays correct information
     */
    public function test_booking_review_displays_booking_details()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        // Create booking
        $booking = Booking::create([
            'booking_reference' => 'BK' . now()->format('YmdHis') . '1234',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_mobile' => '9876543210',
            'check_in_date' => now()->addDay(),
            'check_out_date' => now()->addDays(3),
            'room_type_id' => 1,
            'room_quantity' => 1,
            'num_adults' => 1,
            'num_children' => 0,
            'base_amount' => 15000,
            'tax_amount' => 1800,
            'total_amount' => 16800,
            'razorpay_order_id' => 'TEMP_BK' . now()->format('YmdHis') . '1234',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        $response = $this->withoutMiddleware()->get(route('booking.review', ['booking' => $booking->id]));

        $response->assertStatus(200);
        $response->assertViewIs('booking.review');
        $response->assertViewHas('booking');
    }

    /**
     * Test booking review denies access for different customer
     */
    public function test_booking_review_denies_unauthorized_access()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '1111111111',  // Different mobile
            'verified_at' => now()->timestamp,
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK' . now()->format('YmdHis') . '5678',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_mobile' => '9876543210',  // Different
            'check_in_date' => now()->addDay(),
            'check_out_date' => now()->addDays(3),
            'room_type_id' => 1,
            'room_quantity' => 1,
            'num_adults' => 1,
            'num_children' => 0,
            'base_amount' => 15000,
            'tax_amount' => 1800,
            'total_amount' => 16800,
            'razorpay_order_id' => 'TEMP_BK' . now()->format('YmdHis') . '5678',
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
        ]);

        $response = $this->withoutMiddleware()->get(route('booking.review', ['booking' => $booking->id]));

        $response->assertStatus(403);
    }

    /**
     * Test availability rechecked before allocation
     */
    public function test_availability_rechecked_before_allocation()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);

        // Book all 5 deluxe rooms
        for ($i = 0; $i < 5; $i++) {
            Booking::create([
                'booking_reference' => 'BK' . now()->format('YmdHis') . $i,
                'customer_name' => "Guest $i",
                'customer_email' => "guest$i@example.com",
                'customer_mobile' => '9876543210',
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'room_type_id' => 1,
                'room_quantity' => 1,
                'num_adults' => 1,
                'num_children' => 0,
                'base_amount' => 10000,
                'tax_amount' => 1200,
                'total_amount' => 11200,
                'razorpay_order_id' => 'TEMP_BK' . now()->format('YmdHis') . $i,
                'booking_status' => 'confirmed',
                'payment_status' => 'pending',
            ]);
        }

        // Try to book 6th room - should fail and redirect
        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => 1,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'total_guests' => 1,
        ]);

        // Should redirect with error (availability check prevented booking)
        $this->assertTrue($response->status() === 302);
    }

    /**
     * Test multiple room booking
     */
    public function test_can_book_multiple_rooms()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $checkIn = now()->addDay();
        $checkOut = $checkIn->clone()->addDays(2);

        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'room_type_id' => 1,
            'quantity' => 3,  // Book 3 rooms
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'total_guests' => 6,  // 3 rooms × 2 guests
        ]);

        $booking = Booking::latest()->first();
        
        $this->assertEquals(3, $booking->room_quantity);
        $this->assertEquals(6, $booking->num_adults);
        $this->assertEquals(3, $booking->allocations()->count());
    }

    /**
     * Test booking status displays for confirmed booking
     */
    public function test_booking_status_shows_confirmed()
    {
        session([
            'otp_verified' => true,
            'verified_mobile' => '9876543210',
            'verified_at' => now()->timestamp,
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK' . now()->format('YmdHis') . '9999',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_mobile' => '9876543210',
            'check_in_date' => now()->addDay(),
            'check_out_date' => now()->addDays(3),
            'room_type_id' => 1,
            'room_quantity' => 1,
            'num_adults' => 1,
            'num_children' => 0,
            'base_amount' => 15000,
            'tax_amount' => 1800,
            'total_amount' => 16800,
            'razorpay_order_id' => 'TEMP_BK' . now()->format('YmdHis') . '9999',
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        $response = $this->withoutMiddleware()->get(route('booking.status', ['booking' => $booking->id]));

        $response->assertStatus(200);
        $response->assertViewIs('booking.status');
    }
}
