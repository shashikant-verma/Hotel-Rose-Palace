<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference_id',
        'booking_ref',
        'room_type_id',
        'room_id',
        'booking_type',
        'customer_name',
        'guest_name',
        'customer_email',
        'customer_phone',
        'phone',
        'id_proof_type',
        'id_proof_number',
        'check_in_date',
        'check_in',
        'check_out_date',
        'check_out',
        'num_adults',
        'num_children',
        'special_requests',
        'payment_mode',
        'payment_status',
        'paid_amount',
        'total_tariff',
        'total_amount',
        'status',
        'internal_notes',
        'whatsapp_message_sent_at',
        'contacted_at',
        'confirmed_at',
        'checked_in_at',
        'checked_out_at',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_in' => 'date',
            'check_out_date' => 'date',
            'check_out' => 'date',
            'paid_amount' => 'decimal:2',
            'total_tariff' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'whatsapp_message_sent_at' => 'datetime',
            'contacted_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'checked_in_at' => 'datetime',
            'checked_out_at' => 'datetime',
        ];
    }

    public function getBookingRefAttribute($value)
    {
        return $value ?? $this->reference_id;
    }

    public function getGuestNameAttribute($value)
    {
        return $value ?? $this->customer_name;
    }

    public function getGuestEmailAttribute()
    {
        return $this->customer_email;
    }

    public function getGuestPhoneAttribute()
    {
        return $this->customer_phone;
    }

    public function getPhoneAttribute($value)
    {
        return $value ?? $this->customer_phone;
    }

    public function getCheckInAttribute($value)
    {
        return $value ?? $this->check_in_date;
    }

    public function getCheckOutAttribute($value)
    {
        return $value ?? $this->check_out_date;
    }

    public function getTotalAmountAttribute($value)
    {
        return $value ?? $this->total_tariff;
    }

    public function getAdultsAttribute()
    {
        return $this->num_adults;
    }

    public function getChildrenAttribute()
    {
        return $this->num_children;
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getNightsAttribute(): int
    {
        $d1 = $this->check_in_date ?? $this->check_in;
        $d2 = $this->check_out_date ?? $this->check_out;
        if (!$d1 || !$d2) return 1;
        $diff = $d1->diffInDays($d2);
        return $diff > 0 ? $diff : 1;
    }

    public function getCgstAttribute(): float
    {
        $base = (float)($this->total_tariff > 0 ? $this->total_tariff : ($this->total_amount ? $this->total_amount / 1.12 : 0));
        return round($base * 0.06, 2);
    }

    public function getSgstAttribute(): float
    {
        $base = (float)($this->total_tariff > 0 ? $this->total_tariff : ($this->total_amount ? $this->total_amount / 1.12 : 0));
        return round($base * 0.06, 2);
    }

    public function getGrandTotalAttribute(): float
    {
        $base = (float)($this->total_tariff > 0 ? $this->total_tariff : ($this->total_amount ? $this->total_amount / 1.12 : 0));
        return round($base + ($base * 0.12), 2);
    }

    public function getBalanceDueAttribute(): float
    {
        return max(0, $this->grand_total - (float)$this->paid_amount);
    }

    public static function getStatuses()
    {
        return [
            'new' => 'New Enquiry',
            'pending' => 'Pending',
            'contacted' => 'Contacted',
            'availability_confirmed' => 'Availability Confirmed',
            'confirmed' => 'Confirmed',
            'booking_confirmed' => 'Booking Confirmed',
            'checked_in' => 'Checked In',
            'checked_out' => 'Checked Out',
            'cancelled' => 'Cancelled',
            'closed' => 'Closed',
        ];
    }
}
