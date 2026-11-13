<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BanquetBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference_id',
        'event_name',
        'organizer_name',
        'phone',
        'customer_name',
        'customer_phone',
        'customer_email',
        'event_date',
        'slot',
        'time_slot',
        'event_type',
        'guest_count',
        'seating_layout',
        'catering_package',
        'total_amount',
        'advance_paid',
        'payment_mode',
        'payment_status',
        'status',
        'special_notes',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'total_amount' => 'decimal:2',
            'advance_paid' => 'decimal:2',
            'guest_count' => 'integer',
        ];
    }

    public function getEventNameAttribute($value)
    {
        return $value ?? $this->event_type;
    }

    public function getOrganizerNameAttribute($value)
    {
        return $value ?? $this->customer_name;
    }

    public function getPhoneAttribute($value)
    {
        return $value ?? $this->customer_phone;
    }

    public function getTimeSlotAttribute($value)
    {
        return $value ?? $this->slot;
    }

    public function getBalanceDueAttribute(): float
    {
        return max(0, (float)$this->total_amount - (float)$this->advance_paid);
    }
}
