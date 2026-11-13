@extends('layouts.app')

@section('title', 'Request Cancellation #' . $booking->booking_reference . ' — Hotel Rose Palace')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                    <i class="fas fa-arrow-left me-1"></i> Back to Booking Details
                </a>
                <span class="text-muted small">
                    Verified session: <strong class="text-dark">{{ session('verified_mobile') }}</strong>
                </span>
            </div>

            <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header py-3 px-4 text-white" style="background: #800020;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-undo-alt me-2"></i> Request Booking Cancellation</h5>
                    <small style="opacity: 0.9;">Booking Ref: {{ $booking->booking_reference }} | {{ $booking->roomType->name ?? 'Room' }}</small>
                </div>

                <div class="card-body p-4">
                    {{-- Policy & Calculation Summary Box --}}
                    <div class="p-3 mb-4 rounded border bg-light">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-info-circle text-primary me-2"></i> Hotel Rose Palace Cancellation & Refund Policy</h6>
                        
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <span class="text-muted small d-block">Scheduled Check-in:</span>
                                <strong class="text-dark">{{ $calculation['check_in_datetime']->format('d M Y, h:i A') }} IST</strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted small d-block">Cancellation Request Time:</span>
                                <strong class="text-dark">{{ $calculation['cancellation_time']->format('d M Y, h:i A') }} IST</strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted small d-block">Hours Before Check-in:</span>
                                <span class="badge bg-secondary">{{ $calculation['hours_until_check_in'] }} hours</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted small d-block">Policy Determination:</span>
                                <span class="badge {{ $calculation['percentage'] === 100 ? 'bg-success' : ($calculation['percentage'] === 50 ? 'bg-warning text-dark' : 'bg-danger') }} fs-6">
                                    {{ $calculation['percentage'] }}% Refund
                                </span>
                            </div>
                        </div>

                        <hr class="my-3">

                        <p class="small text-muted mb-0">
                            <strong>Policy Rule:</strong> {{ $calculation['policy_description'] }}
                        </p>
                    </div>

                    {{-- Financial Breakdown --}}
                    <div class="card border-0 bg-light-subtle p-3 mb-4 rounded" style="background: #fdfbf7; border: 1px dashed #d4af37 !important;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Gross Amount Paid (incl. GST):</span>
                            <span class="fw-semibold">₹{{ number_format($calculation['gross_amount'], 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Cancellation Fee Retained:</span>
                            <span class="text-danger fw-semibold">- ₹{{ number_format($calculation['cancellation_fee'], 2) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark fs-6">Estimated Refundable Amount:</span>
                            <span class="fw-bold fs-5 text-success">₹{{ number_format($calculation['refund_amount'], 2) }}</span>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            * Refunds are processed strictly to the original Razorpay payment method within 5–7 business days following hotel manager approval.
                        </small>
                    </div>

                    {{-- Notice on Manager Approval --}}
                    <div class="alert alert-warning small mb-4">
                        <i class="fas fa-user-shield me-2"></i>
                        <strong>Manager Approval Required:</strong> Per Hotel Rose Palace business policy, all cancellation requests are subject to review by the hotel manager. Room allocation remains reserved until approval is granted.
                    </div>

                    {{-- Cancellation Submission Form --}}
                    <form action="{{ route('customer.bookings.cancel.submit', $booking) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="reason" class="form-label fw-semibold text-dark">Reason for Cancellation (Optional)</label>
                            <textarea name="reason" id="reason" rows="3" class="form-control" placeholder="Please let us know why you are cancelling your stay..."></textarea>
                            @error('reason')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="confirm_cancellation" id="confirm_cancellation" value="1" required>
                            <label class="form-check-label text-dark" for="confirm_cancellation">
                                I understand and accept the Hotel Rose Palace cancellation policy and confirm my request to cancel booking <strong>#{{ $booking->booking_reference }}</strong>.
                            </label>
                            @error('confirm_cancellation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-outline-secondary">
                                Keep My Reservation
                            </a>
                            <button type="submit" class="btn btn-danger px-4 fw-bold">
                                <i class="fas fa-paper-plane me-1"></i> Submit Cancellation Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
