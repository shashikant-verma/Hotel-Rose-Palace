@extends('admin.layouts.app')

@section('title', 'Front Desk & PMS Dashboard')
@section('page-title', 'Hotel Rose Palace — Front Desk & PMS Dashboard')

@section('content')
<!-- Top Quick Action Bar -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 bg-white p-3 rounded-3 shadow-sm border" style="border-color: var(--color-border-subtle) !important;">
    <div class="d-flex align-items-center gap-2">
        <span class="fs-5 fw-bold" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
            <i class="fas fa-hotel me-2"></i> Reception Command Center
        </span>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
            <i class="fas fa-circle fa-xs me-1"></i> Front Desk Active
        </span>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.calendar') }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-calendar-alt me-1"></i> 14-Day Calendar
        </a>
        <a href="{{ route('admin.banquets.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-champagne-glasses me-1"></i> Banquet Bookings
        </a>
        <button type="button" class="btn btn-sm text-white px-3" data-bs-toggle="modal" data-bs-target="#dashboardWalkInModal" style="background-color: var(--color-burgundy-rose);">
            <i class="fas fa-user-plus me-1"></i> New Walk-In Booking
        </button>
    </div>
</div>

<!-- Primary PMS KPI Row -->
<div class="row g-3 mb-4">
    <!-- Today's Check-Ins -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-bold">Today's Check-Ins</div>
                    <div class="fs-2 fw-bold mt-1 text-primary">{{ $stats['today_checkins'] }}</div>
                    <div class="small text-muted mt-1">Arrivals scheduled today</div>
                </div>
                <div class="p-3 rounded-circle bg-primary-subtle text-primary">
                    <i class="fas fa-key fa-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Check-Outs -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-bold">Today's Check-Outs</div>
                    <div class="fs-2 fw-bold mt-1 text-danger">{{ $stats['today_checkouts'] }}</div>
                    <div class="small text-muted mt-1">Departures scheduled today</div>
                </div>
                <div class="p-3 rounded-circle bg-danger-subtle text-danger">
                    <i class="fas fa-sign-out-alt fa-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Clean Rooms -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-bold">Available Clean Rooms</div>
                    <div class="fs-2 fw-bold mt-1 text-success">{{ $stats['clean_available_rooms'] }} <span class="fs-6 text-muted">/ {{ $stats['total_rooms'] }}</span></div>
                    <div class="small text-warning-emphasis">
                        <i class="fas fa-broom me-1"></i> {{ $stats['dirty_rooms'] }} Dirty &bull; {{ $stats['maintenance_rooms'] }} Maint.
                    </div>
                </div>
                <div class="p-3 rounded-circle bg-success-subtle text-success">
                    <i class="fas fa-bed fa-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue (Recorded Offline) -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small text-uppercase fw-bold">Monthly Offline Revenue</div>
                    <div class="fs-3 fw-bold mt-1" style="color: var(--color-burgundy-rose);">₹{{ number_format($stats['monthly_revenue'], 0) }}</div>
                    <div class="small text-muted mt-1">Cash / UPI / Card collected</div>
                </div>
                <div class="p-3 rounded-circle" style="background-color: rgba(110, 44, 58, 0.1); color: var(--color-burgundy-rose);">
                    <i class="fas fa-receipt fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Operational Tables: Today's Arrivals & Today's Departures -->
<div class="row g-4 mb-4">
    <!-- Today's Arrivals -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-plane-arrival me-2 text-primary"></i> Today's Expected Arrivals ({{ $todayArrivals->count() }})
                </h6>
                <a href="{{ route('admin.enquiries.index', ['date_from' => today()->format('Y-m-d'), 'date_to' => today()->format('Y-m-d')]) }}" class="small text-muted text-decoration-none">
                    View All &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr style="font-size: 11px;">
                                <th class="ps-3">Guest & Phone</th>
                                <th>Room</th>
                                <th>Status</th>
                                <th class="pe-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayArrivals as $arr)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">{{ $arr->customer_name }}</div>
                                        <div class="small text-muted">{{ $arr->customer_phone }}</div>
                                    </td>
                                    <td>
                                        @if($arr->room)
                                            <span class="badge bg-light text-dark border fw-bold">Room {{ $arr->room->room_number }}</span>
                                        @else
                                            <span class="small text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $arr->status === 'checked_in' ? 'bg-success' : 'bg-primary' }}" style="font-size: 10px;">
                                            {{ ucfirst(str_replace('_', ' ', $arr->status)) }}
                                        </span>
                                    </td>
                                    <td class="pe-3 text-end">
                                        @if($arr->status !== 'checked_in')
                                            <form action="{{ route('admin.enquiries.check-in', $arr) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-pms-checkin py-1 px-2" title="Check In Now">
                                                    <i class="fas fa-key"></i> Check In
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-success small fw-bold"><i class="fas fa-check"></i> In-House</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        No arrivals scheduled for today.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Departures -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-danger">
                    <i class="fas fa-plane-departure me-2"></i> Today's Due Departures ({{ $todayDepartures->count() }})
                </h6>
                <a href="{{ route('admin.enquiries.index') }}" class="small text-muted text-decoration-none">
                    View All &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr style="font-size: 11px;">
                                <th class="ps-3">Guest & Phone</th>
                                <th>Room</th>
                                <th>Bill Status</th>
                                <th class="pe-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayDepartures as $dep)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">{{ $dep->customer_name }}</div>
                                        <div class="small text-muted">{{ $dep->customer_phone }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border fw-bold">
                                            Room {{ $dep->room->room_number ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($dep->balance_due > 0)
                                            <span class="badge bg-danger-subtle text-danger" style="font-size: 10px;">Due: ₹{{ number_format($dep->balance_due, 0) }}</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success" style="font-size: 10px;">Settled</span>
                                        @endif
                                    </td>
                                    <td class="pe-3 text-end">
                                        @if($dep->status === 'checked_in')
                                            <form action="{{ route('admin.enquiries.check-out', $dep) }}" method="POST" class="d-inline" onsubmit="return confirm('Check-out guest and mark room as dirty?');">
                                                @csrf
                                                <button type="submit" class="btn-pms-checkout py-1 px-2" title="Check Out & Mark Room Dirty">
                                                    <i class="fas fa-sign-out-alt"></i> Check Out
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-secondary small fw-semibold">Checked Out</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        No departures scheduled for today.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Row: Recent Bookings & Upcoming Banquets -->
<div class="row g-4 mb-4">
    <!-- Recent Enquiries / Bookings -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-clock-rotate-left me-2"></i> Recent Bookings & Enquiries
                </h6>
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-outline-secondary">
                    View All Reservations &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr style="font-size: 11px;">
                                <th class="ps-3">Ref ID</th>
                                <th>Guest</th>
                                <th>Room Type</th>
                                <th>Check-In</th>
                                <th>Status</th>
                                <th class="pe-3 text-end">Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnquiries as $enquiry)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="fw-bold text-decoration-none" style="color: var(--color-burgundy-rose);">
                                            {{ $enquiry->reference_id }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $enquiry->customer_name }}</div>
                                        <div class="small text-muted">{{ $enquiry->customer_phone }}</div>
                                    </td>
                                    <td>{{ $enquiry->roomType->name ?? 'Standard' }}</td>
                                    <td>{{ $enquiry->check_in_date ? $enquiry->check_in_date->format('d M, Y') : 'N/A' }}</td>
                                    <td>
                                        @php
                                            $sBadge = match($enquiry->status) {
                                                'checked_in' => 'bg-success',
                                                'checked_out' => 'bg-secondary',
                                                'booking_confirmed' => 'bg-primary',
                                                'availability_confirmed' => 'bg-warning text-dark',
                                                'contacted' => 'bg-info text-dark',
                                                'cancelled' => 'bg-danger',
                                                default => 'bg-light text-dark border'
                                            };
                                        @endphp
                                        <span class="badge {{ $sBadge }}" style="font-size: 10px;">
                                            {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                                        </span>
                                    </td>
                                    <td class="pe-3 text-end">
                                        <a href="{{ route('admin.enquiries.invoice', $enquiry) }}" target="_blank" class="btn btn-sm btn-outline-dark p-1 px-2" title="Print Invoice">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted small">No recent bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Banquets -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" style="color: var(--color-brass-gold);">
                    <i class="fas fa-champagne-glasses me-2"></i> Upcoming Banquets
                </h6>
                <a href="{{ route('admin.banquets.index') }}" class="small text-muted text-decoration-none">
                    View All &rarr;
                </a>
            </div>
            <div class="card-body p-3">
                @forelse($upcomingBanquets as $ub)
                    <div class="p-2 mb-2 rounded border" style="background-color: var(--color-champagne); border-color: var(--color-border-subtle) !important;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong class="text-dark d-block">{{ $ub->event_type }}</strong>
                                <small class="text-muted">{{ $ub->customer_name }} &bull; {{ $ub->guest_count }} Guests</small>
                            </div>
                            <span class="badge bg-secondary" style="font-size: 10px;">{{ strtoupper($ub->slot) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-1 border-top" style="font-size: 11px;">
                            <span class="text-dark fw-bold">
                                <i class="far fa-calendar-alt me-1 text-muted"></i> {{ $ub->event_date->format('d M, Y') }}
                            </span>
                            <span class="text-success fw-bold">Adv: ₹{{ number_format($ub->advance_paid, 0) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        <i class="fas fa-champagne-glasses fa-2x mb-2 text-muted" style="opacity: 0.3;"></i>
                        <p class="mb-0">No upcoming confirmed banquets.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal: New Walk-In Booking Directly on Dashboard -->
<div class="modal fade" id="dashboardWalkInModal" tabindex="-1" aria-labelledby="dashWalkInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--color-burgundy-rose);">
                <h5 class="modal-title" id="dashWalkInModalLabel">
                    <i class="fas fa-door-open me-2"></i> New Walk-In / Phone Reservation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.enquiries.walk-in') }}" method="POST">
                @csrf
                <div class="modal-body p-4" style="background-color: var(--color-sandstone-base);">
                    <!-- 1. Guest Information -->
                    <h6 class="fw-bold mb-3" style="color: var(--color-burgundy-rose);">1. Guest Profile & ID Verification</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Guest Full Name *</label>
                            <input type="text" name="customer_name" class="form-control" required placeholder="e.g. Amitbhai Shah">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Mobile Phone *</label>
                            <input type="text" name="customer_phone" class="form-control" required placeholder="10-digit mobile number">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Email (Optional)</label>
                            <input type="email" name="customer_email" class="form-control" placeholder="guest@example.com">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">ID Proof Type *</label>
                            <select name="id_proof_type" class="form-select" required>
                                <option value="Aadhaar Card">Aadhaar Card</option>
                                <option value="Passport">Passport</option>
                                <option value="Driving License">Driving License</option>
                                <option value="Voter ID">Voter ID</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">ID Proof Number / Ref *</label>
                            <input type="text" name="id_proof_number" class="form-control" required placeholder="e.g. 5432-8765-1234">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Booking Source *</label>
                            <select name="booking_type" class="form-select" required>
                                <option value="walk_in">Reception Walk-In</option>
                                <option value="phone">Direct Phone Call</option>
                                <option value="corporate">Corporate Tie-up</option>
                            </select>
                        </div>
                    </div>

                    <!-- 2. Room & Dates -->
                    <h6 class="fw-bold mb-3" style="color: var(--color-burgundy-rose);">2. Room Allocation & Stay Dates</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Assign Physical Room *</label>
                            <select name="room_id" id="dash_room_id" class="form-select" required onchange="calcDashTariff()">
                                <option value="">-- Select Available Room --</option>
                                @foreach($allRooms as $r)
                                    <option value="{{ $r->id }}" 
                                            data-price="{{ $r->current_price }}"
                                            {{ ($r->housekeeping_status ?? 'clean') !== 'clean' ? 'style=color:#c0392b;' : '' }}>
                                        Room {{ $r->room_number }} (Floor {{ $r->floor }} &bull; {{ $r->roomType->name ?? 'Standard' }} &bull; ₹{{ number_format($r->current_price) }}/nt) [{{ strtoupper($r->housekeeping_status ?? 'clean') }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Check-In Date *</label>
                            <input type="date" name="check_in_date" id="dash_check_in" class="form-control" required value="{{ now()->format('Y-m-d') }}" onchange="calcDashTariff()">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Check-Out Date *</label>
                            <input type="date" name="check_out_date" id="dash_check_out" class="form-control" required value="{{ now()->addDay()->format('Y-m-d') }}" onchange="calcDashTariff()">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Adults *</label>
                            <input type="number" name="num_adults" min="1" max="10" value="2" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Children</label>
                            <input type="number" name="num_children" min="0" max="10" value="0" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Special Requests</label>
                            <input type="text" name="special_requests" class="form-control" placeholder="Ground floor, extra mattress, Jain meal...">
                        </div>
                    </div>

                    <!-- 3. Offline Payment & Action -->
                    <h6 class="fw-bold mb-3" style="color: var(--color-burgundy-rose);">3. Offline Payment & Instant Action</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Total Base Tariff (₹) *</label>
                            <input type="number" name="total_tariff" id="dash_total_tariff" class="form-control fw-bold" required min="0" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Amount Paid at Desk (₹)</label>
                            <input type="number" name="paid_amount" class="form-control" min="0" step="0.01" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Payment Mode (Offline) *</label>
                            <select name="payment_mode" class="form-select" required>
                                <option value="Cash at Reception">Cash at Reception</option>
                                <option value="UPI / GPay">UPI / GPay (QR Scan)</option>
                                <option value="Card Swipe">Card Swipe Machine</option>
                                <option value="Pay at Checkout">Pay at Checkout</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Payment Status *</label>
                            <select name="payment_status" class="form-select" required>
                                <option value="paid">Full Paid</option>
                                <option value="partial">Partial / Advance Paid</option>
                                <option value="pending" selected>Pending (Pay Later)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Reception Action *</label>
                            <select name="instant_action" class="form-select fw-bold" required>
                                <option value="check_in" selected>Instant Check-In (Assigns Room Now)</option>
                                <option value="reserve">Reserve Room (Future Arrival)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white px-4" style="background-color: var(--color-burgundy-rose);">
                        <i class="fas fa-check me-1"></i> Save Reservation & Proceed
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function calcDashTariff() {
    const roomSelect = document.getElementById('dash_room_id');
    const checkInInput = document.getElementById('dash_check_in');
    const checkOutInput = document.getElementById('dash_check_out');
    const totalTariffInput = document.getElementById('dash_total_tariff');

    if (!roomSelect || !checkInInput || !checkOutInput || !totalTariffInput) return;

    const selectedOption = roomSelect.options[roomSelect.selectedIndex];
    const pricePerNight = parseFloat(selectedOption?.getAttribute('data-price') || 0);

    const d1 = new Date(checkInInput.value);
    const d2 = new Date(checkOutInput.value);

    let nights = 1;
    if (d1 && d2 && d2 > d1) {
        nights = Math.round((d2 - d1) / (1000 * 60 * 60 * 24));
    }

    if (pricePerNight > 0) {
        totalTariffInput.value = (pricePerNight * nights).toFixed(2);
    }
}
</script>
@endpush
