<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'original_price',
        'max_occupancy',
        'max_adults',
        'max_children',
        'size_sqft',
        'bed_type',
        'view_type',
        'bedroom_count',
        'living_room_count',
        'bathroom_count',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'base_price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'size_sqft' => 'integer',
            'bedroom_count' => 'integer',
            'living_room_count' => 'integer',
            'bathroom_count' => 'integer',
            'max_occupancy' => 'integer',
            'max_adults' => 'integer',
            'max_children' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get the rooms of this type
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the amenities for this room type
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Get the enquiries for this room type
     */
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * Get the seasonal pricing for this room type
     */
    public function seasonalPricing()
    {
        return $this->hasMany(SeasonalPricing::class);
    }

    /**
     * Get the promotional offers for this room type
     */
    public function promotionalOffers()
    {
        return $this->hasMany(PromotionalOffer::class);
    }
}
