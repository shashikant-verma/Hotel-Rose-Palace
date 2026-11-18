<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpectedArrivalTimeTest extends TestCase
{
    use RefreshDatabase;

    private RoomType $roomType;
    private Room $room;

    protected function setUp(): void
    {
        parent::setUp();

        $this->roomType = RoomType::factory()->create([
            'name' => 'Deluxe Family Room',
            'slug' => 'deluxe-family-room',
            'base_price' => 1725.00,
            'max_occupancy' => 3,
            'is_active' => true,
        ]);

        $this->room = Room::factory()->create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '101',
            'is_available' => true,
            'status' => 'available',
        ]);
    }

    /**
     * Test booking form displays the optional expected arrival time select dropdown.
     */
    public function test_booking_form_displays_expected_arrival_time_dropdown(): void
    {
        $response = $this->withSession([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_at' => now()->timestamp,
        ])->get(route('booking.form', [
            'check_in' => Carbon::tomorrow()->format('Y-m-d'),
            'check_out' => Carbon::tomorrow()->addDay()->format('Y-m-d'),
            'room_type_id' => $this->roomType->id,
            'quantity' => 1,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Expected Arrival Time (Optional)');
        $response->assertSee('10 AM – 11 AM');
        $response->assertSee('12 PM – 2 PM (Standard check-in starts at 12 PM)');
        $response->assertSee('9 PM onwards (Late arrival)');
        $response->assertSee('Not sure yet');
    }

    /**
     * Test booking succeeds when expected arrival time is omitted (optional field).
     */
    public function test_booking_creation_succeeds_without_expected_arrival_time(): void
    {
        session([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_at' => now()->timestamp,
        ]);

        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => Carbon::tomorrow()->format('Y-m-d'),
            'check_out' => Carbon::tomorrow()->addDay()->format('Y-m-d'),
            'room_type_id' => $this->roomType->id,
            'quantity' => 1,
            'customer_name' => 'John Doe',
            'customer_mobile' => '9876543210',
            'total_guests' => 2,
            'special_requests' => 'Quiet room please',
            // expected_arrival_time omitted
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'customer_email' => 'guest@example.com',
            'customer_name' => 'John Doe',
            'expected_arrival_time' => null,
        ]);
    }

    /**
     * Test booking creation succeeds and saves a valid expected arrival time.
     */
    public function test_booking_creation_saves_valid_expected_arrival_time(): void
    {
        session([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_at' => now()->timestamp,
        ]);

        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => Carbon::tomorrow()->format('Y-m-d'),
            'check_out' => Carbon::tomorrow()->addDay()->format('Y-m-d'),
            'room_type_id' => $this->roomType->id,
            'quantity' => 1,
            'customer_name' => 'Jane Smith',
            'customer_mobile' => '9876543210',
            'total_guests' => 2,
            'expected_arrival_time' => '2 PM – 4 PM',
        ]);

        $response->assertRedirect();
        $booking = Booking::where('customer_email', 'guest@example.com')->latest()->first();

        $this->assertNotNull($booking);
        $this->assertEquals('2 PM – 4 PM', $booking->expected_arrival_time);

        // Assert review page displays the saved arrival time
        $reviewResponse = $this->withSession([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_at' => now()->timestamp,
        ])->withoutMiddleware()->get(route('booking.review', ['booking' => $booking->id]));

        $reviewResponse->assertStatus(200);
        $reviewResponse->assertSee('Expected Arrival Time');
        $reviewResponse->assertSee('2 PM – 4 PM');
        $reviewResponse->assertSee('From 12:00 PM');
        $reviewResponse->assertSee('Until 11:00 AM');
    }

    /**
     * Test booking creation rejects invalid expected arrival time values.
     */
    public function test_booking_creation_rejects_invalid_expected_arrival_time(): void
    {
        session([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_at' => now()->timestamp,
        ]);

        $response = $this->withoutMiddleware()->post(route('booking.store'), [
            'check_in' => Carbon::tomorrow()->format('Y-m-d'),
            'check_out' => Carbon::tomorrow()->addDay()->format('Y-m-d'),
            'room_type_id' => $this->roomType->id,
            'quantity' => 1,
            'customer_name' => 'Invalid Time Guest',
            'customer_mobile' => '9876543210',
            'total_guests' => 2,
            'expected_arrival_time' => '3:30 AM in the morning',
        ]);

        $response->assertSessionHasErrors(['expected_arrival_time']);
        $this->assertDatabaseMissing('bookings', [
            'customer_name' => 'Invalid Time Guest',
        ]);
    }
}
