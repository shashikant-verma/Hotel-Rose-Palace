<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_reference',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'room_type_id',
        'check_in_date',
        'check_out_date',
        'num_adults',
        'num_children',
        'room_quantity',
        'base_amount',
        'tax_amount',
        'total_amount',
        'razorpay_order_id',
        'razorpay_payment_id',
        'booking_status',
        'payment_status',
        'special_requests',
        'cancelled_at',
        'cancellation_reason',
        'cancellation_status',
        'cancellation_requested_at',
        'cancellation_reviewed_at',
        'cancellation_reviewed_by',
        'cancellation_admin_notes',
        'cancellation_rejection_reason',
        'eligible_refund_percentage',
        'eligible_refund_amount',
        'refund_status',
        'refund_retry_token',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'base_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'eligible_refund_amount' => 'decimal:2',
            'eligible_refund_percentage' => 'integer',
            'cancelled_at' => 'datetime',
            'cancellation_requested_at' => 'datetime',
            'cancellation_reviewed_at' => 'datetime',
            'num_adults' => 'integer',
            'num_children' => 'integer',
            'room_quantity' => 'integer',
        ];
    }

    /**
     * Get the room type for this booking
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the room allocations for this booking
     */
    public function roomAllocations()
    {
        return $this->hasMany(RoomAllocation::class);
    }

    /**
     * Alias for roomAllocations
     */
    public function allocations()
    {
        return $this->roomAllocations();
    }

    /**
     * Get all payment attempts for this booking
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the latest payment attempt for this booking
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /**
     * Get the verified successful payment for this booking
     */
    public function successfulPayment()
    {
        return $this->hasOne(Payment::class)->where('status', 'captured')->latestOfMany();
    }

    /**
     * Admin/Manager who reviewed the cancellation request
     */
    public function cancellationReviewer()
    {
        return $this->belongsTo(User::class, 'cancellation_reviewed_by');
    }

    /**
     * Check if cancellation request is pending manager review
     */
    public function isCancellationPending(): bool
    {
        return ($this->cancellation_status === 'pending' || $this->booking_status === 'cancellation_requested')
            && is_null($this->cancelled_at);
    }

    /**
     * Check if cancellation has been approved
     */
    public function isCancellationApproved(): bool
    {
        return $this->cancellation_status === 'approved' || ($this->booking_status === 'cancelled' && !is_null($this->cancelled_at));
    }

    /**
     * Check if cancellation was rejected by manager
     */
    public function isCancellationRejected(): bool
    {
        return $this->cancellation_status === 'rejected';
    }

    /**
     * Accessor for status (compatibility with Phase 8C templates)
     */
    public function getStatusAttribute(): string
    {
        if ($this->payment_status === 'pending') {
            return 'pending_payment';
        }
        return $this->booking_status ?? 'pending';
    }

    /**
     * Check if booking is officially confirmed and paid
     */
    public function isConfirmed(): bool
    {
        return $this->booking_status === 'confirmed' && $this->payment_status === 'paid' && is_null($this->cancelled_at);
    }

    /**
     * Accessor for number_of_rooms
     */
    public function getNumberOfRoomsAttribute(): int
    {
        return $this->room_quantity ?? 1;
    }

    /**
     * Accessor for total_guests
     */
    public function getTotalGuestsAttribute(): int
    {
        return $this->num_adults ?? 1;
    }

    /**
     * Accessor for subtotal_amount
     */
    public function getSubtotalAmountAttribute(): float
    {
        return (float) ($this->base_amount ?? 0);
    }

    /**
     * Get the number of nights for this booking
     */
    public function getNightsAttribute(): int
    {
        $diff = $this->check_out_date->diffInDays($this->check_in_date);
        return $diff > 0 ? $diff : 1;
    }

    /**
     * Check if booking is active (confirmed and not cancelled)
     */
    public function isActive(): bool
    {
        return $this->booking_status === 'confirmed' && is_null($this->cancelled_at);
    }

    /**
     * Check if booking overlaps with the given date range
     * Checkout date is exclusive (not inclusive)
     */
    public function overlaps(\Carbon\Carbon $checkIn, \Carbon\Carbon $checkOut): bool
    {
        $thisCheckIn = $this->check_in_date;
        $thisCheckOut = $this->check_out_date;

        // No overlap if this booking ends on or before the requested check-in
        if ($thisCheckOut <= $checkIn) {
            return false;
        }

        // No overlap if this booking starts on or after the requested check-out
        if ($thisCheckIn >= $checkOut) {
            return false;
        }

        // Otherwise there is an overlap
        return true;
    }

    /**
     * Scope: Only active/confirmed bookings
     */
    public function scopeActive($query)
    {
        return $query->where('booking_status', 'confirmed')
            ->whereNull('cancelled_at');
    }

    /**
     * Scope: Only within date range (active bookings that overlap dates)
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
     * Scope: By room type
     */
    public function scopeByRoomType($query, $roomTypeId)
    {
        return $query->where('room_type_id', $roomTypeId);
    }
}
