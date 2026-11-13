@extends('admin.layouts.app')

@section('title', 'Manage Cancellations & Refunds')
@section('page-title', 'Reservations — Cancellations & Refunds')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h5 class="mb-1" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
            <i class="fas fa-undo-alt me-2"></i> Cancellation & Refund Management
        </h5>
        <div class="text-muted small">
            Review customer cancellation requests, enforce hotel policy, approve Razorpay refunds, and manage room allocations.
        </div>
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

{{-- Status Filter Tabs --}}
<ul class="nav nav-pills mb-4 gap-2">
    <li class="nav-item">
        <a class="nav-link {{ $currentStatus === 'pending' ? 'active' : '' }}" 
           style="{{ $currentStatus === 'pending' ? 'background-color: var(--color-burgundy-rose); color: #fff;' : 'background-color: #fff; color: var(--color-charcoal-deep); border: 1px solid var(--color-border-subtle);' }}"
           href="{{ route('admin.cancellations.index', ['status' => 'pending']) }}">
            <i class="fas fa-hourglass-half me-1"></i> Pending Approval 
            <span class="badge bg-danger ms-1">{{ $counts['pending'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $currentStatus === 'approved' ? 'active' : '' }}" 
           style="{{ $currentStatus === 'approved' ? 'background-color: var(--color-burgundy-rose); color: #fff;' : 'background-color: #fff; color: var(--color-charcoal-deep); border: 1px solid var(--color-border-subtle);' }}"
           href="{{ route('admin.cancellations.index', ['status' => 'approved']) }}">
            <i class="fas fa-check-circle me-1"></i> Approved &amp; Cancelled 
            <span class="badge bg-secondary ms-1">{{ $counts['approved'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $currentStatus === 'rejected' ? 'active' : '' }}" 
           style="{{ $currentStatus === 'rejected' ? 'background-color: var(--color-burgundy-rose); color: #fff;' : 'background-color: #fff; color: var(--color-charcoal-deep); border: 1px solid var(--color-border-subtle);' }}"
           href="{{ route('admin.cancellations.index', ['status' => 'rejected']) }}">
            <i class="fas fa-ban me-1"></i> Rejected Requests 
            <span class="badge bg-secondary ms-1">{{ $counts['rejected'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $currentStatus === 'all' ? 'active' : '' }}" 
           style="{{ $currentStatus === 'all' ? 'background-color: var(--color-burgundy-rose); color: #fff;' : 'background-color: #fff; color: var(--color-charcoal-deep); border: 1px solid var(--color-border-subtle);' }}"
           href="{{ route('admin.cancellations.index', ['status' => 'all']) }}">
            <i class="fas fa-list me-1"></i> All History 
            <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
        </a>
    </li>
</ul>

{{-- Cancellations Table Card --}}
<div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: #fff;">
    <div class="card-body p-0">
        @if ($cancellations->isEmpty())
            <div class="p-5 text-center text-muted">
                <i class="fas fa-inbox fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                <h6 class="fw-bold">No cancellation requests found</h6>
                <p class="small mb-0">There are currently no requests in this status.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: var(--color-champagne); border-bottom: 2px solid var(--color-border-subtle);">
                        <tr>
                            <th class="ps-4">Booking Ref / Guest</th>
                            <th>Stay / Dates</th>
                            <th>Allocated Room</th>
                            <th>Gross Paid</th>
                            <th>Refund Eligible</th>
                            <th>Requested At</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cancellations as $booking)
                            @php
                                $isPending = $booking->isCancellationPending();
                                $isApproved = $booking->isCancellationApproved();
                                $isRejected = $booking->isCancellationRejected();
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold font-monospace" style="color: var(--color-burgundy-rose);">
                                        {{ $booking->booking_reference }}
                                    </div>
                                    <div class="small fw-semibold text-dark">{{ $booking->customer_name }}</div>
                                    <div class="small text-muted">{{ $booking->customer_mobile }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $booking->roomType->name ?? 'Room' }}</div>
                                    <div class="small text-muted">
                                        {{ $booking->check_in_date->format('d M') }} &rarr; {{ $booking->check_out_date->format('d M Y') }}
                                        ({{ $booking->nights }}N)
                                    </div>
                                </td>
                                <td>
                                    @if ($booking->allocations->isNotEmpty())
                                        @foreach ($booking->allocations as $alloc)
                                            <span class="badge {{ $alloc->allocation_status === 'released' ? 'bg-secondary' : 'bg-primary' }}">
                                                Room {{ $alloc->room->room_number ?? 'N/A' }}
                                                @if ($alloc->allocation_status === 'released') (Released) @endif
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">None</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">₹{{ number_format($booking->total_amount, 2) }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold {{ $booking->eligible_refund_percentage > 0 ? 'text-success' : 'text-muted' }}">
                                        ₹{{ number_format($booking->eligible_refund_amount ?? 0, 2) }}
                                    </div>
                                    <span class="badge {{ $booking->eligible_refund_percentage === 100 ? 'bg-success' : ($booking->eligible_refund_percentage === 50 ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ $booking->eligible_refund_percentage ?? 0 }}% Refund
                                    </span>
                                </td>
                                <td>
                                    <div class="small text-dark">
                                        {{ $booking->cancellation_requested_at?->format('d M Y, h:i A') ?? ($booking->updated_at?->format('d M Y') ?? 'N/A') }}
                                    </div>
                                    @if ($booking->cancellation_reason)
                                        <div class="small text-muted text-truncate" style="max-width: 180px;" title="{{ $booking->cancellation_reason }}">
                                            <em>"{{ $booking->cancellation_reason }}"</em>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($isPending)
                                        <span class="badge bg-warning text-dark px-2 py-1">Pending Review</span>
                                    @elseif ($isApproved)
                                        <span class="badge bg-success px-2 py-1">Approved &bull; Cancelled</span>
                                        @if ($booking->refund_status === 'processed')
                                            <div class="small text-success mt-1"><i class="fas fa-check"></i> Refunded</div>
                                        @elseif ($booking->refund_status === 'pending')
                                            <div class="small text-warning mt-1"><i class="fas fa-clock"></i> Refund Pending</div>
                                        @endif
                                    @elseif ($isRejected)
                                        <span class="badge bg-secondary px-2 py-1">Rejected</span>
                                    @else
                                        <span class="badge bg-dark px-2 py-1">{{ $booking->booking_status }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.cancellations.show', $booking) }}" class="btn btn-sm btn-outline-dark fw-semibold">
                                        <i class="fas fa-eye me-1"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($cancellations->hasPages())
                <div class="p-3 border-top">
                    {{ $cancellations->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
