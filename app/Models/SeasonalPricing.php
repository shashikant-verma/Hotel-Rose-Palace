<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SeasonalPricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'seasonal_pricing';

    protected $fillable = [
        'room_type_id',
        'price',
        'start_date',
        'end_date',
        'season_name',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the room type this seasonal pricing belongs to
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Scope: Get active seasonal pricing
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get seasonal pricing valid for a specific date
     */
    public function scopeValidForDate($query, Carbon $date)
    {
        return $query->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->where('is_active', true);
    }

    /**
     * Scope: Get seasonal pricing for a specific room type and date range
     */
    public function scopeForRoomTypeAndDateRange($query, $roomTypeId, Carbon $startDate, Carbon $endDate)
    {
        return $query->where('room_type_id', $roomTypeId)
            ->where('is_active', true)
            ->where('end_date', '>=', $startDate)
            ->where('start_date', '<=', $endDate);
    }

    /**
     * Check if a date is within the seasonal pricing period
     */
    public function appliesToDate(Carbon $date): bool
    {
        return $date->gte($this->start_date) && $date->lte($this->end_date) && $this->is_active;
    }

    /**
     * Check if this seasonal pricing overlaps with another date range
     */
    public function overlapsWith(Carbon $startDate, Carbon $endDate): bool
    {
        return !($this->end_date->lt($startDate) || $this->start_date->gt($endDate));
    }

    /**
     * Get human-readable period
     */
    public function getPeriodLabel(): string
    {
        if ($this->season_name) {
            return $this->season_name . ' (' . $this->start_date->format('M d') . ' - ' . $this->end_date->format('M d') . ')';
        }
        return $this->start_date->format('M d') . ' - ' . $this->end_date->format('M d');
    }
}
