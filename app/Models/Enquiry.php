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
        'room_type_id',
        'room_id',
        'booking_type',
        'customer_name',
        'customer_email',
        'customer_phone',
        'id_proof_type',
        'id_proof_number',
        'check_in_date',
        'check_out_date',
        'num_adults',
        'num_children',
        'special_requests',
        'payment_mode',
        'payment_status',
        'paid_amount',
        'total_tariff',
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
            'check_out_date' => 'date',
            'paid_amount' => 'decimal:2',
            'total_tariff' => 'decimal:2',
            'whatsapp_message_sent_at' => 'datetime',
            'contacted_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'checked_in_at' => 'datetime',
            'checked_out_at' => 'datetime',
        ];
    }

    /**
     * Accessor for backwards compatibility (guest_name -> customer_name)
     */
    public function getGuestNameAttribute()
    {
        return $this->customer_name;
    }

    /**
     * Accessor for backwards compatibility (guest_email -> customer_email)
     */
    public function getGuestEmailAttribute()
    {
        return $this->customer_email;
    }

    /**
     * Accessor for backwards compatibility (guest_phone -> customer_phone)
     */
    public function getGuestPhoneAttribute()
    {
        return $this->customer_phone;
    }

    /**
     * Accessor for backwards compatibility (adults -> num_adults)
     */
    public function getAdultsAttribute()
    {
        return $this->num_adults;
    }

    /**
     * Accessor for backwards compatibility (children -> num_children)
     */
    public function getChildrenAttribute()
    {
        return $this->num_children;
    }

    /**
     * Get the room type for this enquiry
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the specific assigned physical room (if assigned)
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Calculate total nights
     */
    public function getNightsAttribute(): int
    {
        if (!$this->check_in_date || !$this->check_out_date) return 1;
        $diff = $this->check_in_date->diffInDays($this->check_out_date);
        return $diff > 0 ? $diff : 1;
    }

    /**
     * Calculate 12% GST breakdown
     */
    public function getCgstAttribute(): float
    {
        $base = (float)$this->total_tariff;
        return round($base * 0.06, 2);
    }

    public function getSgstAttribute(): float
    {
        $base = (float)$this->total_tariff;
        return round($base * 0.06, 2);
    }

    public function getGrandTotalAttribute(): float
    {
        $base = (float)$this->total_tariff;
        return round($base + ($base * 0.12), 2);
    }

    public function getBalanceDueAttribute(): float
    {
        return max(0, $this->grand_total - (float)$this->paid_amount);
    }

    /**
     * Get the statuses enum
     */
    public static function getStatuses()
    {
        return [
            'new' => 'New Enquiry',
            'contacted' => 'Contacted',
            'availability_confirmed' => 'Availability Confirmed',
            'booking_confirmed' => 'Booking Confirmed',
            'checked_in' => 'Checked In',
            'checked_out' => 'Checked Out',
            'cancelled' => 'Cancelled',
            'closed' => 'Closed',
        ];
    }
}
