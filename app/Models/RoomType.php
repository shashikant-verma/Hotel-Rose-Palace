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
     * Get all room images across rooms of this type
     */
    public function roomImages()
    {
        return $this->hasManyThrough(RoomImage::class, Room::class)->orderBy('display_order');
    }

    /**
     * Get all genuine gallery photos for this room type.
     * Uses the authentic photographs provided in public/images/rooms/ mapped to physical rooms.
     *
     * @return array<int, array{url: string, path: string, title: string, is_featured: bool}>
     */
    public function getGalleryPhotos(): array
    {
        $photos = [];
        $seen = [];

        $unwantedPatterns = [
            'attached-luxury-bathroom',
            'deluxe-room-blue-cove',
            'deluxe.jpg',
            'deluxe-king.jpg',
            'deluxe-city-view.jpg',
            'room-deluxe.jpg',
            '6.55.10', // Reception lounge
            '7.02.18', // Glass entrance door
            '7.06.17', // Building exterior
            '7.07.04', // Reception desk
            '7.12.47', // Bathroom
            '7.18.16', // Reception desk & lounge
        ];

        $isUnwanted = function ($path) use ($unwantedPatterns) {
            foreach ($unwantedPatterns as $pattern) {
                if (str_contains($path, $pattern)) {
                    return true;
                }
            }
            return false;
        };

        // 1. Physical room genuine photos from public/images/rooms/
        if ($this->relationLoaded('rooms')) {
            foreach ($this->rooms as $room) {
                if (!empty($room->image_path) && !$isUnwanted($room->image_path)) {
                    $url = asset($room->image_path);
                    if (!isset($seen[$url])) {
                        $seen[$url] = true;
                        $photos[] = [
                            'url' => $url,
                            'path' => $room->image_path,
                            'title' => $this->name . ' - Room ' . $room->room_number,
                            'is_featured' => empty($photos),
                        ];
                    }
                }

                if ($room->relationLoaded('images')) {
                    foreach ($room->images as $img) {
                        $path = $img->image_path ?? '';
                        if (!empty($path) && !$isUnwanted($path)) {
                            $url = !empty($img->image_url) ? $img->image_url : \Illuminate\Support\Facades\Storage::url($path);
                            if (!isset($seen[$url])) {
                                $seen[$url] = true;
                                $photos[] = [
                                    'url' => $url,
                                    'path' => $path,
                                    'title' => $this->name,
                                    'is_featured' => empty($photos),
                                ];
                            }
                        }
                    }
                }
            }
        }

        // 2. If no photos gathered yet (e.g. In unit tests), fallback to authentic WhatsApp room photos
        if (empty($photos)) {
            $isExecutive = str_contains(strtolower($this->slug ?? ''), 'executive') || str_contains(strtolower($this->name ?? ''), 'executive');
            if ($isExecutive) {
                $fallbackImages = [
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.54.48 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.55.00 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.54.03 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 7.22.49 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 7.23.41 PM.jpeg',
                ];
            } else {
                $fallbackImages = [
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.53.49 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.54.03 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.54.15 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.54.26 PM.jpeg',
                    'images/rooms/WhatsApp Image 2026-11-17 at 6.54.38 PM.jpeg',
                ];
            }

            foreach ($fallbackImages as $idx => $p) {
                $url = asset($p);
                $photos[] = [
                    'url' => $url,
                    'path' => $p,
                    'title' => $this->name . ' - Photo ' . ($idx + 1),
                    'is_featured' => ($idx === 0),
                ];
            }
        }

        return $photos;
    }
}
