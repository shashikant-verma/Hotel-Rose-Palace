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
        // Get all settings grouped by type
        $settings = HotelSettings::orderBy('setting_key')->get()->groupBy(function($item) {
            // Group by prefix (e.g., hotel_, contact_, social_)
            $parts = explode('_', $item->setting_key);
            return $parts[0] ?? 'general';
        });

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
