<?php

namespace App\Services;

use App\Models\RoomType;
use App\Models\Booking;
use App\Models\RoomAllocation;
use App\Models\TemporaryReservation;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RoomAvailabilityService
{
    /**
     * Get available rooms for a room type within a date range
     * 
     * This method performs a fresh availability check, considering:
     * - Active confirmed bookings
     * - Active temporary reservations (not expired)
     * - Room allocations for those bookings
     * 
     * Checkout date is EXCLUSIVE (not included in the stay)
     * 
     * @param int $roomTypeId
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @return array ['available_quantity' => int, 'total_quantity' => int, 'room_type' => RoomType]
     */
    public function getAvailableRooms($roomTypeId, Carbon $checkInDate, Carbon $checkOutDate): array
    {
        // Release expired unpaid room allocations first to ensure accurate inventory
        $this->releaseExpiredHolds();

        // Validate dates
        if ($checkOutDate <= $checkInDate) {
            throw new \InvalidArgumentException('Check-out date must be after check-in date');
        }

        $roomType = RoomType::findOrFail($roomTypeId);

        // Get total number of rooms of this type
        $totalRooms = $roomType->rooms()->count();

        if ($totalRooms === 0) {
            return [
                'available_quantity' => 0,
                'total_quantity' => 0,
                'room_type' => $roomType,
            ];
        }

        // Get all physical rooms of this type
        $roomIds = $roomType->rooms()->pluck('id')->toArray();

        // Find how many rooms are NOT available during the requested dates
        $unavailableRoomCount = RoomAllocation::query()
            ->active()
            ->whereIn('room_id', $roomIds)
            ->where('check_in_date', '<', $checkOutDate)
            ->where('check_out_date', '>', $checkInDate)
            ->distinct('room_id')
            ->count('room_id');

        // Calculate available rooms
        $availableQuantity = $totalRooms - $unavailableRoomCount;

        // Ensure it doesn't go negative (safety check)
        $availableQuantity = max(0, $availableQuantity);

        return [
            'available_quantity' => $availableQuantity,
            'total_quantity' => $totalRooms,
            'room_type' => $roomType,
        ];
    }

    /**
     * Get availability for multiple room types in a single date range
     * 
     * @param array|Collection $roomTypeIds
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @return Collection
     */
    public function getAvailabilitiesByMultipleRoomTypes($roomTypeIds, Carbon $checkInDate, Carbon $checkOutDate): Collection
    {
        return collect($roomTypeIds)->map(function ($roomTypeId) use ($checkInDate, $checkOutDate) {
            return $this->getAvailableRooms($roomTypeId, $checkInDate, $checkOutDate);
        });
    }

    /**
     * Get available physical rooms for a room type within a date range
     * 
     * Returns the actual room objects that are available
     * 
     * @param int $roomTypeId
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @return Collection of Room models
     */
    public function getAvailablePhysicalRooms($roomTypeId, Carbon $checkInDate, Carbon $checkOutDate): Collection
    {
        // Release expired unpaid room allocations first to ensure accurate inventory
        $this->releaseExpiredHolds();

        $roomType = RoomType::findOrFail($roomTypeId);

        // Get all rooms of this type
        $allRooms = $roomType->rooms()->get();

        // Filter out rooms that have active allocations during the requested dates
        return $allRooms->filter(function ($room) use ($checkInDate, $checkOutDate) {
            // Check if this room has any active allocations in the date range
            $hasConflict = RoomAllocation::query()
                ->active()
                ->where('room_id', $room->id)
                ->where('check_in_date', '<', $checkOutDate)
                ->where('check_out_date', '>', $checkInDate)
                ->exists();

            return !$hasConflict;
        });
    }

    /**
     * Check if a specific quantity of rooms is available for a room type
     * 
     * @param int $roomTypeId
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @param int $requestedQuantity
     * @return bool
     */
    public function isAvailable($roomTypeId, Carbon $checkInDate, Carbon $checkOutDate, int $requestedQuantity = 1): bool
    {
        $availability = $this->getAvailableRooms($roomTypeId, $checkInDate, $checkOutDate);
        return $availability['available_quantity'] >= $requestedQuantity;
    }

    /**
     * Get the count of booked nights for a room type
     * 
     * @param int $roomTypeId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array of ['date' => available_count, ...]
     */
    public function getAvailabilityCalendar($roomTypeId, Carbon $startDate, Carbon $endDate): array
    {
        $roomType = RoomType::findOrFail($roomTypeId);
        $totalRooms = $roomType->rooms()->count();
        
        $calendar = [];
        $currentDate = $startDate->clone();

        while ($currentDate <= $endDate) {
            $nextDate = $currentDate->clone()->addDay();
            
            $availability = $this->getAvailableRooms(
                $roomTypeId,
                $currentDate,
                $nextDate
            );

            $calendar[$currentDate->format('Y-m-d')] = $availability['available_quantity'];
            $currentDate->addDay();
        }

        return $calendar;
    }

    /**
     * Get count of temporary reservations for a room type in a date range
     * 
     * @param int $roomTypeId
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @return int
     */
    public function getTemporaryReservationCount($roomTypeId, Carbon $checkInDate, Carbon $checkOutDate): int
    {
        return TemporaryReservation::query()
            ->valid()
            ->byRoomType($roomTypeId)
            ->inDateRange($checkInDate, $checkOutDate)
            ->sum('room_quantity');
    }

    /**
     * Get count of confirmed bookings for a room type in a date range
     * 
     * @param int $roomTypeId
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @return int
     */
    public function getConfirmedBookingCount($roomTypeId, Carbon $checkInDate, Carbon $checkOutDate): int
    {
        return Booking::query()
            ->active()
            ->byRoomType($roomTypeId)
            ->inDateRange($checkInDate, $checkOutDate)
            ->sum('room_quantity');
    }

    /**
     * Calculate nights between two dates (checkout date is exclusive)
     * 
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @return int
     */
    public function calculateNights(Carbon $checkInDate, Carbon $checkOutDate): int
    {
        $nights = $checkInDate->diffInDays($checkOutDate); // checkIn diff to checkOut (positive)
        return $nights > 0 ? $nights : 1;
    }

    /**
     * Release any expired temporary room allocations past the hold duration
     */
    protected function releaseExpiredHolds(): void
    {
        $holdMinutes = (int) config('razorpay.reservation_duration_minutes', 30);
        $cutoff = now()->subMinutes($holdMinutes);

        RoomAllocation::query()
            ->where('allocation_status', 'temporary')
            ->where(function ($q) use ($cutoff) {
                $q->where('allocated_at', '<', $cutoff)
                  ->orWhere(function ($sub) use ($cutoff) {
                      $sub->whereNull('allocated_at')
                          ->where('created_at', '<', $cutoff);
                  });
            })
            ->update([
                'allocation_status' => 'released',
                'released_at' => now(),
            ]);
    }
}
