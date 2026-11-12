<?php

/**
 * Hotel Rose Palace Configuration
 * 
 * This file contains hotel-specific configuration
 */

return [
    'name' => 'Hotel Rose Palace',
    
    'location' => [
        'address' => '4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007',
        'city' => 'Surat',
        'state' => 'Gujarat',
        'country' => 'India',
        'pincode' => '395007',
    ],
    
    'contact' => [
        'phone_1' => '+91 87991 29929',
        'phone_2' => '+91 8071 515 210',
        'email' => env('HOTEL_EMAIL', 'info@hotelrosepalace.com'),
        'whatsapp_number' => env('WHATSAPP_NUMBER', '+91 87991 29929'),
        'instagram' => 'https://www.instagram.com/hotelrosepalace9',
        'google_maps' => 'https://maps.app.goo.gl/1xEWyWLUTnMqAc4q8',
    ],
    
    'rooms' => [
        'categories' => [
            'standard' => 'Standard Double Room',
            'superior' => 'Superior Room',
            'executive' => 'Executive / Family Room',
        ],
    ],
    
    'amenities' => [
        'Free Wi-Fi',
        'Free Parking',
        '24-Hour Front Desk',
        'Restaurant',
        'Room Service',
        'Laundry Service',
        'Air Conditioning',
        'Television',
        'Private Bathroom',
    ],
    
    'enquiry' => [
        'statuses' => [
            'new' => 'New',
            'contacted' => 'Contacted',
            'availability_confirmed' => 'Availability Confirmed',
            'booking_confirmed' => 'Booking Confirmed',
            'cancelled' => 'Cancelled',
            'closed' => 'Closed',
        ],
    ],
];
