@extends('layouts.app')

@section('title', 'Booking Details #' . $booking->booking_reference . ' — Hotel Rose Palace')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Navigation breadcrumb / Back link --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                    <i class="fas fa-arrow-left me-1"></i> Back to My Bookings
                </a>
                <span class="text-muted small">
                    Verified session: <strong class="text-dark">{{ session('verified_mobile') }}</strong>
                </span>
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

            @php
                $isCancelled = ($booking->booking_status === 'cancelled' || !empty($booking->cancelled_at));
                $isPaid = ($booking->payment_status === 'paid');
                $isPending = ($booking->payment_status === 'pending' && !$isCancelled);
                $isRefunded = in_array($booking->payment_status, ['refunded', 'partially_refunded']) || ($latestPayment?->status === 'refunded');
                $isRefundPending = ($latestPayment?->status === 'refund_pending');
                $hasFailedPayment = ($latestPayment?->status === 'failed' && !$isPaid);

                $checkIn = \Carbon\Carbon::parse($booking->check_in_date);
                $checkOut = \Carbon\Carbon::parse($booking->check_out_date);
                $nights = $checkIn->diffInDays($checkOut);
                if ($nights < 1) $nights = 1;
            @endphp

            {{-- Main Details Card --}}
            <div class="card shadow border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
                {{-- Header Strip --}}
                <div class="card-header py-3 px-4" style="background: #800020; color: #fff;">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <span class="small text-uppercase fw-semibold" style="opacity: 0.85;">Booking Reference</span>
                            <h4 class="mb-0 fw-bold" style="font-family: monospace;">{{ $booking->booking_reference }}</h4>
                        </div>
                        <div class="mt-2 mt-sm-0 text-sm-end">
                            @if ($isCancelled)
                                <span class="badge bg-danger fs-6 px-3 py-2 text-uppercase">Cancelled</span>
                            @elseif ($isRefunded)
                                <span class="badge bg-info text-dark fs-6 px-3 py-2 text-uppercase">Refunded</span>
                            @elseif ($isRefundPending)
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2 text-uppercase">Refund Pending</span>
                            @elseif ($isPaid)
                                <span class="badge bg-success fs-6 px-3 py-2 text-uppercase">Confirmed</span>
                            @elseif ($hasFailedPayment)
                                <span class="badge bg-danger fs-6 px-3 py-2 text-uppercase">Payment Failed</span>
                            @else
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2 text-uppercase">Awaiting Payment</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    {{-- Cancellation & Refund Status Banners --}}
                    @if ($booking->isCancellationPending())
                        <div class="alert alert-warning d-flex align-items-start mb-4 p-3 rounded shadow-sm border-warning">
                            <i class="fas fa-hourglass-half fs-4 me-3 text-warning mt-1"></i>
                            <div>
                                <h6 class="mb-1 fw-bold text-dark">Cancellation Requested — Awaiting Hotel Manager Approval</h6>
                                <p class="mb-1 small text-muted">
                                    You submitted a cancellation request on {{ $booking->cancellation_requested_at?->format('d M Y, h:i A') ?? 'recently' }}.
                                    Applicable refund: <strong>{{ $booking->eligible_refund_percentage ?? 0 }}% (₹{{ number_format($booking->eligible_refund_amount ?? 0, 2) }})</strong>.
                                    Your room allocation remains active until approved by the hotel manager.
                                </p>
                                @if ($booking->cancellation_reason)
                                    <div class="small text-muted"><em>Reason: {{ $booking->cancellation_reason }}</em></div>
                                @endif
                            </div>
                        </div>
                    @elseif ($booking->isCancellationRejected())
                        <div class="alert alert-secondary d-flex align-items-start mb-4 p-3 rounded shadow-sm">
                            <i class="fas fa-ban fs-4 me-3 text-secondary mt-1"></i>
                            <div>
                                <h6 class="mb-1 fw-bold text-dark">Cancellation Request Rejected</h6>
                                <p class="mb-1 small text-muted">
                                    The hotel manager reviewed and declined the cancellation request. Your reservation and room allocation remain confirmed.
                                </p>
                                @if ($booking->cancellation_rejection_reason)
                                    <div class="small text-danger"><strong>Manager Reason:</strong> {{ $booking->cancellation_rejection_reason }}</div>
                                @endif
                            </div>
                        </div>
                    @elseif ($isCancelled)
                        <div class="alert alert-danger d-flex align-items-start mb-4 p-3 rounded shadow-sm">
                            <i class="fas fa-times-circle fs-4 me-3 text-danger mt-1"></i>
                            <div class="w-100">
                                <h6 class="mb-1 fw-bold">Booking Cancelled on {{ $booking->cancelled_at?->format('d M Y, h:i A') ?? 'N/A' }}</h6>
                                <div class="small mt-1">
                                    @if ($booking->refund_status === 'processed' || $isRefunded)
                                        <span class="badge bg-success me-2">Refund Processed</span>
                                        Refund of <strong>₹{{ number_format($booking->eligible_refund_amount ?? $latestPayment?->refund_amount ?? 0, 2) }}</strong> ({{ $booking->eligible_refund_percentage ?? 100 }}%) has been processed to your original payment method. Estimated 5–7 business days for bank settlement.
                                        @if ($latestPayment?->refund_id)
                                            <span class="font-monospace text-muted ms-2">(Ref: {{ $latestPayment->refund_id }})</span>
                                        @endif
                                    @elseif ($booking->refund_status === 'pending' || $isRefundPending)
                                        <span class="badge bg-warning text-dark me-2">Refund Pending</span>
                                        Refund has been initiated with Razorpay and is awaiting banking clearance.
                                    @elseif ($booking->refund_status === 'failed')
                                        <span class="badge bg-danger me-2">Refund Failed</span>
                                        The refund could not be completed automatically. Hotel staff will reconcile this transaction directly.
                                    @elseif ($booking->refund_status === 'not_applicable' || $booking->eligible_refund_percentage === 0)
                                        <span class="badge bg-secondary me-2">Non-Refundable (0%)</span>
                                        Cancellation completed per policy tier (cancellation at or after check-in time).
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Status Notice Banner --}}
                    @if ($isPaid)
                        <div class="alert alert-success d-flex align-items-center mb-4 p-3 shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Booking Confirmed & Guaranteed</h6>
                                <small>Your payment of ₹{{ number_format($booking->total_amount, 2) }} was verified. We look forward to welcoming you!</small>
                            </div>
                        </div>
                    @elseif ($isPending)
                        <div class="alert alert-warning d-flex align-items-center justify-content-between mb-4 p-3 shadow-sm" style="border-radius: 8px;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock fa-2x me-3 text-warning"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">Complete Payment to Confirm Room</h6>
                                    <small>This booking is currently on hold. 100% online payment is required to confirm reservation.</small>
                                </div>
                            </div>
                            <div class="ms-3">
                                <a href="{{ route('booking.payment', ['booking' => $booking->id]) }}" class="btn text-white fw-bold px-3 py-2" style="background-color: #800020; border-radius: 6px;">
                                    <i class="fas fa-credit-card me-1"></i> Pay ₹{{ number_format($booking->total_amount, 2) }}
                                </a>
                            </div>
                        </div>
                    @elseif ($isCancelled)
                        <div class="alert alert-danger d-flex align-items-center mb-4 p-3 shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-ban fa-2x me-3 text-danger"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Reservation Cancelled</h6>
                                <small>
                                    @if ($booking->cancellation_reason)
                                        Reason: {{ $booking->cancellation_reason }}
                                    @else
                                        This booking has been cancelled and physical rooms have been released.
                                    @endif
                                </small>
                            </div>
                        </div>
                    @endif

                    {{-- Stay & Room Overview --}}
                    <div class="row g-4 mb-4 pb-4 border-bottom">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i class="fas fa-hotel text-primary me-2"></i> Stay & Room Information</h6>
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted ps-0" style="width: 140px;">Room Category:</td>
                                    <td class="fw-bold text-dark">{{ $booking->roomType?->name ?? 'Deluxe Room' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Rooms Reserved:</td>
                                    <td class="fw-semibold">{{ $booking->room_quantity }} Room(s)</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Guest Occupancy:</td>
                                    <td class="fw-semibold">{{ $booking->total_guests }} Guest(s) ({{ $booking->num_adults }} Adults, {{ $booking->num_children }} Children)</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Allocated Room(s):</td>
                                    <td>
                                        @if ($booking->allocations->isNotEmpty())
                                            @foreach ($booking->allocations as $alloc)
                                                <span class="badge bg-light text-dark border me-1">
                                                    <i class="fas fa-door-closed text-secondary me-1"></i> Room {{ $alloc->room?->room_number ?? 'Assigned' }}
                                                    <small class="text-muted">({{ ucfirst($alloc->allocation_status) }})</small>
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Allocated on arrival</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i class="fas fa-calendar-check text-primary me-2"></i> Dates & Timeline</h6>
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted ps-0" style="width: 140px;">Check-In Date:</td>
                                    <td class="fw-bold text-dark">{{ $checkIn->format('D, d M Y') }} (from 12:00 PM)</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Check-Out Date:</td>
                                    <td class="fw-bold text-dark">{{ $checkOut->format('D, d M Y') }} (by 11:00 AM)</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Duration:</td>
                                    <td class="fw-semibold text-primary"><i class="fas fa-moon me-1"></i> {{ $nights }} Night(s) Stay</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Booking Created:</td>
                                    <td class="text-muted">{{ $booking->created_at?->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Guest Information & Special Requests --}}
                    <div class="row g-4 mb-4 pb-4 border-bottom">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i class="fas fa-user text-primary me-2"></i> Guest Contact Details</h6>
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td class="text-muted ps-0" style="width: 140px;">Primary Guest:</td>
                                    <td class="fw-bold text-dark">{{ $booking->customer_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Mobile Number:</td>
                                    <td class="fw-semibold">{{ $booking->customer_mobile }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Email Address:</td>
                                    <td class="fw-semibold">{{ $booking->customer_email ?? 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i class="fas fa-comment-dots text-primary me-2"></i> Special Requests</h6>
                            <div class="p-3 bg-light rounded" style="min-height: 80px;">
                                @if (!empty($booking->special_requests))
                                    <p class="mb-0 text-dark small">{{ $booking->special_requests }}</p>
                                @else
                                    <span class="text-muted small fst-italic">No special requests noted for this stay.</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Price Breakdown & Payment Verification --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i class="fas fa-receipt text-warning me-2"></i> Billing Breakdown</h6>
                            <div class="p-3 rounded" style="background-color: #fdf8f4; border: 1px dashed #d4af37;">
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
                                    <span class="fs-5 fw-bold text-dark">Total Amount</span>
                                    <span class="fs-4 fw-bold" style="color: #800020;">₹{{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3"><i class="fas fa-shield-alt text-success me-2"></i> Verified Payment Details</h6>
                            <div class="p-3 bg-light rounded border h-100">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td class="text-muted ps-0" style="width: 140px;">Payment Status:</td>
                                        <td>
                                            @if ($isPaid)
                                                <span class="badge bg-success">Paid (Captured)</span>
                                            @elseif ($isRefunded)
                                                <span class="badge bg-info text-dark">Refunded</span>
                                            @elseif ($isRefundPending)
                                                <span class="badge bg-warning text-dark">Refund Pending</span>
                                            @elseif ($hasFailedPayment)
                                                <span class="badge bg-danger">Failed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Transaction Ref:</td>
                                        <td class="fw-semibold font-monospace">
                                            {{ $booking->razorpay_payment_id ?? ($latestPayment?->razorpay_payment_id ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted ps-0">Payment Method:</td>
                                        <td class="text-dark">
                                            @if ($latestPayment?->method)
                                                <span class="badge bg-secondary text-uppercase">{{ $latestPayment->method }}</span>
                                                @if ($latestPayment->vpa) <small>({{ $latestPayment->vpa }})</small> @endif
                                                @if ($latestPayment->card_network) <small>({{ $latestPayment->card_network }} ****{{ $latestPayment->card_last4 }})</small> @endif
                                            @else
                                                <span class="text-muted">Online Gateway</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($latestPayment?->captured_at)
                                        <tr>
                                            <td class="text-muted ps-0">Completed At:</td>
                                            <td class="text-muted small">{{ $latestPayment->captured_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                    @endif
                                    @if ($latestPayment?->refund_id)
                                        <tr>
                                            <td class="text-muted ps-0">Refund Reference:</td>
                                            <td class="text-muted font-monospace small">{{ $latestPayment->refund_id }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Bar --}}
                    <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top gap-2">
                        <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to All Bookings
                        </a>

                        <div class="d-flex gap-2">
                            @if ($isPaid && !$isCancelled && !$booking->isCancellationPending())
                                <a href="{{ route('customer.bookings.cancel', $booking) }}" class="btn btn-outline-danger fw-semibold">
                                    <i class="fas fa-times-circle me-1"></i> Request Cancellation
                                </a>
                            @endif

                            @if ($isPaid)
                                <a href="{{ route('customer.bookings.confirmation', ['booking' => $booking->id]) }}" class="btn text-white fw-bold px-4" style="background: linear-gradient(135deg, #800020, #9f0028);">
                                    <i class="fas fa-print me-1"></i> View Receipt
                                </a>
                            @elseif ($isPending || $hasFailedPayment)
                                <a href="{{ route('booking.payment', ['booking' => $booking->id]) }}" class="btn text-white fw-bold px-4" style="background: linear-gradient(135deg, #800020, #9f0028);">
                                    <i class="fas fa-credit-card me-1"></i> Pay Now (₹{{ number_format($booking->total_amount, 2) }})
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
