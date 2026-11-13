@extends('admin.layouts.app')

@section('title', 'Review Cancellation #' . $booking->booking_reference)
@section('page-title', 'Cancellation Review — #' . $booking->booking_reference)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.cancellations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to All Requests
    </a>
    <div>
        @if ($booking->isCancellationPending())
            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                <i class="fas fa-clock me-1"></i> Awaiting Manager Approval
            </span>
        @elseif ($booking->isCancellationApproved())
            <span class="badge bg-success fs-6 px-3 py-2">
                <i class="fas fa-check-circle me-1"></i> Cancellation Approved
            </span>
        @elseif ($booking->isCancellationRejected())
            <span class="badge bg-secondary fs-6 px-3 py-2">
                <i class="fas fa-ban me-1"></i> Request Rejected
            </span>
        @endif
    </div>
</div>

{{-- Flash Messages --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    {{-- Left: Details & Calculation --}}
    <div class="col-lg-8">
        {{-- Policy Calculation Breakdown Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: #fff;">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-calculator me-2"></i> Hotel Policy & Refund Breakdown
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Scheduled Check-in:</span>
                        <strong class="text-dark">{{ $calculation['check_in_datetime']->format('d M Y, h:i A') }} IST</strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Cancellation Requested At:</span>
                        <strong class="text-dark">{{ $calculation['cancellation_time']->format('d M Y, h:i A') }} IST</strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Time Window Before Check-in:</span>
                        <span class="badge bg-secondary fs-6">{{ $calculation['hours_until_check_in'] }} hours</span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block">Approved Hotel Policy Tier:</span>
                        <span class="badge {{ $calculation['percentage'] === 100 ? 'bg-success' : ($calculation['percentage'] === 50 ? 'bg-warning text-dark' : 'bg-danger') }} fs-6">
                            {{ $calculation['percentage'] }}% Refund
                        </span>
                    </div>
                </div>

                <div class="p-3 rounded mb-3" style="background: #fcf9f5; border: 1px dashed var(--color-border-subtle);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Gross Amount Paid (incl. GST):</span>
                        <strong class="text-dark">₹{{ number_format($calculation['gross_amount'], 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Hotel Cancellation Fee Retained:</span>
                        <strong class="text-danger">- ₹{{ number_format($calculation['cancellation_fee'], 2) }}</strong>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-6">Eligible Razorpay Refund Amount:</span>
                        <span class="fw-bold fs-5 text-success">₹{{ number_format($calculation['refund_amount'], 2) }}</span>
                    </div>
                </div>

                <p class="small text-muted mb-0">
                    <i class="fas fa-info-circle me-1 text-primary"></i> <strong>Policy Rule:</strong> {{ $calculation['policy_description'] }}
                </p>
            </div>
        </div>

        {{-- Booking & Guest Details Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: #fff;">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-bed me-2"></i> Reservation & Room Allocation
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Customer Name:</span>
                        <strong class="text-dark">{{ $booking->customer_name }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Mobile Number:</span>
                        <strong class="text-dark">{{ $booking->customer_mobile }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Room Category:</span>
                        <span class="fw-semibold text-dark">{{ $booking->roomType->name ?? 'Room' }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Quantity &amp; Guests:</span>
                        <span class="text-dark">{{ $booking->room_quantity }} Room(s) &bull; {{ $booking->num_adults }} Adult(s)</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Allocated Physical Rooms:</span>
                        @if ($booking->allocations->isNotEmpty())
                            @foreach ($booking->allocations as $alloc)
                                <span class="badge {{ $alloc->allocation_status === 'released' ? 'bg-secondary' : 'bg-primary' }} me-1">
                                    Room {{ $alloc->room->room_number ?? 'N/A' }}
                                    @if ($alloc->allocation_status === 'released') (Released) @endif
                                </span>
                            @endforeach
                            @if (!$booking->isCancelled())
                                <small class="text-muted d-block mt-1"><i class="fas fa-lock me-1"></i> Allocation locked until manager decision</small>
                            @endif
                        @else
                            <span class="text-muted">None allocated</span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Customer Stated Reason:</span>
                        <span class="text-dark">{{ $booking->cancellation_reason ?: 'None provided' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Details Card --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: #fff;">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-credit-card me-2"></i> Payment Gateway Information
                </h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted ps-0" style="width: 180px;">Razorpay Order ID:</td>
                        <td class="font-monospace fw-semibold">{{ $booking->razorpay_order_id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Razorpay Payment ID:</td>
                        <td class="font-monospace fw-semibold text-dark">{{ $booking->razorpay_payment_id ?? ($payment?->razorpay_payment_id ?? 'N/A') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-0">Original Payment Status:</td>
                        <td><span class="badge bg-success">Captured</span></td>
                    </tr>
                    @if ($payment?->refund_id)
                        <tr>
                            <td class="text-muted ps-0">Razorpay Refund ID:</td>
                            <td class="font-monospace text-success fw-bold">{{ $payment->refund_id }}</td>
                        </tr>
                    @endif
                    @if ($payment?->refund_status)
                        <tr>
                            <td class="text-muted ps-0">Gateway Refund Status:</td>
                            <td><span class="badge bg-info text-dark text-uppercase">{{ $payment->refund_status }}</span></td>
                        </tr>
                    @endif
                    @if ($payment?->refund_error)
                        <tr>
                            <td class="text-muted ps-0">Last Gateway Error:</td>
                            <td class="text-danger small">{{ $payment->refund_error }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- Right: Actions & Decision Card --}}
    <div class="col-lg-4">
        @if ($booking->isCancellationPending())
            {{-- Manager Decision Actions --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: #fff;">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-user-check me-2 text-primary"></i> Manager Decision
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info small mb-3">
                        <i class="fas fa-shield-alt me-1"></i> <strong>Audit Notice:</strong> Your admin user ID (<strong>#{{ Auth::id() }}</strong> - {{ Auth::user()->name }}) and current timestamp will be permanently recorded upon decision.
                    </div>

                    {{-- Approve Form --}}
                    <form action="{{ route('admin.cancellations.approve', $booking) }}" method="POST" class="mb-4" onsubmit="return confirm('Confirm approval: This will release allocated rooms and dispatch a refund of ₹{{ number_format($calculation['refund_amount'], 2) }} via Razorpay. Continue?');">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_notes" class="form-label small fw-semibold text-muted">Approval Notes (Optional)</label>
                            <textarea name="admin_notes" id="admin_notes" rows="2" class="form-control form-control-sm" placeholder="e.g., Guest called, genuine emergency confirmed."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                            <i class="fas fa-check me-1"></i> Approve &amp; Issue Refund (₹{{ number_format($calculation['refund_amount'], 2) }})
                        </button>
                    </form>

                    <hr class="my-4">

                    {{-- Reject Form --}}
                    <form action="{{ route('admin.cancellations.reject', $booking) }}" method="POST" onsubmit="return confirm('Confirm rejection: The booking will remain confirmed and room allocation will stay active. Continue?');">
                        @csrf
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label small fw-semibold text-danger">Rejection Reason (Required)</label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3" class="form-control form-control-sm" placeholder="Provide reason for declining cancellation request..." required></textarea>
                            @error('rejection_reason')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-outline-danger w-100 fw-bold py-2">
                            <i class="fas fa-ban me-1"></i> Reject Cancellation Request
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- Decision Record Display --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: #fff;">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-history me-2"></i> Decision Audit Log
                    </h6>
                </div>
                <div class="card-body p-4">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted ps-0" style="width: 130px;">Reviewed By:</td>
                            <td class="fw-semibold text-dark">{{ $booking->cancellationReviewer->name ?? 'Administrator' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Decision Date:</td>
                            <td class="text-dark">{{ $booking->cancellation_reviewed_at?->format('d M Y, h:i A') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Final Decision:</td>
                            <td>
                                @if ($booking->isCancellationApproved())
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($booking->isCancellationRejected())
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                        </tr>
                        @if ($booking->cancellation_admin_notes)
                            <tr>
                                <td class="text-muted ps-0">Admin Notes:</td>
                                <td class="small text-dark">{{ $booking->cancellation_admin_notes }}</td>
                            </tr>
                        @endif
                        @if ($booking->cancellation_rejection_reason)
                            <tr>
                                <td class="text-muted ps-0">Rejection Reason:</td>
                                <td class="small text-danger">{{ $booking->cancellation_rejection_reason }}</td>
                            </tr>
                        @endif
                    </table>

                    @if ($booking->refund_status === 'failed')
                        <hr class="my-3">
                        <form action="{{ route('admin.cancellations.retry', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 fw-bold">
                                <i class="fas fa-redo me-1"></i> Retry Razorpay Refund
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
