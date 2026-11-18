<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PromotionalOffer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'promotional_offers';

    protected $fillable = [
        'name',
        'room_type_id',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'is_active',
        'max_discount',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'discount_value' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /**
     * Get the room type this offer applies to
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Scope: Get active promotional offers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get offers valid for a specific datetime
     */
    public function scopeValidForDateTime($query, Carbon $dateTime)
    {
        return $query->where('start_date', '<=', $dateTime)
            ->where('end_date', '>=', $dateTime)
            ->where('is_active', true);
    }

    /**
     * Scope: Get offers for a specific room type and datetime range
     */
    public function scopeForRoomTypeAndDateRange($query, $roomTypeId, Carbon $startDate, Carbon $endDate)
    {
        return $query->where('room_type_id', $roomTypeId)
            ->where('is_active', true)
            ->where('end_date', '>=', $startDate)
            ->where('start_date', '<=', $endDate);
    }

    /**
     * Check if this offer is currently active
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();
        return $this->is_active && $now->gte($this->start_date) && $now->lte($this->end_date);
    }

    /**
     * Calculate discount amount for a given price
     */
    public function calculateDiscountAmount($basePrice): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($basePrice * $this->discount_value) / 100;
            // Apply max discount if set
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            return (float) $discount;
        } else {
            // Fixed amount discount
            return (float) $this->discount_value;
        }
    }

    /**
     * Get human-readable discount display
     */
    public function getDiscountLabel(): string
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '% off';
        } else {
            return '₹' . $this->discount_value . ' off';
        }
    }

    /**
     * Check if discount overlaps with another time range
     */
    public function overlapsWith(Carbon $startDate, Carbon $endDate): bool
    {
        return !($this->end_date->lt($startDate) || $this->start_date->gt($endDate));
    }
}
