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
        'customer_name',
        'customer_email',
        'customer_phone',
        'check_in_date',
        'check_out_date',
        'num_adults',
        'num_children',
        'special_requests',
        'status',
        'internal_notes',
        'whatsapp_message_sent_at',
        'contacted_at',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'whatsapp_message_sent_at' => 'datetime',
            'contacted_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    /**
     * Get the room type for this enquiry
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the statuses enum
     */
    public static function getStatuses()
    {
        return [
            'new' => 'New',
            'contacted' => 'Contacted',
            'availability_confirmed' => 'Availability Confirmed',
            'booking_confirmed' => 'Booking Confirmed',
            'cancelled' => 'Cancelled',
            'closed' => 'Closed',
        ];
    }
}
