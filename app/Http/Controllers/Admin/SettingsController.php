<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelSettings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display settings management page
     */
    public function index()
    {
        // Get all settings as key-value pairs for easy access in view
        $settingsData = HotelSettings::all()->pluck('setting_value', 'setting_key')->toArray();
        
        // Define default values
        $defaults = [
            'hotel_name' => 'Hotel Rose Palace',
            'hotel_tagline' => 'Luxury Stay in Surat',
            'hotel_description' => 'Welcome to Hotel Rose Palace',
            'hotel_address' => '4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007',
            'contact_phone' => '+91 1234567890',
            'whatsapp_number' => '+91 1234567890',
            'contact_email' => 'info@hotelrosepalace.com',
            'social_facebook' => '',
            'social_instagram' => '',
            'social_twitter' => '',
            'social_youtube' => '',
            'checkin_time' => '14:00',
            'checkout_time' => '11:00',
            'reception_hours' => '24/7',
            'meta_title' => 'Hotel Rose Palace - Luxury Stay in Surat',
            'meta_description' => 'Experience luxury accommodation at Hotel Rose Palace in Surat. Modern amenities, comfortable rooms, and excellent service.',
            'meta_keywords' => 'hotel surat, luxury hotel, rose palace, accommodation surat',
        ];
        
        // Merge with defaults so missing settings have fallback values
        $settings = array_merge($defaults, $settingsData);

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update hotel settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string|max:1000',
        ]);

        $updated = 0;
        foreach ($validated['settings'] as $key => $value) {
            HotelSettings::setValue($key, $value);
            $updated++;
        }

        return back()->with('success', "{$updated} settings updated successfully!");
    }

    /**
     * Update specific setting
     */
    public function updateSetting(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string|max:1000',
        ]);

        HotelSettings::setValue($validated['key'], $validated['value']);

        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully'
        ]);
    }

    /**
     * Create new setting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'setting_key' => 'required|string|unique:hotel_settings,setting_key|max:100',
            'setting_value' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:255',
            'setting_type' => 'required|in:text,number,boolean,email,url',
        ]);

        HotelSettings::create($validated);

        return back()->with('success', 'Setting created successfully!');
    }

    /**
     * Delete a setting
     */
    public function destroy($id)
    {
        $setting = HotelSettings::findOrFail($id);
        $setting->delete();

        return back()->with('success', 'Setting deleted successfully!');
    }
}
