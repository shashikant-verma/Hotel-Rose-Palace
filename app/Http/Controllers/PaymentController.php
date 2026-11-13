<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Services\PaymentProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentController extends Controller
{
    protected PaymentProcessingService $paymentService;

    public function __construct(PaymentProcessingService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Show Razorpay Checkout payment page
     */
    public function checkout(Booking $booking)
    {
        // 1. Ownership / Session Check (Anti-IDOR)
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile || $booking->customer_mobile !== $verifiedMobile) {
            abort(403, 'Unauthorized access to booking.');
        }

        // 2. If already paid, redirect to booking confirmation status
        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.status', ['booking' => $booking->id])
                ->with('info', 'This booking has already been paid and confirmed.');
        }

        // 3. If booking cancelled, do not accept payment
        if ($booking->booking_status === 'cancelled') {
            return redirect()->route('booking.status', ['booking' => $booking->id])
                ->with('error', 'This booking has been cancelled and cannot be paid.');
        }

        try {
            // 4. Initiate or reuse Razorpay Order
            $checkoutData = $this->paymentService->initiateOrder($booking);

            $reservationDurationMinutes = (int) config('razorpay.reservation_duration_minutes', 15);

            return view('booking.payment', [
                'booking' => $booking->load('roomType', 'allocations'),
                'checkoutData' => $checkoutData,
                'reservationMinutes' => $reservationDurationMinutes,
            ]);
        } catch (Exception $e) {
            Log::error('Payment initiation error', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('booking.review', ['booking' => $booking->id])
                ->with('error', 'Unable to initiate payment: ' . $e->getMessage());
        }
    }

    /**
     * Verify payment signature and finalize booking confirmation
     */
    public function verify(Request $request, Booking $booking)
    {
        // 1. Ownership / Session Check (Anti-IDOR)
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile || $booking->customer_mobile !== $verifiedMobile) {
            abort(403, 'Unauthorized access to booking.');
        }

        // 2. Validate input parameters from Razorpay Checkout modal
        $validated = $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        try {
            // 3. Cryptographic verification & room confirmation/refund logic
            $result = $this->paymentService->verifyAndConfirm($booking, $validated);

            if ($result['success']) {
                return redirect()->route('booking.status', ['booking' => $booking->id])
                    ->with('success', $result['message']);
            }

            // In case of hold expiry + room unavailable auto-refund
            return redirect()->route('booking.status', ['booking' => $booking->id])
                ->with('error', $result['message']);

        } catch (Exception $e) {
            Log::error('Payment verification failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'data' => $validated,
            ]);

            return redirect()->route('booking.payment', ['booking' => $booking->id])
                ->with('error', 'Payment verification failed: ' . $e->getMessage() . '. Please contact support if your account was debited.');
        }
    }

    /**
     * Handle payment failure or user dismissal from checkout modal
     */
    public function failed(Request $request, Booking $booking)
    {
        $verifiedMobile = session('verified_mobile');
        if (!$verifiedMobile || $booking->customer_mobile !== $verifiedMobile) {
            abort(403, 'Unauthorized access to booking.');
        }

        $errorReason = $request->input('error_description', 'Customer dismissed or cancelled payment');
        $errorCode = $request->input('error_code', 'PAYMENT_CANCELLED');

        PaymentLog::record(
            $booking->id,
            null,
            'payment.cancelled_by_user',
            'info',
            'Customer exited payment checkout or payment failed: ' . $errorReason,
            ['error_code' => $errorCode]
        );

        return redirect()->route('booking.payment', ['booking' => $booking->id])
            ->with('warning', 'Payment was not completed. You can retry paying within the hold duration.');
    }
}
