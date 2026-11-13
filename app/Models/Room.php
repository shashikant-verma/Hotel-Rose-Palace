<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_type_id',
        'room_number',
        'category',
        'floor',
        'current_price',
        'price_per_night',
        'max_guests',
        'is_available',
        'status',
        'housekeeping_status',
        'image_path',
    ];

    /**
     * Get the enquiries/bookings for this room
     */
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'current_price' => 'decimal:2',
            'price_per_night' => 'decimal:2',
            'max_guests' => 'integer',
        ];
    }

    /**
     * Get the room type
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the images for this room
     */
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    /**
     * Get the featured image
     */
    public function featuredImage()
    {
        return $this->hasOne(RoomImage::class)->where('is_featured', true);
    }

    public function getCategoryAttribute($value)
    {
        return $value ?? $this->roomType?->name ?? 'Standard Room';
    }

    public function getPricePerNightAttribute($value)
    {
        return $value ?? $this->current_price;
    }

    public function getMaxGuestsAttribute($value)
    {
        return $value ?? $this->roomType?->max_occupancy ?? 2;
    }
}
