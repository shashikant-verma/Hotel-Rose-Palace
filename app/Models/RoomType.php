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
        'max_occupancy',
        'max_adults',
        'max_children',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'base_price' => 'decimal:2',
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
}
