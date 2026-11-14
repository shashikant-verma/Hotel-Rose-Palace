<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use App\Models\TemporaryReservation;
use App\Services\RoomAllocationService;
use App\Services\RoomAvailabilityService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private RoomAvailabilityService $availabilityService;
    private RoomAllocationService $allocationService;
    private RoomType $roomType;
    private array $rooms;

    /**
     * Setup for each test
     * We skip the problematic migration that requires specific room types
     * and create our own test data
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->availabilityService = app(RoomAvailabilityService::class);
        $this->allocationService = app(RoomAllocationService::class);

        // Create a test room type with 3 physical rooms
        $this->roomType = RoomType::create([
            'name' => 'Test Deluxe Room',
            'slug' => 'test-deluxe',
            'description' => 'Test room for availability testing',
            'base_price' => 5000.00,
            'max_occupancy' => 2,
            'max_adults' => 2,
            'max_children' => 0,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Create 3 physical rooms
        $this->rooms = [];
        for ($i = 1; $i <= 3; $i++) {
            $this->rooms[] = Room::create([
                'room_type_id' => $this->roomType->id,
                'room_number' => "TEST-{$i}",
                'floor' => 1,
                'current_price' => 5000.00,
                'price_per_night' => 5000.00,
                'max_guests' => 2,
                'is_available' => true,
                'status' => 'available',
                'housekeeping_status' => 'clean',
            ]);
        }
    }

    /**
     * Test: All rooms available when no bookings exist
     */
    public function test_all_rooms_available_with_no_bookings()
    {
        $checkIn = Carbon::now()->addDays(1);
        $checkOut = $checkIn->clone()->addDays(3);

        $availability = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );

        $this->assertEquals(3, $availability['available_quantity']);
        $this->assertEquals(3, $availability['total_quantity']);
    }

    /**
     * Test: One room booked reduces availability by 1
     */
    public function test_booked_room_reduces_availability()
    {
        $checkIn = Carbon::now()->addDays(1);
        $checkOut = $checkIn->clone()->addDays(3);

        // Create a booking for 1 room
        $booking = Booking::create([
            'booking_reference' => 'TEST-001',
            'customer_name' => 'Test Customer',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'room_quantity' => 1,
            'base_amount' => 15000,
            'tax_amount' => 1800,
            'total_amount' => 16800,
            'razorpay_order_id' => 'order_001',
            'booking_status' => 'confirmed',
        ]);

        // Allocate room
        RoomAllocation::create([
            'booking_id' => $booking->id,
            'room_id' => $this->rooms[0]->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);

        $availability = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );

        $this->assertEquals(2, $availability['available_quantity']);
    }

    /**
     * Test: Checkout date is exclusive (not included in stay)
     */
    public function test_checkout_date_is_exclusive()
    {
        $checkIn = Carbon::create(2026, 11, 15);
        $checkOut = Carbon::create(2026, 11, 18);
        $sameCheckOut = Carbon::create(2026, 11, 18);

        // Create booking from 11/15 to 11/18
        $booking = Booking::create([
            'booking_reference' => 'TEST-CHECKOUT-001',
            'customer_name' => 'Test Customer',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'room_quantity' => 1,
            'base_amount' => 15000,
            'tax_amount' => 1800,
            'total_amount' => 16800,
            'razorpay_order_id' => 'order_checkout_001',
            'booking_status' => 'confirmed',
        ]);

        RoomAllocation::create([
            'booking_id' => $booking->id,
            'room_id' => $this->rooms[0]->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);

        // Check-in on same checkout date should have 3 rooms available (checkout is exclusive)
        $nextCheckOut = $sameCheckOut->clone()->addDays(2);
        $availability = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $sameCheckOut,
            $nextCheckOut
        );

        $this->assertEquals(3, $availability['available_quantity']);
    }

    /**
     * Test: Overlapping bookings detected correctly
     */
    public function test_overlapping_bookings_detected()
    {
        $checkIn1 = Carbon::create(2026, 11, 15);
        $checkOut1 = Carbon::create(2026, 11, 20);

        $checkIn2 = Carbon::create(2026, 11, 18); // Overlaps
        $checkOut2 = Carbon::create(2026, 11, 22);

        // First booking
        $booking1 = Booking::create([
            'booking_reference' => 'TEST-OVERLAP-001',
            'customer_name' => 'Customer 1',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => $checkIn1,
            'check_out_date' => $checkOut1,
            'room_quantity' => 2,
            'base_amount' => 30000,
            'tax_amount' => 3600,
            'total_amount' => 33600,
            'razorpay_order_id' => 'order_overlap_001',
            'booking_status' => 'confirmed',
        ]);

        RoomAllocation::create([
            'booking_id' => $booking1->id,
            'room_id' => $this->rooms[0]->id,
            'check_in_date' => $checkIn1,
            'check_out_date' => $checkOut1,
            'allocation_status' => 'confirmed',
        ]);
        RoomAllocation::create([
            'booking_id' => $booking1->id,
            'room_id' => $this->rooms[1]->id,
            'check_in_date' => $checkIn1,
            'check_out_date' => $checkOut1,
            'allocation_status' => 'confirmed',
        ]);

        // Check availability for overlapping period
        $availability = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn2,
            $checkOut2
        );

        $this->assertEquals(1, $availability['available_quantity']);
    }

    /**
     * Test: Partially available categories work correctly
     */
    public function test_partially_available_categories()
    {
        $checkIn = Carbon::create(2026, 11, 15);
        $checkOut = Carbon::create(2026, 11, 18);

        // Book 2 out of 3 rooms
        $booking = Booking::create([
            'booking_reference' => 'TEST-PARTIAL-001',
            'customer_name' => 'Customer Partial',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'room_quantity' => 2,
            'base_amount' => 30000,
            'tax_amount' => 3600,
            'total_amount' => 33600,
            'razorpay_order_id' => 'order_partial_001',
            'booking_status' => 'confirmed',
        ]);

        for ($i = 0; $i < 2; $i++) {
            RoomAllocation::create([
                'booking_id' => $booking->id,
                'room_id' => $this->rooms[$i]->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'allocation_status' => 'confirmed',
            ]);
        }

        $availability = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );

        $this->assertEquals(1, $availability['available_quantity']);
    }

    /**
     * Test: Released allocations don't count as unavailable
     */
    public function test_released_allocations_not_counted()
    {
        $checkIn = Carbon::create(2026, 11, 15);
        $checkOut = Carbon::create(2026, 11, 18);

        // Create allocation
        $allocation = RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->rooms[0]->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'temporary',
        ]);

        // Check availability before release
        $availabilityBefore = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );
        $this->assertEquals(2, $availabilityBefore['available_quantity']);

        // Release the allocation
        $allocation->update([
            'allocation_status' => 'released',
            'released_at' => now(),
        ]);

        // Check availability after release
        $availabilityAfter = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );
        $this->assertEquals(3, $availabilityAfter['available_quantity']);
    }

    /**
     * Test: Allocation conflict detection
     */
    public function test_allocation_conflict_detection()
    {
        $checkIn = Carbon::create(2026, 11, 15);
        $checkOut = Carbon::create(2026, 11, 18);

        RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->rooms[0]->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);

        // Check conflicts with overlapping range
        $overlappingCheckIn = Carbon::create(2026, 11, 16);
        $overlappingCheckOut = Carbon::create(2026, 11, 19);

        $hasConflict = $this->allocationService->hasConflicts(
            $this->rooms[0]->id,
            $overlappingCheckIn,
            $overlappingCheckOut
        );

        $this->assertTrue($hasConflict);

        // Check no conflicts with non-overlapping range
        $noConflictCheckIn = Carbon::create(2026, 11, 18);
        $noConflictCheckOut = Carbon::create(2026, 11, 20);

        $hasNoConflict = $this->allocationService->hasConflicts(
            $this->rooms[0]->id,
            $noConflictCheckIn,
            $noConflictCheckOut
        );

        $this->assertFalse($hasNoConflict);
    }

    /**
     * Test: Calculate nights correctly (checkout date exclusive)
     */
    public function test_calculate_nights_checkout_exclusive()
    {
        // Use specific dates to verify checkout exclusivity
        $checkIn = Carbon::create(2026, 11, 15, 0, 0, 0); // Nov 15 midnight
        $checkOut = Carbon::create(2026, 11, 18, 0, 0, 0); // Nov 18 midnight

        $nights = $this->availabilityService->calculateNights($checkIn, $checkOut);

        // 3 days between (Nov 15 night, Nov 16 night, Nov 17 night)
        $this->assertEquals(3, $nights);
    }

    /**
     * Test: Invalid date range throws exception
     */
    public function test_invalid_date_range_throws_exception()
    {
        $checkIn = Carbon::create(2026, 11, 20);
        $checkOut = Carbon::create(2026, 11, 15); // Before check-in

        $this->expectException(\InvalidArgumentException::class);

        $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );
    }

    /**
     * Test: Get available physical rooms
     */
    public function test_get_available_physical_rooms()
    {
        $checkIn = Carbon::create(2026, 11, 15);
        $checkOut = Carbon::create(2026, 11, 18);

        // Book room 1
        RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->rooms[0]->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'confirmed',
        ]);

        $availableRooms = $this->availabilityService->getAvailablePhysicalRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );

        $this->assertCount(2, $availableRooms);
        $this->assertNotContains($this->rooms[0]->id, $availableRooms->pluck('id'));
        $this->assertContains($this->rooms[1]->id, $availableRooms->pluck('id'));
    }

    /**
     * Test: Negative availability never goes below zero
     */
    public function test_availability_never_negative()
    {
        $checkIn = Carbon::create(2026, 11, 15);
        $checkOut = Carbon::create(2026, 11, 18);

        // Create all rooms booked (which shouldn't happen, but safety check)
        for ($i = 0; $i < 3; $i++) {
            $booking = Booking::create([
                'booking_reference' => 'TEST-NEG-' . ($i + 1),
                'customer_name' => "Customer {$i}",
                'customer_mobile' => '9876543210',
                'room_type_id' => $this->roomType->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'room_quantity' => 1,
                'base_amount' => 15000,
                'tax_amount' => 1800,
                'total_amount' => 16800,
                'razorpay_order_id' => 'order_neg_' . ($i + 1),
                'booking_status' => 'confirmed',
            ]);

            RoomAllocation::create([
                'booking_id' => $booking->id,
                'room_id' => $this->rooms[$i]->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'allocation_status' => 'confirmed',
            ]);
        }

        $availability = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );

        $this->assertGreaterThanOrEqual(0, $availability['available_quantity']);
        $this->assertEquals(0, $availability['available_quantity']);
    }

    /**
     * Test: Temporary reservations affect availability
     */
    public function test_temporary_reservations_affect_availability()
    {
        $checkIn = Carbon::create(2026, 11, 15);
        $checkOut = Carbon::create(2026, 11, 18);

        // Create a temporary reservation (not yet expired)
        TemporaryReservation::create([
            'reservation_token' => 'temp-123',
            'customer_mobile' => '9876543210',
            'room_type_id' => $this->roomType->id,
            'room_quantity' => 1,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'total_amount' => 5000,
            'expires_at' => now()->addMinutes(30),
            'status' => 'active',
        ]);

        // Create temporary allocations
        RoomAllocation::create([
            'booking_id' => null,
            'room_id' => $this->rooms[0]->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'allocation_status' => 'temporary',
        ]);

        // Availability should account for temporary reservation
        $availability = $this->availabilityService->getAvailableRooms(
            $this->roomType->id,
            $checkIn,
            $checkOut
        );

        $this->assertEquals(2, $availability['available_quantity']);
    }
}
