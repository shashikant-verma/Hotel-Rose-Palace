<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryImage;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Purge old dummy records and duplicates to guarantee clean 15 unique property photos
        GalleryImage::truncate();

        $galleryPhotos = [
            // Exterior & Building (3 photos)
            [
                'title' => 'Hotel Rose Palace Exterior Building View',
                'category' => 'Exterior & Building',
                'image_path' => 'gallery/exterior-building-view.jpg',
                'image_url' => '/images/gallery/exterior-building-view.jpg',
                'alt_text' => 'Hotel Rose Palace exterior facade and signage at Atlanta Business Hub, VIP Road, Vesu, Surat',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Outer Area of All Rooms – Guest Floor Corridor',
                'category' => 'Exterior & Building',
                'image_path' => 'gallery/outer-rooms-corridor.jpg',
                'image_url' => '/images/gallery/outer-rooms-corridor.jpg',
                'alt_text' => 'Outer area and hallway corridor connecting all guest rooms on Floor 1 with polished marble flooring',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Main Entrance Glass Door',
                'category' => 'Exterior & Building',
                'image_path' => 'gallery/entrance-glass-door.jpg',
                'image_url' => '/images/gallery/entrance-glass-door.jpg',
                'alt_text' => 'Hotel Rose Palace frosted glass entrance door with floral arrangement',
                'display_order' => 3,
                'is_active' => true,
            ],

            // Reception & Lobby (3 photos)
            [
                'title' => 'Front Desk & Reception Area',
                'category' => 'Reception & Lobby',
                'image_path' => 'gallery/front-desk-reception.jpg',
                'image_url' => '/images/gallery/front-desk-reception.jpg',
                'alt_text' => 'Hotel Rose Palace front desk counter with warm illumination and reception lounge',
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Guest Waiting Lounge',
                'category' => 'Reception & Lobby',
                'image_path' => 'gallery/guest-waiting-lounge.jpg',
                'image_url' => '/images/gallery/guest-waiting-lounge.jpg',
                'alt_text' => 'Comfortable guest waiting lounge with plush seating and marble coffee table',
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Grand Reception & Front Desk Lounge',
                'category' => 'Reception & Lobby',
                'image_path' => 'gallery/reception-lobby-lounge.jpg',
                'image_url' => '/images/gallery/reception-lobby-lounge.jpg',
                'alt_text' => 'Grand reception desk, plush sofa lounge, and warm illumination at Hotel Rose Palace',
                'display_order' => 6,
                'is_active' => true,
            ],

            // Deluxe Family Rooms (3 photos)
            [
                'title' => 'Deluxe Family Room – King Bed',
                'category' => 'Deluxe Family Rooms',
                'image_path' => 'gallery/deluxe-family-king-bed.jpg',
                'image_url' => '/images/gallery/deluxe-family-king-bed.jpg',
                'alt_text' => 'Deluxe Family Room featuring plush king bed, sitting table, and ample wardrobe space',
                'display_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Deluxe Family Room – Room 102 Layout',
                'category' => 'Deluxe Family Rooms',
                'image_path' => 'gallery/deluxe-family-room-102.jpg',
                'image_url' => '/images/gallery/deluxe-family-room-102.jpg',
                'alt_text' => 'Deluxe Family Room 102 layout with king bedding and warm wooden furnishings',
                'display_order' => 8,
                'is_active' => true,
            ],
            [
                'title' => 'Deluxe Family Room – Wardrobe & Dressing Area',
                'category' => 'Deluxe Family Rooms',
                'image_path' => 'gallery/deluxe-family-wardrobe.jpg',
                'image_url' => '/images/gallery/deluxe-family-wardrobe.jpg',
                'alt_text' => 'Deluxe Family Room dressing mirror and spacious wardrobe unit',
                'display_order' => 9,
                'is_active' => true,
            ],

            // Executive Rooms (5 photos)
            [
                'title' => 'Executive Room – City View Window',
                'category' => 'Executive Rooms',
                'image_path' => 'gallery/executive-room-city-view.jpg',
                'image_url' => '/images/gallery/executive-room-city-view.jpg',
                'alt_text' => 'Executive Room featuring city view window, air conditioning, and wall-mounted TV',
                'display_order' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Executive Room – Warm Ambient Lighting',
                'category' => 'Executive Rooms',
                'image_path' => 'gallery/executive-room-warm-lighting.jpg',
                'image_url' => '/images/gallery/executive-room-warm-lighting.jpg',
                'alt_text' => 'Executive Room with recessed cove lighting and contemporary headboard',
                'display_order' => 11,
                'is_active' => true,
            ],
            [
                'title' => 'Executive Room – Gold Trim Feature Wall',
                'category' => 'Executive Rooms',
                'image_path' => 'gallery/executive-room-gold-molding.jpg',
                'image_url' => '/images/gallery/executive-room-gold-molding.jpg',
                'alt_text' => 'Executive Room featuring elegant gold trim molding wall and king bed',
                'display_order' => 12,
                'is_active' => true,
            ],
            [
                'title' => 'Executive Room – King Bed & Console',
                'category' => 'Executive Rooms',
                'image_path' => 'gallery/executive-room-king-bed.jpg',
                'image_url' => '/images/gallery/executive-room-king-bed.jpg',
                'alt_text' => 'Executive Room with comfortable king bed, TV console, and reading lighting',
                'display_order' => 13,
                'is_active' => true,
            ],
            [
                'title' => 'Executive Room – Interior View',
                'category' => 'Executive Rooms',
                'image_path' => 'gallery/executive-room-interior.jpg',
                'image_url' => '/images/gallery/executive-room-interior.jpg',
                'alt_text' => 'Executive Room interior view with work table, comfortable chair, and soft lighting',
                'display_order' => 14,
                'is_active' => true,
            ],

            // Bathrooms & Amenities (1 photo)
            [
                'title' => 'Attached Modern Washroom',
                'category' => 'Bathrooms & Amenities',
                'image_path' => 'gallery/attached-modern-washroom.jpg',
                'image_url' => '/images/gallery/attached-modern-washroom.jpg',
                'alt_text' => 'Clean attached washroom with modern ceramic basin, hot/cold shower, and fresh towels',
                'display_order' => 15,
                'is_active' => true,
            ],
        ];

        foreach ($galleryPhotos as $gp) {
            GalleryImage::updateOrCreate(
                ['image_path' => $gp['image_path']],
                $gp
            );
        }
    }
}
