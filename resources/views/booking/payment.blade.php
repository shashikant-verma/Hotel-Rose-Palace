@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Progress indicator -->
            <div class="mb-4">
                <div class="progress" style="height: 6px; background-color: #e9ecef; border-radius: 4px;">
                    <div class="progress-bar" style="width: 100%; background: linear-gradient(90deg, #800020, #b22222);" role="progressbar"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted"><i class="fas fa-lock text-success me-1"></i> 256-Bit SSL Encrypted Checkout</small>
                    <span class="badge bg-danger text-uppercase px-2 py-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">100% Online Payment</span>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-info-circle me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Hold Expiry Warning Box -->
            <div class="alert alert-light border border-warning shadow-sm d-flex align-items-center justify-content-between mb-4 p-3" style="border-radius: 10px;">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-circle bg-warning text-dark me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Temporary Room Hold Active</h6>
                        <small class="text-muted">Your room is reserved for complete payment within</small>
                    </div>
                </div>
                <div class="text-end">
                    <span id="reservation-timer" class="badge bg-dark fs-6 px-3 py-2 fw-bold" style="font-family: monospace; letter-spacing: 1px;">
                        {{ sprintf('%02d:00', $reservationMinutes) }}
                    </span>
                </div>
            </div>

            <!-- Payment Summary Card -->
            <div class="card shadow border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header py-3 px-4" style="background: #800020; color: #fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-credit-card me-2"></i> Hotel Rose Palace Checkout</h5>
                        <span class="badge bg-light text-dark fw-bold">Ref: {{ $booking->booking_reference }}</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <span class="text-muted small text-uppercase fw-semibold d-block">Room Category</span>
                            <span class="fs-6 fw-bold text-dark">{{ $booking->roomType?->name ?? 'Deluxe Room' }}</span>
                            <small class="text-muted d-block">{{ $booking->room_quantity }} Room(s) &bull; {{ $booking->total_guests }} Guest(s)</small>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <span class="text-muted small text-uppercase fw-semibold d-block">Stay Duration</span>
                            <span class="fs-6 fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }} &rarr; {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                            </span>
                            <small class="text-muted d-block">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date)) }} Night(s)
                            </small>
                        </div>
                    </div>

                    <div class="p-3 rounded mb-4" style="background-color: #fdf8f4; border: 1px dashed #d4af37;">
                        <h6 class="fw-bold mb-3 text-dark"><i class="fas fa-receipt text-warning me-2"></i> Bill Details</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Room Base Tariff</span>
                            <span class="fw-semibold">₹{{ number_format($booking->base_amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Taxes & GST (12%)</span>
                            <span class="fw-semibold">₹{{ number_format($booking->tax_amount, 2) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center pt-1">
                            <span class="fs-5 fw-bold text-dark">Total Amount Due</span>
                            <span class="fs-4 fw-bold" style="color: #800020;">₹{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-check-circle text-success me-1"></i> 100% full payment is required to confirm reservation. No partial or cash payments accepted.
                        </small>
                    </div>

                    <!-- Payment Action Section -->
                    <div class="text-center py-2">
                        <button type="button" id="pay-button" class="btn btn-lg w-100 py-3 text-white fw-bold shadow" style="background: linear-gradient(135deg, #800020, #a00028); border: none; border-radius: 8px; font-size: 1.15rem;">
                            <i class="fas fa-lock me-2"></i> Pay ₹{{ number_format($booking->total_amount, 2) }} with Razorpay
                        </button>
                        <p class="small text-muted mt-2 mb-0">
                            Supports UPI (Google Pay, PhonePe, Paytm), Credit/Debit Cards, Net Banking & Wallets
                        </p>
                    </div>
                </div>

                <div class="card-footer bg-light py-3 px-4 border-top">
                    <div class="d-flex flex-wrap justify-content-between align-items-center text-muted small">
                        <span><i class="fas fa-shield-alt text-primary me-1"></i> Secured by Razorpay Payment Gateway</span>
                        <span><i class="fas fa-sync-alt me-1"></i> Instant Automated Confirmation</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden verification form submitted on Razorpay success -->
<form id="razorpay-form" method="POST" action="{{ route('booking.payment.verify', ['booking' => $booking->id]) }}" style="display: none;">
    @csrf
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
</form>

<!-- Hidden failure form submitted on modal close or failure -->
<form id="razorpay-failed-form" method="POST" action="{{ route('booking.payment.failed', ['booking' => $booking->id]) }}" style="display: none;">
    @csrf
    <input type="hidden" name="error_code" id="fail_error_code">
    <input type="hidden" name="error_description" id="fail_error_description">
</form>

<!-- Razorpay Checkout SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var checkoutData = @json($checkoutData);

    var options = {
        "key": checkoutData.key,
        "amount": checkoutData.amount,
        "currency": checkoutData.currency,
        "name": checkoutData.name,
        "description": checkoutData.description,
        "order_id": checkoutData.order_id,
        "prefill": checkoutData.prefill || {},
        "notes": checkoutData.notes || {},
        "theme": checkoutData.theme || { "color": "#800020" },
        "modal": {
            "ondismiss": function() {
                console.log('Razorpay modal dismissed by user');
            }
        },
        "handler": function (response) {
            // Fill hidden form with cryptographic signature and payment details
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;

            // Show processing status
            var payBtn = document.getElementById('pay-button');
            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Verifying Payment Signature...';

            // Submit for strict server-side HMAC-SHA256 signature verification
            document.getElementById('razorpay-form').submit();
        }
    };

    var rzp = new Razorpay(options);

    rzp.on('payment.failed', function (response) {
        console.warn('Payment failed:', response.error);
        document.getElementById('fail_error_code').value = response.error.code || 'PAYMENT_FAILED';
        document.getElementById('fail_error_description').value = response.error.description || 'Payment transaction failed';
        document.getElementById('razorpay-failed-form').submit();
    });

    document.getElementById('pay-button').onclick = function(e) {
        e.preventDefault();
        rzp.open();
    };

    // Auto-open Razorpay checkout modal on page load for seamless experience
    setTimeout(function() {
        if (typeof rzp !== 'undefined') {
            rzp.open();
        }
    }, 600);

    // Reservation Countdown Timer
    var totalSeconds = {{ (int) $reservationMinutes * 60 }};
    var timerDisplay = document.getElementById('reservation-timer');

    var countdownInterval = setInterval(function() {
        totalSeconds--;
        if (totalSeconds <= 0) {
            clearInterval(countdownInterval);
            timerDisplay.textContent = "00:00 (Expired)";
            timerDisplay.className = "badge bg-danger fs-6 px-3 py-2 fw-bold";
            alert("Your temporary reservation hold has expired. Please check current room availability before proceeding.");
        } else {
            var minutes = Math.floor(totalSeconds / 60);
            var seconds = totalSeconds % 60;
            timerDisplay.textContent = 
                (minutes < 10 ? "0" + minutes : minutes) + ":" + 
                (seconds < 10 ? "0" + seconds : seconds);
        }
    }, 1000);
});
</script>
@endsection
