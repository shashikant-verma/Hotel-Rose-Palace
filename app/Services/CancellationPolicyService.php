<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;

class CancellationPolicyService
{
    public const TIMEZONE = 'Asia/Kolkata';
    public const CHECK_IN_HOUR = 12; // 12:00 PM (Noon)
    public const CHECK_IN_MINUTE = 0;
    public const CHECK_IN_SECOND = 0;

    /**
     * Get the exact check-in DateTime for a booking in Asia/Kolkata timezone.
     */
    public function getCheckInDateTime(Booking $booking): Carbon
    {
        $dateStr = $booking->check_in_date instanceof Carbon
            ? $booking->check_in_date->format('Y-m-d')
            : Carbon::parse($booking->check_in_date)->format('Y-m-d');

        return Carbon::createFromFormat(
            'Y-m-d H:i:s',
            sprintf('%s %02d:%02d:%02d', $dateStr, self::CHECK_IN_HOUR, self::CHECK_IN_MINUTE, self::CHECK_IN_SECOND),
            self::TIMEZONE
        );
    }

    /**
     * Calculate refund eligibility, percentage, and amount for a booking.
     * All calculations are anchored to Asia/Kolkata timezone and use integer paise.
     *
     * @param Booking $booking
     * @param Carbon|null $cancellationTime Optional time of cancellation request (for testing / point-in-time calculation)
     * @return array
     */
    public function calculateRefund(Booking $booking, ?Carbon $cancellationTime = null): array
    {
        $cancellationTime = $cancellationTime
            ? $cancellationTime->copy()->setTimezone(self::TIMEZONE)
            : Carbon::now(self::TIMEZONE);

        $checkInDateTime = $this->getCheckInDateTime($booking);

        // Difference in seconds until check-in (positive if before check-in, negative if after)
        $secondsUntilCheckIn = $cancellationTime->diffInSeconds($checkInDateTime, false);
        $hoursUntilCheckIn = round($secondsUntilCheckIn / 3600, 2);

        // Fetch verified captured payment amount (gross amount including GST)
        $payment = $booking->successfulPayment ?? $booking->payments()->where('status', 'captured')->latest()->first();
        $grossAmount = $payment ? (float) $payment->amount : (float) $booking->total_amount;
        $grossPaise = (int) round($grossAmount * 100);

        // Determine tier based on confirmed Hotel Rose Palace business policy
        if ($secondsUntilCheckIn >= 86400) {
            // Tier 1: 24 hours or more before check-in -> 100% full refund
            $percentage = 100;
            $refundPaise = $grossPaise;
            $tier = 'full';
            $policyDescription = '100% Full Refund: Cancellation requested 24 hours or more prior to 12:00 PM check-in.';
        } elseif ($secondsUntilCheckIn > 0) {
            // Tier 2: Less than 24 hours before check-in, but before check-in -> 50% partial refund
            $percentage = 50;
            $refundPaise = intdiv($grossPaise, 2);
            $tier = 'partial';
            $policyDescription = '50% Partial Refund: Cancellation requested less than 24 hours prior to 12:00 PM check-in.';
        } else {
            // Tier 3: At or after check-in / No-show -> 0% non-refundable
            $percentage = 0;
            $refundPaise = 0;
            $tier = 'non_refundable';
            $policyDescription = 'Non-refundable (0%): Cancellation requested at or after 12:00 PM check-in time.';
        }

        $refundAmount = (float) number_format($refundPaise / 100, 2, '.', '');
        $cancellationFeePaise = $grossPaise - $refundPaise;
        $cancellationFee = (float) number_format($cancellationFeePaise / 100, 2, '.', '');

        return [
            'percentage' => $percentage,
            'tier' => $tier,
            'gross_amount' => (float) number_format($grossAmount, 2, '.', ''),
            'gross_amount_paise' => $grossPaise,
            'refund_amount' => $refundAmount,
            'refund_amount_paise' => $refundPaise,
            'cancellation_fee' => $cancellationFee,
            'cancellation_fee_paise' => $cancellationFeePaise,
            'seconds_until_check_in' => $secondsUntilCheckIn,
            'hours_until_check_in' => $hoursUntilCheckIn,
            'check_in_datetime' => $checkInDateTime,
            'cancellation_time' => $cancellationTime,
            'policy_description' => $policyDescription,
            'is_eligible' => $this->isEligibleForCancellation($booking),
        ];
    }

    /**
     * Check if a booking is currently eligible to request cancellation.
     */
    public function isEligibleForCancellation(Booking $booking): bool
    {
        // Must not already be cancelled
        if (!is_null($booking->cancelled_at) || $booking->booking_status === 'cancelled') {
            return false;
        }

        // Must not already have a pending cancellation request
        if ($booking->cancellation_status === 'pending' || $booking->booking_status === 'cancellation_requested') {
            return false;
        }

        // Must be a successfully paid booking
        if ($booking->payment_status !== 'paid') {
            return false;
        }

        // Cannot cancel if already checked out
        if ($booking->booking_status === 'checked_out') {
            return false;
        }

        return true;
    }
}
