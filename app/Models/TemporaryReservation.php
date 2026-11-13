<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_token',
        'customer_mobile',
        'room_type_id',
        'room_quantity',
        'check_in_date',
        'check_out_date',
        'total_amount',
        'razorpay_order_id',
        'expires_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'total_amount' => 'decimal:2',
            'expires_at' => 'datetime',
            'room_quantity' => 'integer',
        ];
    }

    /**
     * Get the room type for this reservation
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Check if this reservation has expired
     */
    public function hasExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }

    /**
     * Check if this reservation is still valid (active and not expired)
     */
    public function isValid(): bool
    {
        return $this->status === 'active' && !$this->hasExpired();
    }

    /**
     * Scope: Only active reservations
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Only non-expired reservations
     */
    public function scopeNotExpired($query)
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Scope: Only valid (active and not expired)
     */
    public function scopeValid($query)
    {
        return $query->active()->notExpired();
    }

    /**
     * Scope: By room type
     */
    public function scopeByRoomType($query, $roomTypeId)
    {
        return $query->where('room_type_id', $roomTypeId);
    }

    /**
     * Scope: By customer mobile
     */
    public function scopeByMobile($query, $mobile)
    {
        return $query->where('customer_mobile', $mobile);
    }

    /**
     * Scope: Within date range
     */
    public function scopeInDateRange($query, $checkIn, $checkOut)
    {
        return $query->where(function ($q) use ($checkIn, $checkOut) {
            $q->where('check_in_date', '<', $checkOut)
              ->where('check_out_date', '>', $checkIn);
        });
    }
}
