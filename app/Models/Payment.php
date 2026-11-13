<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount',
        'currency',
        'status',
        'method',
        'card_network',
        'card_last4',
        'bank',
        'wallet',
        'vpa',
        'fee',
        'tax',
        'error_code',
        'error_description',
        'refund_id',
        'refund_status',
        'refund_amount',
        'refund_reason',
        'refunded_at',
        'refund_attempts',
        'refund_initiated_at',
        'refund_error',
        'captured_at',
        'idempotency_key',
        'payload',
        'raw_response',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'fee' => 'decimal:2',
            'tax' => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'refunded_at' => 'datetime',
            'captured_at' => 'datetime',
            'payload' => 'array',
            'raw_response' => 'array',
        ];
    }

    /**
     * Booking associated with this payment
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Audit logs for this payment
     */
    public function logs()
    {
        return $this->hasMany(PaymentLog::class);
    }

    /**
     * Scope for successful captured payments
     */
    public function scopeCaptured($query)
    {
        return $query->where('status', 'captured');
    }

    /**
     * Scope for refunded payments
     */
    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    /**
     * Check if payment is successful/captured
     */
    public function isCaptured(): bool
    {
        return $this->status === 'captured';
    }

    /**
     * Check if payment is fully or partially refunded
     */
    public function isRefunded(): bool
    {
        return in_array($this->status, ['refunded', 'refund_pending']);
    }
}
