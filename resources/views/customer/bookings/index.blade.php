@extends('layouts.app')

@section('title', 'My Bookings — Hotel Rose Palace Surat')

@section('content')
<div class="container py-5">
    {{-- Header & Customer Status --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1" style="font-family: 'Playfair Display', Georgia, serif;">
                <i class="fas fa-suitcase me-2" style="color: #800020;"></i> My Bookings
            </h1>
            <p class="text-muted mb-0">
                Manage your reservations for mobile: 
                <span class="badge bg-light text-dark border px-2 py-1 fw-semibold">
                    <i class="fas fa-mobile-alt text-success me-1"></i> {{ $customerMobile }}
                </span>
            </p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <a href="{{ route('booking.search.form') }}" class="btn text-white fw-semibold px-3 py-2 shadow-sm" style="background: linear-gradient(135deg, #800020, #9f0028); border-radius: 6px;">
                <i class="fas fa-plus me-1"></i> New Booking
            </a>
            <form action="{{ route('otp.logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary px-3 py-2 fw-semibold" style="border-radius: 6px;" title="Sign out from booking session">
                    <i class="fas fa-sign-out-alt me-1"></i> Sign Out
                </button>
            </form>
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
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Summary Counters --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: #fff;">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle me-3 text-primary" style="background-color: #eef2ff;">
                        <i class="fas fa-calendar-alt fa-lg"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold d-block">Total Bookings</span>
                        <span class="fs-4 fw-bold text-dark">{{ $counts['all'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: #fff;">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle me-3 text-success" style="background-color: #ecfdf5;">
                        <i class="fas fa-hotel fa-lg"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold d-block">Upcoming Stays</span>
                        <span class="fs-4 fw-bold text-dark">{{ $counts['upcoming'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: #fff;">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle me-3 text-warning" style="background-color: #fffbeb;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold d-block">Awaiting Payment</span>
                        <span class="fs-4 fw-bold text-dark">{{ $counts['pending'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 10px; background-color: #fff;">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle me-3 text-secondary" style="background-color: #f3f4f6;">
                        <i class="fas fa-check-double fa-lg"></i>
                    </div>
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold d-block">Completed</span>
                        <span class="fs-4 fw-bold text-dark">{{ $counts['completed'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Navigation Tabs --}}
    <ul class="nav nav-pills mb-4 pb-2 border-bottom flex-nowrap overflow-auto" style="gap: 8px;">
        <li class="nav-item">
            <a class="nav-link py-2 px-3 fw-semibold {{ $currentTab === 'all' ? 'active text-white' : 'text-dark bg-white border' }}" 
               style="{{ $currentTab === 'all' ? 'background-color: #800020;' : '' }} border-radius: 20px;"
               href="{{ route('customer.bookings.index', ['tab' => 'all']) }}">
                All Bookings <span class="badge {{ $currentTab === 'all' ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $counts['all'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2 px-3 fw-semibold {{ $currentTab === 'upcoming' ? 'active text-white' : 'text-dark bg-white border' }}" 
               style="{{ $currentTab === 'upcoming' ? 'background-color: #800020;' : '' }} border-radius: 20px;"
               href="{{ route('customer.bookings.index', ['tab' => 'upcoming']) }}">
                Upcoming <span class="badge {{ $currentTab === 'upcoming' ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $counts['upcoming'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2 px-3 fw-semibold {{ $currentTab === 'completed' ? 'active text-white' : 'text-dark bg-white border' }}" 
               style="{{ $currentTab === 'completed' ? 'background-color: #800020;' : '' }} border-radius: 20px;"
               href="{{ route('customer.bookings.index', ['tab' => 'completed']) }}">
                Completed <span class="badge {{ $currentTab === 'completed' ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $counts['completed'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2 px-3 fw-semibold {{ $currentTab === 'pending' ? 'active text-white' : 'text-dark bg-white border' }}" 
               style="{{ $currentTab === 'pending' ? 'background-color: #800020;' : '' }} border-radius: 20px;"
               href="{{ route('customer.bookings.index', ['tab' => 'pending']) }}">
                Pending Payment <span class="badge {{ $currentTab === 'pending' ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $counts['pending'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2 px-3 fw-semibold {{ $currentTab === 'failed' ? 'active text-white' : 'text-dark bg-white border' }}" 
               style="{{ $currentTab === 'failed' ? 'background-color: #800020;' : '' }} border-radius: 20px;"
               href="{{ route('customer.bookings.index', ['tab' => 'failed']) }}">
                Payment Failed <span class="badge {{ $currentTab === 'failed' ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $counts['failed'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2 px-3 fw-semibold {{ $currentTab === 'cancelled' ? 'active text-white' : 'text-dark bg-white border' }}" 
               style="{{ $currentTab === 'cancelled' ? 'background-color: #800020;' : '' }} border-radius: 20px;"
               href="{{ route('customer.bookings.index', ['tab' => 'cancelled']) }}">
                Cancelled <span class="badge {{ $currentTab === 'cancelled' ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $counts['cancelled'] }}</span>
            </a>
        </li>
    </ul>

    {{-- Bookings Cards List --}}
    @if ($bookings->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center my-4" style="border-radius: 12px; background: #fff;">
            <div class="mb-3">
                <i class="fas fa-calendar-times fa-3x text-muted" style="opacity: 0.5;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">No Bookings Found</h4>
            <p class="text-muted mb-4 mx-auto" style="max-width: 480px;">
                @if ($currentTab !== 'all')
                    There are currently no bookings under the "{{ ucfirst($currentTab) }}" category for your verified mobile.
                @else
                    You have not made any room reservations yet. Experience premier royal hospitality at Hotel Rose Palace Surat!
                @endif
            </p>
            <div>
                <a href="{{ route('booking.search.form') }}" class="btn text-white fw-semibold px-4 py-2" style="background: #800020; border-radius: 6px;">
                    <i class="fas fa-search me-1"></i> Browse &amp; Book Rooms
                </a>
            </div>
        </div>
    @else
        <div class="row g-4 mb-4">
            @foreach ($bookings as $booking)
                @php
                    $isCancellationPending = $booking->isCancellationPending();
                    $isCancelled = ($booking->booking_status === 'cancelled' || !empty($booking->cancelled_at));
                    $isPaid = ($booking->payment_status === 'paid');
                    $isPending = ($booking->payment_status === 'pending' && !$isCancelled);
                    $hasFailedPayment = ($booking->payments->where('status', 'failed')->isNotEmpty() && !$isPaid && !$isCancelled);
                    $isRefunded = in_array($booking->payment_status, ['refunded', 'partially_refunded']) || ($booking->latestPayment?->status === 'refunded');
                    $isRefundPending = ($booking->latestPayment?->status === 'refund_pending');
                    
                    $checkIn = \Carbon\Carbon::parse($booking->check_in_date);
                    $checkOut = \Carbon\Carbon::parse($booking->check_out_date);
                    $nights = $checkIn->diffInDays($checkOut);
                    if ($nights < 1) $nights = 1;
                @endphp
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; transition: transform 0.2s ease;">
                        <div class="card-body p-4">
                            <div class="row align-items-center g-3">
                                {{-- Left: Reference, Dates, Category --}}
                                <div class="col-lg-5 col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="fw-bold text-dark fs-5 me-2" style="font-family: monospace;">
                                            {{ $booking->booking_reference }}
                                        </span>
                                        <small class="text-muted">
                                            &bull; Booked on {{ $booking->created_at?->format('d M Y') }}
                                        </small>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">
                                        {{ $booking->roomType?->name ?? 'Deluxe Room' }}
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-bed me-1"></i> {{ $booking->room_quantity }} Room(s) &bull; 
                                        <i class="fas fa-users me-1"></i> {{ $booking->total_guests }} Guest(s)
                                        @if ($booking->allocations->isNotEmpty())
                                            &bull; <span class="text-dark fw-semibold">Allocated: {{ $booking->allocations->pluck('room.room_number')->filter()->implode(', ') ?: 'Room Assured' }}</span>
                                        @endif
                                    </p>
                                </div>

                                {{-- Middle: Stay Duration --}}
                                <div class="col-lg-3 col-md-3">
                                    <span class="text-muted small text-uppercase fw-semibold d-block mb-1">Stay Duration</span>
                                    <div class="fw-semibold text-dark">
                                        {{ $checkIn->format('d M Y') }} &rarr; {{ $checkOut->format('d M Y') }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-moon text-primary me-1"></i> {{ $nights }} Night(s)
                                    </small>
                                </div>

                                {{-- Right: Amount & Status Badge --}}
                                <div class="col-lg-2 col-md-3 text-lg-end">
                                    <span class="text-muted small text-uppercase fw-semibold d-block mb-1">Total Bill</span>
                                    <div class="fs-5 fw-bold" style="color: #800020;">
                                        ₹{{ number_format($booking->total_amount, 2) }}
                                    </div>
                                    <div class="mt-1">
                                        @if ($isCancellationPending)
                                            <span class="badge bg-warning text-dark text-uppercase px-2 py-1" style="font-size: 0.75rem;">Cancellation Pending</span>
                                        @elseif ($isCancelled)
                                            <span class="badge bg-danger text-uppercase px-2 py-1" style="font-size: 0.75rem;">Cancelled</span>
                                        @elseif ($isRefunded)
                                            <span class="badge bg-info text-dark text-uppercase px-2 py-1" style="font-size: 0.75rem;">Refunded</span>
                                        @elseif ($isRefundPending)
                                            <span class="badge bg-warning text-dark text-uppercase px-2 py-1" style="font-size: 0.75rem;">Refund Pending</span>
                                        @elseif ($isPaid)
                                            <span class="badge bg-success text-uppercase px-2 py-1" style="font-size: 0.75rem;">Confirmed</span>
                                        @elseif ($hasFailedPayment)
                                            <span class="badge bg-danger text-uppercase px-2 py-1" style="font-size: 0.75rem;">Payment Failed</span>
                                        @else
                                            <span class="badge bg-warning text-dark text-uppercase px-2 py-1" style="font-size: 0.75rem;">Pending Payment</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="col-lg-2 col-12 text-lg-end d-flex flex-lg-column gap-2 justify-content-end">
                                    <a href="{{ route('customer.bookings.show', ['booking' => $booking->id]) }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </a>

                                    @if ($isPaid)
                                        <a href="{{ route('customer.bookings.confirmation', ['booking' => $booking->id]) }}" class="btn btn-outline-success btn-sm fw-semibold">
                                            <i class="fas fa-receipt me-1"></i> Receipt
                                        </a>
                                    @elseif ($isPending || $hasFailedPayment)
                                        <a href="{{ route('booking.payment', ['booking' => $booking->id]) }}" class="btn text-white btn-sm fw-semibold" style="background-color: #800020;">
                                            <i class="fas fa-credit-card me-1"></i> Pay Now
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
