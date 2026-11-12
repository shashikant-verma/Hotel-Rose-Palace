<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelSettings extends Model
{
    use HasFactory;

    protected $table = 'hotel_settings';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'description',
        'setting_type',
    ];

    /**
     * Get a setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = static::where('setting_key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Cast value based on type
        switch ($setting->setting_type) {
            case 'boolean':
                return (bool) $setting->setting_value;
            case 'number':
                return (int) $setting->setting_value;
            default:
                return $setting->setting_value;
        }
    }

    /**
     * Set a setting value
     */
    public static function setValue($key, $value)
    {
        return static::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value]
        );
    }
}
