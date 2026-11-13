<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\RoomAllocation;
use App\Models\RoomType;
use App\Models\TemporaryReservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RoomAllocationService
{
    protected RoomAvailabilityService $availabilityService;

    public function __construct(RoomAvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Allocate physical rooms for a booking within a transaction
     * 
     * IMPORTANT: This must be called INSIDE a database transaction
     * The transaction should lock the room_type row and perform fresh availability check
     * 
     * @param Booking $booking
     * @return Collection of RoomAllocation models
     * @throws \InvalidArgumentException if insufficient rooms available
     */
    public function allocateRoomsForBooking(Booking $booking): Collection
    {
        // Fresh availability check (MUST be inside transaction with row lock)
        $availability = $this->availabilityService->getAvailableRooms(
            $booking->room_type_id,
            $booking->check_in_date,
            $booking->check_out_date
        );

        if ($availability['available_quantity'] < $booking->room_quantity) {
            throw new \InvalidArgumentException(
                "Insufficient rooms available. Requested: {$booking->room_quantity}, Available: {$availability['available_quantity']}"
            );
        }

        // Get available physical rooms
        $availableRooms = $this->availabilityService->getAvailablePhysicalRooms(
            $booking->room_type_id,
            $booking->check_in_date,
            $booking->check_out_date
        )->take($booking->room_quantity);

        if ($availableRooms->count() < $booking->room_quantity) {
            throw new \InvalidArgumentException(
                "Could not allocate the requested number of physical rooms"
            );
        }

        // Allocate each room
        $allocations = new Collection();
        foreach ($availableRooms as $room) {
            $allocation = RoomAllocation::create([
                'booking_id' => $booking->id,
                'room_id' => $room->id,
                'check_in_date' => $booking->check_in_date,
                'check_out_date' => $booking->check_out_date,
                'allocation_status' => 'confirmed',
            ]);

            $allocations->push($allocation);
        }

        return $allocations;
    }

    /**
     * Create temporary room allocations for a temporary reservation OR a booking
     * 
     * IMPORTANT: This must be called INSIDE a database transaction
     * 
     * @param TemporaryReservation|Booking $reservationOrBooking
     * @param array|Collection|null $preSelectedRooms Optional pre-selected physical rooms
     * @param Carbon|null $checkInDate
     * @param Carbon|null $checkOutDate
     * @return Collection of RoomAllocation models
     * @throws \InvalidArgumentException if insufficient rooms available
     */
    public function allocateTemporaryRooms(
        $reservationOrBooking,
        $preSelectedRooms = null,
        ?Carbon $checkInDate = null,
        ?Carbon $checkOutDate = null
    ): Collection {
        if ($reservationOrBooking instanceof TemporaryReservation) {
            $reservation = $reservationOrBooking;
            $checkIn = $reservation->check_in_date;
            $checkOut = $reservation->check_out_date;
            $roomTypeId = $reservation->room_type_id;
            $quantity = $reservation->room_quantity;
            $bookingId = null;
        } elseif ($reservationOrBooking instanceof Booking) {
            $booking = $reservationOrBooking;
            $checkIn = $checkInDate ?? $booking->check_in_date;
            $checkOut = $checkOutDate ?? $booking->check_out_date;
            $roomTypeId = $booking->room_type_id;
            $quantity = $booking->room_quantity;
            $bookingId = $booking->id;
        } else {
            throw new \InvalidArgumentException('Argument must be an instance of TemporaryReservation or Booking');
        }

        // Use pre-selected rooms if provided, otherwise fetch fresh available physical rooms
        if ($preSelectedRooms && count($preSelectedRooms) >= $quantity) {
            $availableRooms = collect($preSelectedRooms)->take($quantity);
        } else {
            $availableRooms = $this->availabilityService->getAvailablePhysicalRooms(
                $roomTypeId,
                $checkIn,
                $checkOut
            )->take($quantity);
        }

        if ($availableRooms->count() < $quantity) {
            throw new \InvalidArgumentException(
                "Could not allocate temporary rooms. Requested: {$quantity}, Available: {$availableRooms->count()}"
            );
        }

        // Create temporary allocations (linked to booking if provided, otherwise unlinked)
        $allocations = new Collection();
        foreach ($availableRooms as $room) {
            $roomId = is_object($room) ? $room->id : (is_array($room) ? $room['id'] : $room);
            $allocation = RoomAllocation::create([
                'booking_id' => $bookingId,
                'room_id' => $roomId,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'allocation_status' => 'temporary',
                'allocated_at' => now(),
            ]);

            $allocations->push($allocation);
        }

        return $allocations;
    }

    /**
     * Explicit helper: Allocate temporary rooms specifically for a Booking instance
     */
    public function allocateTemporaryRoomsForBooking(
        Booking $booking,
        $preSelectedRooms = null,
        ?Carbon $checkInDate = null,
        ?Carbon $checkOutDate = null
    ): Collection {
        return $this->allocateTemporaryRooms($booking, $preSelectedRooms, $checkInDate, $checkOutDate);
    }

    /**
     * Convert temporary allocations to confirmed for a booking
     * 
     * @param Booking $booking
     * @param Collection|array|null $temporaryAllocations
     * @return Collection of updated RoomAllocation models
     */
    public function convertTemporaryAllocationsToConfirmed(Booking $booking, $temporaryAllocations = null): Collection
    {
        if ($temporaryAllocations === null) {
            $allocations = RoomAllocation::where('booking_id', $booking->id)
                ->where('allocation_status', 'temporary')
                ->get();
        } else {
            $allocations = collect($temporaryAllocations);
        }

        $converted = new Collection();

        foreach ($allocations as $tempAllocation) {
            $tempAllocation->update([
                'booking_id' => $booking->id,
                'allocation_status' => 'confirmed',
                'allocated_at' => now(),
            ]);
            $converted->push($tempAllocation);
        }

        return $converted;
    }

    /**
     * Release temporary allocations (mark as released)
     * 
     * @param Collection|array $temporaryAllocations
     * @return void
     */
    public function releaseTemporaryAllocations($temporaryAllocations): void
    {
        $allocations = collect($temporaryAllocations);

        foreach ($allocations as $allocation) {
            $allocation->update([
                'allocation_status' => 'released',
                'released_at' => now(),
            ]);
        }
    }

    /**
     * Release all temporary allocations for a temporary reservation
     * 
     * @param TemporaryReservation $reservation
     * @return int count of released allocations
     */
    public function releaseTemporaryReservationAllocations(TemporaryReservation $reservation): int
    {
        // Find temporary allocations that don't have a booking_id (orphaned temp allocations)
        $updated = RoomAllocation::query()
            ->whereNull('booking_id')
            ->where('allocation_status', 'temporary')
            ->where('check_in_date', $reservation->check_in_date)
            ->where('check_out_date', $reservation->check_out_date)
            ->update([
                'allocation_status' => 'released',
                'released_at' => now(),
            ]);

        return $updated;
    }

    /**
     * Release allocations for a cancelled booking
     * 
     * @param Booking $booking
     * @return int count of released allocations
     */
    public function releaseCancelledBookingAllocations(Booking $booking): int
    {
        return RoomAllocation::query()
            ->where('booking_id', $booking->id)
            ->where('allocation_status', '!=', 'released')
            ->update([
                'allocation_status' => 'released',
                'released_at' => now(),
            ]);
    }

    /**
     * Get allocations for a booking
     * 
     * @param Booking $booking
     * @return Collection of RoomAllocation models
     */
    public function getAllocationsForBooking(Booking $booking): Collection
    {
        return $booking->roomAllocations()->get();
    }

    /**
     * Check if there are any allocation conflicts for a room during a date range
     * 
     * @param int $roomId
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @param int|null $excludeAllocationId exclude a specific allocation from conflict check
     * @return bool
     */
    public function hasConflicts($roomId, Carbon $checkInDate, Carbon $checkOutDate, ?int $excludeAllocationId = null): bool
    {
        $query = RoomAllocation::query()
            ->active()
            ->where('room_id', $roomId)
            ->where('check_in_date', '<', $checkOutDate)
            ->where('check_out_date', '>', $checkInDate);

        if ($excludeAllocationId) {
            $query->where('id', '!=', $excludeAllocationId);
        }

        return $query->exists();
    }

    /**
     * Clean up expired temporary allocations (orphaned allocations with released status)
     * 
     * This is useful for maintenance - cleans up allocations from expired temporary reservations
     * 
     * @param int $daysOld cleanup allocations older than this many days
     * @return int count of deleted allocations
     */
    public function cleanupExpiredTemporaryAllocations(int $daysOld = 7): int
    {
        $cutoffDate = now()->subDays($daysOld);

        return RoomAllocation::query()
            ->where('allocation_status', 'released')
            ->whereNull('booking_id')
            ->where('released_at', '<', $cutoffDate)
            ->delete();
    }
}
