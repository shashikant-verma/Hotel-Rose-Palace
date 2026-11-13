<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            [
                'name' => 'Free Wi-Fi',
                'description' => 'High-speed internet connection in all rooms',
                'icon_class' => 'fas fa-wifi',
                'category' => 'Technology',
            ],
            [
                'name' => 'Free Parking',
                'description' => 'Private parking available for all guests',
                'icon_class' => 'fas fa-car',
                'category' => 'Parking',
            ],
            [
                'name' => '24-Hour Front Desk',
                'description' => 'Round-the-clock assistance from our staff',
                'icon_class' => 'fas fa-bell',
                'category' => 'Services',
            ],
            [
                'name' => 'Room Service',
                'description' => '24/7 in-room tea, coffee, and assistance',
                'icon_class' => 'fas fa-concierge-bell',
                'category' => 'Services',
            ],
            [
                'name' => 'Laundry Service',
                'description' => 'Professional laundry and ironing services',
                'icon_class' => 'fas fa-soap',
                'category' => 'Services',
            ],
            [
                'name' => 'Air Conditioning',
                'description' => 'Climate-controlled rooms for your comfort',
                'icon_class' => 'fas fa-wind',
                'category' => 'Amenities',
            ],
            [
                'name' => 'Television',
                'description' => 'Flat-screen TV with cable channels',
                'icon_class' => 'fas fa-tv',
                'category' => 'Entertainment',
            ],
            [
                'name' => 'Private Bathroom',
                'description' => 'Ensuite bathroom with premium toiletries',
                'icon_class' => 'fas fa-bath',
                'category' => 'Amenities',
            ],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}
