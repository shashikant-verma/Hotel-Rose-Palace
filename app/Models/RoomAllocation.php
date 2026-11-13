<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'allocation_status',
        'allocated_at',
        'released_at',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'allocated_at' => 'datetime',
            'released_at' => 'datetime',
        ];
    }

    /**
     * Get the booking this allocation belongs to
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the room for this allocation
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Check if this allocation overlaps with the given date range
     * Checkout date is exclusive
     */
    public function overlaps(\Carbon\Carbon $checkIn, \Carbon\Carbon $checkOut): bool
    {
        return $this->check_in_date < $checkOut && $this->check_out_date > $checkIn;
    }

    /**
     * Scope: Only active/confirmed allocations
     */
    public function scopeActive($query)
    {
        return $query->where('allocation_status', '!=', 'released');
    }

    /**
     * Scope: Only temporary allocations
     */
    public function scopeTemporary($query)
    {
        return $query->where('allocation_status', 'temporary');
    }

    /**
     * Scope: Only confirmed allocations
     */
    public function scopeConfirmed($query)
    {
        return $query->where('allocation_status', 'confirmed');
    }

    /**
     * Scope: Within date range
     */
    public function scopeInDateRange($query, $checkIn, $checkOut)
    {
        return $query->active()
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in_date', '<', $checkOut)
                  ->where('check_out_date', '>', $checkIn);
            });
    }

    /**
     * Scope: For a specific room
     */
    public function scopeForRoom($query, $roomId)
    {
        return $query->where('room_id', $roomId);
    }
}
