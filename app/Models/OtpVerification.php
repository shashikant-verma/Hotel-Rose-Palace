<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile_number',
        'otp_hash',
        'purpose',
        'expires_at',
        'verified',
        'verified_at',
        'attempt_count',
        'last_attempt_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'last_attempt_at' => 'datetime',
            'verified' => 'boolean',
            'attempt_count' => 'integer',
        ];
    }

    /**
     * Check if OTP has expired
     */
    public function hasExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }

    /**
     * Check if OTP is still valid (not expired and not verified)
     */
    public function isValid(): bool
    {
        return !$this->hasExpired() && !$this->verified;
    }

    /**
     * Check if maximum attempts exceeded
     */
    public function attemptsExceeded(int $maxAttempts = 5): bool
    {
        return $this->attempt_count >= $maxAttempts;
    }

    /**
     * Increment attempt count
     */
    public function incrementAttempt(): void
    {
        $this->increment('attempt_count');
        $this->update(['last_attempt_at' => now()]);
    }

    /**
     * Mark as verified
     */
    public function markVerified(): void
    {
        $this->update([
            'verified' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Scope: Only valid OTPs
     */
    public function scopeValid($query)
    {
        return $query->where('verified', false)
            ->where('expires_at', '>', now());
    }

    /**
     * Scope: By mobile number
     */
    public function scopeByMobile($query, $mobile)
    {
        return $query->where('mobile_number', $mobile);
    }

    /**
     * Scope: By purpose
     */
    public function scopeByPurpose($query, $purpose)
    {
        return $query->where('purpose', $purpose);
    }

    /**
     * Scope: Most recent for mobile
     */
    public function scopeLatestForMobile($query, $mobile, $purpose = null)
    {
        $query->byMobile($mobile);
        
        if ($purpose) {
            $query->byPurpose($purpose);
        }
        
        return $query->latest('created_at');
    }
}
