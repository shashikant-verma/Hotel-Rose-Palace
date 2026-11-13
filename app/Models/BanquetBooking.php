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
        'customer_name',
        'customer_phone',
        'customer_email',
        'event_date',
        'slot',
        'event_type',
        'guest_count',
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

    public function getBalanceDueAttribute(): float
    {
        return max(0, (float)$this->total_amount - (float)$this->advance_paid);
    }
}
