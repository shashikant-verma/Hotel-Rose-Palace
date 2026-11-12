<?php

namespace Database\Seeders;

use App\Models\HotelSettings;
use Illuminate\Database\Seeder;

class HotelSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'setting_key' => 'hotel_name',
                'setting_value' => 'Hotel Rose Palace',
                'description' => 'Hotel name',
                'setting_type' => 'text',
            ],
            [
                'setting_key' => 'hotel_tagline',
                'setting_value' => 'Where Elegance Meets Comfort',
                'description' => 'Hotel tagline/slogan',
                'setting_type' => 'text',
            ],
            [
                'setting_key' => 'hotel_address',
                'setting_value' => '4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007',
                'description' => 'Hotel address',
                'setting_type' => 'textarea',
            ],
            [
                'setting_key' => 'hotel_phone_1',
                'setting_value' => '+91 70424 24242',
                'description' => 'Primary contact phone',
                'setting_type' => 'text',
            ],
            [
                'setting_key' => 'hotel_phone_2',
                'setting_value' => '+91 8071 515 210',
                'description' => 'Secondary contact phone',
                'setting_type' => 'text',
            ],
            [
                'setting_key' => 'hotel_email',
                'setting_value' => 'info@hotelrosepalace.com',
                'description' => 'Hotel email address',
                'setting_type' => 'text',
            ],
            [
                'setting_key' => 'whatsapp_number',
                'setting_value' => '+91xxxxxxxxx',
                'description' => 'WhatsApp number for enquiries (update with actual number)',
                'setting_type' => 'text',
            ],
            [
                'setting_key' => 'google_maps_embed',
                'setting_value' => '',
                'description' => 'Google Maps embed code',
                'setting_type' => 'textarea',
            ],
            [
                'setting_key' => 'website_logo_url',
                'setting_value' => '/images/logo.png',
                'description' => 'Website logo URL',
                'setting_type' => 'url',
            ],
            [
                'setting_key' => 'privacy_policy',
                'setting_value' => '<p>Hotel Rose Palace respects your privacy...</p>',
                'description' => 'Privacy policy content',
                'setting_type' => 'textarea',
            ],
            [
                'setting_key' => 'terms_conditions',
                'setting_value' => '<p>Terms and conditions for booking...</p>',
                'description' => 'Terms and conditions content',
                'setting_type' => 'textarea',
            ],
            [
                'setting_key' => 'cancellation_policy',
                'setting_value' => '<p>Cancellation policy information...</p>',
                'description' => 'Cancellation policy content',
                'setting_type' => 'textarea',
            ],
        ];

        foreach ($settings as $setting) {
            HotelSettings::create($setting);
        }
    }
}
