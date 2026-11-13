<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Log;
use Exception;

class RefundProcessingService
{
    protected RazorpayService $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    /**
     * Process refund for a verified captured booking payment via Razorpay.
     * Enforces integer paise arithmetic, remaining balance limits, and idempotency.
     *
     * @param Booking $booking
     * @param int $refundAmountPaise Amount to refund in paise
     * @param string $reason Cancellation / refund reason
     * @param string|null $idempotencyKey Optional client idempotency key
     * @return array
     * @throws Exception
     */
    public function processRefund(
        Booking $booking,
        int $refundAmountPaise,
        string $reason = 'Customer cancellation approved',
        ?string $idempotencyKey = null
    ): array {
        // 0% Non-refundable tier: Do not initiate Razorpay refund API call
        if ($refundAmountPaise <= 0) {
            return [
                'success' => true,
                'status' => 'not_applicable',
                'amount_paise' => 0,
                'amount_rupees' => 0.00,
                'refund_id' => null,
                'message' => 'No refund initiated (0% non-refundable tier).',
            ];
        }

        // 1. Locate the captured payment for this booking
        $payment = $booking->successfulPayment
            ?? $booking->payments()->where('status', 'captured')->latest()->first()
            ?? $booking->payments()->whereNotNull('razorpay_payment_id')->whereIn('status', ['refund_pending', 'refunded'])->latest()->first();

        if (!$payment) {
            throw new Exception("No captured payment found for booking #{$booking->booking_reference} to refund.");
        }

        if (empty($payment->razorpay_payment_id)) {
            throw new Exception("Payment record #{$payment->id} missing Razorpay Payment ID.");
        }

        // 2. Validate remaining refundable amount (Never exceed remaining refundable captured amount)
        $capturedPaise = (int) round(((float) $payment->amount) * 100);
        $alreadyRefundedPaise = (int) round(((float) ($payment->refund_amount ?? 0)) * 100);
        $remainingRefundablePaise = max(0, $capturedPaise - $alreadyRefundedPaise);

        // Check if locally recorded as already processed to prevent duplicate refund
        if ($payment->refund_status === 'processed' && $alreadyRefundedPaise >= $capturedPaise) {
            return [
                'success' => true,
                'status' => 'processed',
                'amount_paise' => $alreadyRefundedPaise,
                'amount_rupees' => (float) $payment->refund_amount,
                'refund_id' => $payment->refund_id,
                'message' => 'Payment has already been fully refunded.',
                'already_processed' => true,
            ];
        }

        // 3. Active Gateway Reconciliation before retrying:
        // Query Razorpay for any existing refunds already processed or pending on this payment
        // (prevents duplicate dispatch if previous attempt timed out after gateway success)
        try {
            $existingRefundsResponse = $this->razorpayService->fetchPaymentRefunds($payment->razorpay_payment_id);
            $items = $existingRefundsResponse['items'] ?? [];
            if (!empty($items)) {
                $gatewayProcessedPaise = 0;
                $latestProcessedRefund = null;
                $hasPendingRefund = false;
                $latestPendingRefund = null;

                foreach ($items as $item) {
                    $itemStatus = $item['status'] ?? '';
                    $itemAmount = (int) ($item['amount'] ?? 0);

                    if ($itemStatus === 'processed') {
                        $gatewayProcessedPaise += $itemAmount;
                        $latestProcessedRefund = $item;
                    } elseif ($itemStatus === 'pending') {
                        $hasPendingRefund = true;
                        $latestPendingRefund = $item;
                    }
                }

                // If gateway already has processed refunds covering the requested refund
                if ($gatewayProcessedPaise >= $refundAmountPaise && $latestProcessedRefund) {
                    $isFull = $gatewayProcessedPaise >= $capturedPaise;
                    $payment->update([
                        'status' => $isFull ? 'refunded' : 'captured',
                        'refund_id' => $latestProcessedRefund['id'] ?? $payment->refund_id,
                        'refund_status' => 'processed',
                        'refund_amount' => (float) number_format($gatewayProcessedPaise / 100, 2, '.', ''),
                        'refunded_at' => now(),
                        'refund_error' => null,
                    ]);

                    PaymentLog::record(
                        $booking->id,
                        $payment->id,
                        'refund.reconciled_existing',
                        'api',
                        [
                            'refund_id' => $latestProcessedRefund['id'] ?? null,
                            'amount_paise' => $gatewayProcessedPaise,
                            'reason' => 'Existing processed refund found on Razorpay; duplicate refund avoided.',
                        ]
                    );

                    return [
                        'success' => true,
                        'status' => 'processed',
                        'amount_paise' => $gatewayProcessedPaise,
                        'amount_rupees' => (float) number_format($gatewayProcessedPaise / 100, 2, '.', ''),
                        'refund_id' => $latestProcessedRefund['id'] ?? null,
                        'message' => 'Existing verified Razorpay refund reconciled successfully.',
                        'reconciled' => true,
                        'gateway_response' => $latestProcessedRefund,
                    ];
                }

                // If a refund is currently pending on Razorpay, do NOT dispatch a duplicate refund
                if ($hasPendingRefund && $latestPendingRefund) {
                    $pendingPaise = (int) ($latestPendingRefund['amount'] ?? $refundAmountPaise);
                    $payment->update([
                        'status' => 'refund_pending',
                        'refund_id' => $latestPendingRefund['id'] ?? $payment->refund_id,
                        'refund_status' => 'pending',
                        'refund_amount' => (float) number_format($pendingPaise / 100, 2, '.', ''),
                        'refund_error' => null,
                    ]);

                    return [
                        'success' => true,
                        'status' => 'pending',
                        'amount_paise' => $pendingPaise,
                        'amount_rupees' => (float) number_format($pendingPaise / 100, 2, '.', ''),
                        'refund_id' => $latestPendingRefund['id'] ?? null,
                        'message' => 'A refund is already pending banking confirmation on Razorpay.',
                        'reconciled' => true,
                        'gateway_response' => $latestPendingRefund,
                    ];
                }

                // Adjust remaining balance using actual verified gateway processed amount
                $alreadyRefundedPaise = max($alreadyRefundedPaise, $gatewayProcessedPaise);
                $remainingRefundablePaise = max(0, $capturedPaise - $alreadyRefundedPaise);
            }
        } catch (Exception $reconEx) {
            Log::warning('Gateway refund reconciliation query failed: ' . $reconEx->getMessage(), [
                'payment_id' => $payment->razorpay_payment_id,
            ]);
        }

        if ($refundAmountPaise > $remainingRefundablePaise) {
            throw new Exception(
                "Requested refund amount ({$refundAmountPaise} paise) exceeds remaining refundable amount ({$remainingRefundablePaise} paise)."
            );
        }

        // 3. Track refund attempt
        $payment->increment('refund_attempts');
        $payment->update([
            'refund_initiated_at' => now(),
            'refund_reason' => $reason,
        ]);

        $refundAmountRupees = (float) number_format($refundAmountPaise / 100, 2, '.', '');

        // 4. Dispatch refund to payment gateway with idempotency key
        try {
            // Generate deterministic idempotency key based on payment + amount
            // This ensures retries with same parameters return existing refund
            $idempotencyKey = 'refund_' . $payment->razorpay_payment_id . '_' . $refundAmountPaise . '_' . md5($reason ?? '');

            $gatewayResponse = $this->razorpayService->refundPayment(
                $payment->razorpay_payment_id,
                $refundAmountPaise,
                $reason,
                $idempotencyKey  // Pass idempotency key
            );

            $refundId = $gatewayResponse['id'] ?? null;
            $gatewayStatus = $gatewayResponse['status'] ?? 'pending';

            if ($gatewayStatus === 'processed') {
                $isFullRefund = ($refundAmountPaise + $alreadyRefundedPaise) >= $capturedPaise;
                $newStatus = $isFullRefund ? 'refunded' : 'captured';

                $payment->update([
                    'status' => $newStatus,
                    'refund_id' => $refundId,
                    'refund_status' => 'processed',
                    'refund_amount' => $refundAmountRupees,
                    'refunded_at' => now(),
                    'refund_error' => null,
                    'idempotency_key' => $idempotencyKey,  // Store for future audits
                ]);

                PaymentLog::record(
                    $booking->id,
                    $payment->id,
                    'refund.processed',
                    'api',
                    [
                        'refund_id' => $refundId,
                        'amount_paise' => $refundAmountPaise,
                        'idempotency_key' => $idempotencyKey,
                        'reason' => $reason,
                    ]
                );

                return [
                    'success' => true,
                    'status' => 'processed',
                    'amount_paise' => $refundAmountPaise,
                    'amount_rupees' => $refundAmountRupees,
                    'refund_id' => $refundId,
                    'gateway_response' => $gatewayResponse,
                ];
            }

            // Status is pending (awaiting banking/clearing confirmation)
            $payment->update([
                'status' => 'refund_pending',
                'refund_id' => $refundId,
                'refund_status' => 'pending',
                'refund_amount' => $refundAmountRupees,
                'refund_error' => null,
                'idempotency_key' => $idempotencyKey,  // Store for future audits
            ]);

            PaymentLog::record(
                $booking->id,
                $payment->id,
                'refund.pending',
                'api',
                [
                    'refund_id' => $refundId,
                    'amount_paise' => $refundAmountPaise,
                    'idempotency_key' => $idempotencyKey,
                    'status' => 'pending',
                ]
            );

            return [
                'success' => true,
                'status' => 'pending',
                'amount_paise' => $refundAmountPaise,
                'amount_rupees' => $refundAmountRupees,
                'refund_id' => $refundId,
                'gateway_response' => $gatewayResponse,
            ];

        } catch (Exception $e) {
            Log::error('Razorpay refund API call failed: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
                'idempotency_key' => $idempotencyKey ?? 'not_generated',
            ]);

            $payment->update([
                'refund_status' => 'failed',
                'refund_error' => $e->getMessage(),
            ]);

            PaymentLog::record(
                $booking->id,
                $payment->id,
                'refund.failed',
                'api',
                [
                    'amount_paise' => $refundAmountPaise,
                    'idempotency_key' => $idempotencyKey ?? 'not_generated',
                    'error' => $e->getMessage(),
                ]
            );

            return [
                'success' => false,
                'status' => 'failed',
                'amount_paise' => $refundAmountPaise,
                'amount_rupees' => $refundAmountRupees,
                'refund_id' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Reconcile refund status with Razorpay for a payment.
     */
    public function reconcileRefund(Payment $payment): array
    {
        if (empty($payment->refund_id) || empty($payment->razorpay_payment_id)) {
            return [
                'success' => false,
                'message' => 'Payment has no active refund ID to reconcile.',
            ];
        }

        try {
            $refundData = $this->razorpayService->fetchRefund(
                $payment->razorpay_payment_id,
                $payment->refund_id
            );

            $status = $refundData['status'] ?? 'pending';

            if ($status === 'processed' && $payment->refund_status !== 'processed') {
                $payment->update([
                    'refund_status' => 'processed',
                    'refunded_at' => now(),
                ]);

                if ($payment->booking) {
                    $payment->booking->update([
                        'refund_status' => 'processed',
                    ]);
                }

                PaymentLog::record(
                    $payment->booking_id,
                    $payment->id,
                    'refund.reconciled',
                    'reconciliation',
                    ['refund_id' => $payment->refund_id, 'status' => 'processed']
                );
            }

            return [
                'success' => true,
                'status' => $status,
                'refund_data' => $refundData,
            ];
        } catch (Exception $e) {
            Log::error('Failed to reconcile refund with Razorpay: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'refund_id' => $payment->refund_id,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
