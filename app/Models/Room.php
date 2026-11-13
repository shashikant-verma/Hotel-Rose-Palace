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
        'floor',
        'current_price',
        'is_available',
        'status',
        'housekeeping_status',
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
}
