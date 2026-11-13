<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerBookingController extends Controller
{
    /**
     * Display a listing of bookings for the verified customer.
     */
    public function index(Request $request): View
    {
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile) {
            abort(403, 'Unauthorized. Please verify your mobile number.');
        }

        $tab = $request->query('tab', 'all');
        $today = Carbon::today();

        // Base query strictly scoped to authenticated mobile
        $baseQuery = Booking::where('customer_mobile', $verifiedMobile);

        // Precompute counts for tab badges
        $counts = [
            'all' => (clone $baseQuery)->count(),
            'upcoming' => (clone $baseQuery)
                ->where('check_in_date', '>=', $today)
                ->where('booking_status', '!=', 'cancelled')
                ->where('payment_status', 'paid')
                ->count(),
            'completed' => (clone $baseQuery)
                ->where('check_out_date', '<', $today)
                ->where('booking_status', '!=', 'cancelled')
                ->where('payment_status', 'paid')
                ->count(),
            'pending' => (clone $baseQuery)
                ->where('payment_status', 'pending')
                ->where('booking_status', '!=', 'cancelled')
                ->count(),
            'failed' => (clone $baseQuery)
                ->whereHas('payments', function ($q) {
                    $q->where('status', 'failed');
                })
                ->where('payment_status', '!=', 'paid')
                ->count(),
            'cancelled' => (clone $baseQuery)
                ->where(function ($q) {
                    $q->where('booking_status', 'cancelled')
                      ->orWhereNotNull('cancelled_at');
                })
                ->count(),
        ];

        // Filter query based on active tab
        $query = (clone $baseQuery)->with(['roomType', 'allocations.room', 'latestPayment']);

        switch ($tab) {
            case 'upcoming':
                $query->where('check_in_date', '>=', $today)
                      ->where('booking_status', '!=', 'cancelled')
                      ->where('payment_status', 'paid')
                      ->orderBy('check_in_date', 'asc');
                break;

            case 'completed':
                $query->where('check_out_date', '<', $today)
                      ->where('booking_status', '!=', 'cancelled')
                      ->where('payment_status', 'paid')
                      ->orderBy('check_out_date', 'desc');
                break;

            case 'pending':
                $query->where('payment_status', 'pending')
                      ->where('booking_status', '!=', 'cancelled')
                      ->latest();
                break;

            case 'failed':
                $query->whereHas('payments', function ($q) {
                    $q->where('status', 'failed');
                })
                ->where('payment_status', '!=', 'paid')
                ->latest();
                break;

            case 'cancelled':
                $query->where(function ($q) {
                    $q->where('booking_status', 'cancelled')
                      ->orWhereNotNull('cancelled_at');
                })
                ->latest();
                break;

            case 'all':
            default:
                $query->latest('id');
                break;
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('customer.bookings.index', [
            'bookings' => $bookings,
            'currentTab' => $tab,
            'counts' => $counts,
            'customerMobile' => $verifiedMobile,
        ]);
    }

    /**
     * Display detailed information for a single booking.
     */
    public function show(Booking $booking): View
    {
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile || $booking->customer_mobile !== $verifiedMobile) {
            abort(403, 'Unauthorized access to booking.');
        }

        $booking->load([
            'roomType',
            'allocations.room',
            'payments' => function ($q) {
                $q->latest();
            },
        ]);

        $latestPayment = $booking->payments->first();

        return view('customer.bookings.show', [
            'booking' => $booking,
            'latestPayment' => $latestPayment,
        ]);
    }

    /**
     * Display the official booking confirmation receipt for a paid booking.
     */
    public function confirmation(Booking $booking)
    {
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile || $booking->customer_mobile !== $verifiedMobile) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Unpaid bookings cannot view confirmed receipt
        if ($booking->payment_status !== 'paid') {
            return redirect()->route('customer.bookings.show', ['booking' => $booking->id])
                ->with('warning', 'Payment has not been completed for this booking. Confirmation is only available for paid bookings.');
        }

        $booking->load([
            'roomType',
            'allocations.room',
            'successfulPayment',
        ]);

        $payment = $booking->successfulPayment ?? $booking->payments()->where('status', 'captured')->latest()->first();

        return view('customer.bookings.confirmation', [
            'booking' => $booking,
            'payment' => $payment,
        ]);
    }

    /**
     * Show cancellation preview and confirmation form.
     */
    public function showCancelForm(Booking $booking, \App\Services\CancellationPolicyService $policyService)
    {
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile || $booking->customer_mobile !== $verifiedMobile) {
            abort(403, 'Unauthorized access to booking.');
        }

        if (!$policyService->isEligibleForCancellation($booking)) {
            if ($booking->cancellation_status === 'pending' || $booking->booking_status === 'cancellation_requested') {
                return redirect()->route('customer.bookings.show', $booking)
                    ->with('info', 'A cancellation request is already pending hotel manager review.');
            }
            if ($booking->isCancelled()) {
                return redirect()->route('customer.bookings.show', $booking)
                    ->with('warning', 'This booking has already been cancelled.');
            }
            return redirect()->route('customer.bookings.show', $booking)
                ->with('warning', 'This booking is not eligible for cancellation.');
        }

        $calculation = $policyService->calculateRefund($booking);

        return view('customer.bookings.cancel', [
            'booking' => $booking,
            'calculation' => $calculation,
        ]);
    }

    /**
     * Submit customer cancellation request.
     */
    public function submitCancellation(
        Request $request,
        Booking $booking,
        \App\Services\CancellationService $cancellationService
    ) {
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile || $booking->customer_mobile !== $verifiedMobile) {
            abort(403, 'Unauthorized access to booking.');
        }

        $request->validate([
            'reason' => 'nullable|string|max:500',
            'confirm_cancellation' => 'required',
        ], [
            'confirm_cancellation.required' => 'Please confirm that you wish to request cancellation of this booking.',
        ]);

        try {
            $result = $cancellationService->requestCancellation(
                $booking,
                $verifiedMobile,
                $request->input('reason')
            );

            return redirect()->route('customer.bookings.show', $booking)
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            return redirect()->route('customer.bookings.show', $booking)
                ->with('error', $e->getMessage());
        }
    }
}
