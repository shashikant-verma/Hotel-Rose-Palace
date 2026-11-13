<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\PaymentLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CancellationService
{
    protected CancellationPolicyService $policyService;
    protected RefundProcessingService $refundService;
    protected RoomAllocationService $allocationService;

    public function __construct(
        CancellationPolicyService $policyService,
        RefundProcessingService $refundService,
        RoomAllocationService $allocationService
    ) {
        $this->policyService = $policyService;
        $this->refundService = $refundService;
        $this->allocationService = $allocationService;
    }

    /**
     * Submit a customer cancellation request.
     * Enforces customer ownership, eligibility, and holds room allocation until manager approval.
     *
     * @param Booking $booking
     * @param string $customerMobile
     * @param string|null $reason
     * @return array
     * @throws Exception
     */
    public function requestCancellation(Booking $booking, string $customerMobile, ?string $reason = null): array
    {
        // 1. Enforce IDOR protection: Customer can only cancel their own booking
        if ($booking->customer_mobile !== $customerMobile) {
            throw new Exception('Unauthorized: Booking does not belong to the verified customer mobile number.');
        }

        // 2. Validate eligibility
        if (!$this->policyService->isEligibleForCancellation($booking)) {
            if ($booking->cancellation_status === 'pending' || $booking->booking_status === 'cancellation_requested') {
                throw new Exception('A cancellation request is already pending hotel manager review.');
            }
            if (!is_null($booking->cancelled_at) || $booking->booking_status === 'cancelled') {
                throw new Exception('This booking has already been cancelled.');
            }
            if ($booking->payment_status !== 'paid') {
                throw new Exception('Only paid bookings can be cancelled through the online refund system.');
            }
            throw new Exception('This booking is not eligible for cancellation.');
        }

        // 3. Calculate refund breakdown according to confirmed hotel policy
        $calculation = $this->policyService->calculateRefund($booking);

        // 4. Update booking within atomic database transaction with row-level locking
        return DB::transaction(function () use ($booking, $reason, $calculation) {
            $freshBooking = Booking::where('id', $booking->id)->lockForUpdate()->first();

            if (!$freshBooking || !$this->policyService->isEligibleForCancellation($freshBooking)) {
                throw new Exception('Booking state changed. Unable to submit cancellation request.');
            }

            $freshBooking->update([
                'cancellation_status' => 'pending',
                'booking_status' => 'cancellation_requested',
                'cancellation_reason' => $reason,
                'cancellation_requested_at' => now(),
                'eligible_refund_percentage' => $calculation['percentage'],
                'eligible_refund_amount' => $calculation['refund_amount'],
                'refund_status' => 'requested',
            ]);

            // NOTE: Physical room allocation is deliberately KEPT active (Option B) until manager approval.

            PaymentLog::record(
                $freshBooking->id,
                null,
                'cancellation.requested',
                'customer',
                [
                    'requested_by_mobile' => $freshBooking->customer_mobile,
                    'refund_percentage' => $calculation['percentage'],
                    'refund_amount' => $calculation['refund_amount'],
                    'reason' => $reason,
                ]
            );

            return [
                'success' => true,
                'booking' => $freshBooking,
                'calculation' => $calculation,
                'message' => 'Your cancellation request has been submitted and is awaiting hotel manager approval.',
            ];
        });
    }

    /**
     * Manager approves a pending cancellation request.
     * Enforces manager role, atomic room release, and Razorpay refund initiation.
     *
     * @param Booking $booking
     * @param User $adminUser
     * @param string|null $adminNotes
     * @return array
     * @throws Exception
     */
    public function approveCancellation(Booking $booking, User $adminUser, ?string $adminNotes = null): array
    {
        // 1. Authorization: Only admin or manager roles can approve
        if (!in_array($adminUser->role, ['admin', 'manager'])) {
            throw new Exception('Unauthorized: Only an authorized hotel manager or administrator can approve cancellations.');
        }

        return DB::transaction(function () use ($booking, $adminUser, $adminNotes) {
            $freshBooking = Booking::where('id', $booking->id)->lockForUpdate()->first();

            if (!$freshBooking) {
                throw new Exception('Booking record not found.');
            }

            // Prevent duplicate approvals
            if ($freshBooking->cancellation_status === 'approved' || !is_null($freshBooking->cancelled_at)) {
                throw new Exception('This cancellation request has already been approved.');
            }

            if ($freshBooking->cancellation_status !== 'pending' && $freshBooking->booking_status !== 'cancellation_requested') {
                throw new Exception('Booking does not have an active pending cancellation request.');
            }

            $percentage = (int) ($freshBooking->eligible_refund_percentage ?? 0);
            $amountPaise = (int) round(((float) ($freshBooking->eligible_refund_amount ?? 0)) * 100);

            $refundResult = null;

            // Tier A & B (100% or 50% refund): Initiate refund via RazorpayService
            if ($percentage > 0 && $amountPaise > 0) {
                $reasonText = 'Approved cancellation by manager #' . $adminUser->id . ($adminNotes ? ': ' . $adminNotes : '');
                $refundResult = $this->refundService->processRefund(
                    $freshBooking,
                    $amountPaise,
                    $reasonText
                );

                $refundStatus = $refundResult['status'] ?? 'failed';

                if ($refundStatus === 'processed') {
                    // Release physical room allocations
                    $this->allocationService->releaseCancelledBookingAllocations($freshBooking);

                    $paymentStatus = $percentage === 100 ? 'refunded' : 'partially_refunded';

                    $freshBooking->update([
                        'cancellation_status' => 'approved',
                        'booking_status' => 'cancelled',
                        'cancelled_at' => now(),
                        'cancellation_reviewed_at' => now(),
                        'cancellation_reviewed_by' => $adminUser->id,
                        'cancellation_admin_notes' => $adminNotes,
                        'refund_status' => 'processed',
                        'payment_status' => $paymentStatus,
                    ]);

                    PaymentLog::record(
                        $freshBooking->id,
                        null,
                        'cancellation.approved',
                        'admin',
                        [
                            'manager_id' => $adminUser->id,
                            'manager_name' => $adminUser->name,
                            'refund_id' => $refundResult['refund_id'] ?? null,
                            'refund_status' => 'processed',
                            'refund_amount' => $freshBooking->eligible_refund_amount,
                        ]
                    );

                    return [
                        'success' => true,
                        'status' => 'processed',
                        'booking' => $freshBooking,
                        'refund' => $refundResult,
                        'message' => 'Cancellation approved and refund of ₹' . number_format($freshBooking->eligible_refund_amount, 2) . ' processed successfully.',
                    ];
                }

                if ($refundStatus === 'pending') {
                    // Gateway accepted refund, but banking clearance is pending
                    $this->allocationService->releaseCancelledBookingAllocations($freshBooking);

                    $freshBooking->update([
                        'cancellation_status' => 'approved',
                        'booking_status' => 'cancelled',
                        'cancelled_at' => now(),
                        'cancellation_reviewed_at' => now(),
                        'cancellation_reviewed_by' => $adminUser->id,
                        'cancellation_admin_notes' => $adminNotes,
                        'refund_status' => 'pending',
                    ]);

                    PaymentLog::record(
                        $freshBooking->id,
                        null,
                        'cancellation.approved_refund_pending',
                        'admin',
                        [
                            'manager_id' => $adminUser->id,
                            'refund_id' => $refundResult['refund_id'] ?? null,
                            'refund_status' => 'pending',
                        ]
                    );

                    return [
                        'success' => true,
                        'status' => 'pending',
                        'booking' => $freshBooking,
                        'refund' => $refundResult,
                        'message' => 'Cancellation approved. Razorpay refund is pending banking confirmation.',
                    ];
                }

                // Gateway failed or timed out: Do NOT mark booking fully refunded or released
                $freshBooking->update([
                    'refund_status' => 'failed',
                    'cancellation_admin_notes' => trim(($adminNotes ? $adminNotes . ' | ' : '') . 'Gateway refund attempt failed. Needs retry.'),
                ]);

                return [
                    'success' => false,
                    'status' => 'failed',
                    'booking' => $freshBooking,
                    'refund' => $refundResult,
                    'message' => 'Refund dispatch failed: ' . ($refundResult['error'] ?? 'Gateway connection error') . '. Room allocation held for review.',
                ];
            }

            // Tier C (0% Non-refundable): No Razorpay refund call required
            $this->allocationService->releaseCancelledBookingAllocations($freshBooking);

            $freshBooking->update([
                'cancellation_status' => 'approved',
                'booking_status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reviewed_at' => now(),
                'cancellation_reviewed_by' => $adminUser->id,
                'cancellation_admin_notes' => $adminNotes,
                'refund_status' => 'not_applicable',
            ]);

            PaymentLog::record(
                $freshBooking->id,
                null,
                'cancellation.approved_non_refundable',
                'admin',
                [
                    'manager_id' => $adminUser->id,
                    'reason' => '0% Non-refundable policy tier',
                ]
            );

            return [
                'success' => true,
                'status' => 'not_applicable',
                'booking' => $freshBooking,
                'refund' => null,
                'message' => 'Cancellation approved without refund (0% non-refundable tier). Room released to inventory.',
            ];
        });
    }

    /**
     * Manager rejects a pending cancellation request.
     * Leaves room allocation intact and prevents refund.
     *
     * @param Booking $booking
     * @param User $adminUser
     * @param string $rejectionReason
     * @return array
     * @throws Exception
     */
    public function rejectCancellation(Booking $booking, User $adminUser, string $rejectionReason): array
    {
        if (!in_array($adminUser->role, ['admin', 'manager'])) {
            throw new Exception('Unauthorized: Only an authorized hotel manager or administrator can reject cancellations.');
        }

        if (empty(trim($rejectionReason))) {
            throw new Exception('A valid rejection reason must be provided by the hotel manager.');
        }

        return DB::transaction(function () use ($booking, $adminUser, $rejectionReason) {
            $freshBooking = Booking::where('id', $booking->id)->lockForUpdate()->first();

            if (!$freshBooking) {
                throw new Exception('Booking record not found.');
            }

            if ($freshBooking->cancellation_status !== 'pending' && $freshBooking->booking_status !== 'cancellation_requested') {
                throw new Exception('Booking does not have an active pending cancellation request to reject.');
            }

            $freshBooking->update([
                'cancellation_status' => 'rejected',
                'booking_status' => 'confirmed', // Returns to confirmed stay
                'cancellation_reviewed_at' => now(),
                'cancellation_reviewed_by' => $adminUser->id,
                'cancellation_rejection_reason' => $rejectionReason,
                'refund_status' => 'not_applicable',
            ]);

            // Allocation remains intact (Option B)

            PaymentLog::record(
                $freshBooking->id,
                null,
                'cancellation.rejected',
                'admin',
                [
                    'manager_id' => $adminUser->id,
                    'manager_name' => $adminUser->name,
                    'rejection_reason' => $rejectionReason,
                ]
            );

            return [
                'success' => true,
                'booking' => $freshBooking,
                'message' => 'Cancellation request has been rejected. The booking and room allocation remain confirmed.',
            ];
        });
    }
}
