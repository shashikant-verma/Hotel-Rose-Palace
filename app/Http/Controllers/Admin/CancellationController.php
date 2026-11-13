<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\CancellationPolicyService;
use App\Services\CancellationService;
use App\Services\RefundProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Exception;

class CancellationController extends Controller
{
    protected CancellationPolicyService $policyService;
    protected CancellationService $cancellationService;
    protected RefundProcessingService $refundService;

    public function __construct(
        CancellationPolicyService $policyService,
        CancellationService $cancellationService,
        RefundProcessingService $refundService
    ) {
        $this->policyService = $policyService;
        $this->cancellationService = $cancellationService;
        $this->refundService = $refundService;
    }

    /**
     * Display a listing of cancellation and refund requests.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        $baseQuery = Booking::query()
            ->where(function ($q) {
                $q->where('cancellation_status', '!=', 'none')
                  ->orWhere('booking_status', 'cancellation_requested')
                  ->orWhereNotNull('cancelled_at');
            });

        $counts = [
            'pending' => Booking::query()
                ->where(function ($q) {
                    $q->where('cancellation_status', 'pending')
                      ->orWhere('booking_status', 'cancellation_requested');
                })
                ->whereNull('cancelled_at')
                ->count(),
            'approved' => Booking::query()
                ->where(function ($q) {
                    $q->where('cancellation_status', 'approved')
                      ->orWhere('booking_status', 'cancelled');
                })
                ->whereNotNull('cancelled_at')
                ->count(),
            'rejected' => Booking::query()
                ->where('cancellation_status', 'rejected')
                ->count(),
            'all' => (clone $baseQuery)->count(),
        ];

        $query = (clone $baseQuery)->with(['roomType', 'allocations.room', 'cancellationReviewer', 'successfulPayment']);

        switch ($status) {
            case 'pending':
                $query->where(function ($q) {
                    $q->where('cancellation_status', 'pending')
                      ->orWhere('booking_status', 'cancellation_requested');
                })->whereNull('cancelled_at')->latest('cancellation_requested_at');
                break;

            case 'approved':
                $query->where(function ($q) {
                    $q->where('cancellation_status', 'approved')
                      ->orWhere('booking_status', 'cancelled');
                })->whereNotNull('cancelled_at')->latest('cancellation_reviewed_at');
                break;

            case 'rejected':
                $query->where('cancellation_status', 'rejected')->latest('cancellation_reviewed_at');
                break;

            case 'all':
            default:
                $query->latest('updated_at');
                break;
        }

        $cancellations = $query->paginate(15)->withQueryString();

        return view('admin.cancellations.index', [
            'cancellations' => $cancellations,
            'currentStatus' => $status,
            'counts' => $counts,
        ]);
    }

    /**
     * Display detailed review page for a cancellation request.
     */
    public function show(Booking $booking): View
    {
        $booking->load([
            'roomType',
            'allocations.room',
            'payments' => function ($q) {
                $q->latest();
            },
            'cancellationReviewer',
            'successfulPayment',
        ]);

        $calculation = $this->policyService->calculateRefund(
            $booking,
            $booking->cancellation_requested_at ?? now()
        );

        $payment = $booking->successfulPayment ?? $booking->payments->first();

        return view('admin.cancellations.show', [
            'booking' => $booking,
            'calculation' => $calculation,
            'payment' => $payment,
        ]);
    }

    /**
     * Approve a cancellation request and dispatch refund.
     */
    public function approve(Request $request, Booking $booking)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        try {
            $result = $this->cancellationService->approveCancellation(
                $booking,
                $user,
                $request->input('admin_notes')
            );

            return redirect()->route('admin.cancellations.show', $booking)
                ->with('success', $result['message']);
        } catch (Exception $e) {
            return redirect()->route('admin.cancellations.show', $booking)
                ->with('error', 'Error approving cancellation: ' . $e->getMessage());
        }
    }

    /**
     * Reject a cancellation request with mandatory reason.
     */
    public function reject(Request $request, Booking $booking)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|min:5|max:1000',
        ], [
            'rejection_reason.required' => 'Please provide a reason for declining the cancellation request.',
        ]);

        try {
            $result = $this->cancellationService->rejectCancellation(
                $booking,
                $user,
                $request->input('rejection_reason')
            );

            return redirect()->route('admin.cancellations.show', $booking)
                ->with('success', $result['message']);
        } catch (Exception $e) {
            return redirect()->route('admin.cancellations.show', $booking)
                ->with('error', 'Error rejecting cancellation: ' . $e->getMessage());
        }
    }

    /**
     * Retry a failed refund for an approved cancellation.
     * 
     * Implements safe concurrency control:
     * - STEP 1: Acquire lock, verify state, generate retry token
     * - STEP 2: Release lock, make external Razorpay calls
     * - STEP 3: Verify retry token, acquire lock, persist results
     */
    public function retryRefund(Booking $booking)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        // STEP 1: Short transaction - acquire lock, verify state, generate retry token
        $retryState = \Illuminate\Support\Facades\DB::transaction(function () use ($booking, $user) {
            $freshBooking = Booking::where('id', $booking->id)->lockForUpdate()->first();

            if (!$freshBooking) {
                return ['success' => false, 'error' => 'Booking record not found.'];
            }

            if ($freshBooking->refund_status === 'processed') {
                return ['success' => false, 'info' => 'Refund has already been processed.'];
            }

            $amountPaise = (int) round(((float) ($freshBooking->eligible_refund_amount ?? 0)) * 100);
            if ($amountPaise <= 0) {
                return ['success' => false, 'info' => 'No refund amount is due for this booking.'];
            }

            // Generate unique retry token to prevent stale requests
            $retryToken = bin2hex(random_bytes(16));

            // Mark as processing with retry token (prevents concurrent retries)
            $freshBooking->update([
                'refund_status' => 'processing',
                'refund_retry_token' => $retryToken,
            ]);

            return [
                'success' => true,
                'booking_id' => $freshBooking->id,
                'retry_token' => $retryToken,
                'amount_paise' => $amountPaise,
                'eligible_refund_percentage' => $freshBooking->eligible_refund_percentage,
            ];
        });

        if (!$retryState['success']) {
            $errorMsg = $retryState['error'] ?? $retryState['info'] ?? 'Unknown error';
            return redirect()->route('admin.cancellations.show', $booking)
                ->with($retryState['info'] ? 'info' : 'error', $errorMsg);
        }

        // STEP 2: External Razorpay calls WITHOUT database lock (lock released above)
        try {
            $result = $this->refundService->processRefund(
                Booking::find($retryState['booking_id']),
                $retryState['amount_paise'],
                "Retry refund initiated by manager #{$user->id} ({$user->name})"
            );
        } catch (Exception $e) {
            // Gateway call failed - rollback processing state
            \Illuminate\Support\Facades\DB::transaction(function () use ($retryState) {
                $booking = Booking::where('id', $retryState['booking_id'])->lockForUpdate()->first();
                if ($booking && $booking->refund_retry_token === $retryState['retry_token']) {
                    $booking->update(['refund_status' => 'failed', 'refund_retry_token' => null]);
                }
            });

            $freshBooking = Booking::find($retryState['booking_id']);
            return redirect()->route('admin.cancellations.show', $freshBooking)
                ->with('error', 'Refund retry failed: ' . $e->getMessage());
        }

        // STEP 3: Short transaction - verify retry token, acquire lock, persist results
        return \Illuminate\Support\Facades\DB::transaction(function () use ($retryState, $result, $user) {
            $freshBooking = Booking::where('id', $retryState['booking_id'])->lockForUpdate()->first();

            // Verify this is still our retry (prevents stale requests from overwriting newer results)
            if (!$freshBooking || $freshBooking->refund_retry_token !== $retryState['retry_token']) {
                return redirect()->route('admin.cancellations.show', $freshBooking ?? $booking)
                    ->with('warning', 'Refund retry was superseded by another request. Please check current status.');
            }

            if ($result['status'] === 'processed') {
                // Release physical room allocations
                app(\App\Services\RoomAllocationService::class)->releaseCancelledBookingAllocations($freshBooking);

                $paymentStatus = $retryState['eligible_refund_percentage'] === 100 ? 'refunded' : 'partially_refunded';

                $freshBooking->update([
                    'cancellation_status' => 'approved',
                    'booking_status' => 'cancelled',
                    'cancelled_at' => $freshBooking->cancelled_at ?? now(),
                    'cancellation_reviewed_at' => $freshBooking->cancellation_reviewed_at ?? now(),
                    'cancellation_reviewed_by' => $user->id,
                    'refund_status' => 'processed',
                    'payment_status' => $paymentStatus,
                    'refund_retry_token' => null,
                ]);

                return redirect()->route('admin.cancellations.show', $freshBooking)
                    ->with('success', 'Refund verified and processed successfully via Razorpay.');
            }

            if ($result['status'] === 'pending') {
                app(\App\Services\RoomAllocationService::class)->releaseCancelledBookingAllocations($freshBooking);

                $freshBooking->update([
                    'cancellation_status' => 'approved',
                    'booking_status' => 'cancelled',
                    'cancelled_at' => $freshBooking->cancelled_at ?? now(),
                    'cancellation_reviewed_at' => $freshBooking->cancellation_reviewed_at ?? now(),
                    'cancellation_reviewed_by' => $user->id,
                    'refund_status' => 'pending',
                    'refund_retry_token' => null,
                ]);

                return redirect()->route('admin.cancellations.show', $freshBooking)
                    ->with('warning', 'Refund is currently pending banking clearance on Razorpay.');
            }

            // Refund attempt failed - keep processing state cleared
            $freshBooking->update([
                'refund_status' => 'failed',
                'refund_retry_token' => null,
            ]);

            return redirect()->route('admin.cancellations.show', $freshBooking)
                ->with('error', 'Refund attempt failed: ' . ($result['error'] ?? 'Unknown error'));
        });
    }
}
