<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_id',
        'event',
        'channel',
        'details',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Polymorphic helper to log payment events safely
     */
    public static function record(
        $arg1 = null,
        $arg2 = null,
        $arg3 = null,
        $arg4 = 'checkout',
        $arg5 = []
    ): self {
        $bookingId = null;
        $paymentId = null;
        $event = 'event';
        $channel = 'checkout';
        $details = [];

        if (is_string($arg1)) {
            // record(string $event, ?int $bookingId, ?int $paymentId, string $channel, array $details)
            $event = $arg1;
            $bookingId = is_numeric($arg2) ? (int) $arg2 : null;
            $paymentId = is_numeric($arg3) ? (int) $arg3 : null;
            $channel = is_string($arg4) ? $arg4 : 'checkout';
            $details = is_array($arg5) ? $arg5 : (is_array($arg4) ? $arg4 : []);
        } else {
            // record(?int $bookingId, ?int $paymentId, string $event, string $channel, array $details)
            $bookingId = is_numeric($arg1) ? (int) $arg1 : null;
            $paymentId = is_numeric($arg2) ? (int) $arg2 : null;
            $event = is_string($arg3) ? $arg3 : 'event';
            $channel = is_string($arg4) ? $arg4 : 'checkout';
            $details = is_array($arg5) ? $arg5 : (is_array($arg4) ? $arg4 : []);
        }

        // Sanitize details: never log secrets, passwords, tokens, cvv or raw signatures
        $sanitizedDetails = collect($details)->map(function ($val, $key) {
            if (in_array(strtolower($key), ['secret', 'key_secret', 'password', 'token', 'cvv', 'signature'])) {
                return '***REDACTED***';
            }
            return $val;
        })->toArray();

        return self::create([
            'booking_id' => $bookingId,
            'payment_id' => $paymentId,
            'event' => $event,
            'channel' => $channel,
            'details' => $sanitizedDetails,
            'ip_address' => request()->ip() ?? null,
            'user_agent' => request()->userAgent() ?? null,
        ]);
    }
}
