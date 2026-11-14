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
     * Scope: Only active/confirmed allocations (excluding released and expired temporary)
     */
    public function scopeActive($query)
    {
        $holdMinutes = (int) config('razorpay.reservation_duration_minutes', 30);
        $cutoff = now()->subMinutes($holdMinutes);

        return $query->where(function ($q) use ($cutoff) {
            $q->where('allocation_status', 'confirmed')
              ->orWhere(function ($sub) use ($cutoff) {
                  $sub->where('allocation_status', 'temporary')
                      ->where(function ($dateQ) use ($cutoff) {
                          $dateQ->where('allocated_at', '>=', $cutoff)
                                ->orWhere(function ($dateQ2) use ($cutoff) {
                                    $dateQ2->whereNull('allocated_at')
                                           ->where('created_at', '>=', $cutoff);
                                });
                      });
              });
        });
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
