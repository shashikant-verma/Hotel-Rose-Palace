<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'image_path',
        'image_url',
        'display_order',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Get the room this image belongs to
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
