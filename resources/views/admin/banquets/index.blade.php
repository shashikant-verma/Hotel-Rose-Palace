@extends('admin.layouts.app')

@section('title', 'Banquet & Event Bookings')
@section('page-title', 'Banquet & Event Hall Bookings')

@section('content')
<div class="banquets-wrapper">
    <!-- Top KPI Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Total Banquets</div>
                        <div class="fs-3 fw-bold mt-1" style="color: var(--color-burgundy-rose);">{{ $stats['total'] }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(110, 44, 58, 0.1); color: var(--color-burgundy-rose);">
                        <i class="fas fa-champagne-glasses fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Upcoming Confirmed</div>
                        <div class="fs-3 fw-bold mt-1 text-success">{{ $stats['upcoming'] }}</div>
                    </div>
                    <div class="p-3 rounded-circle bg-success-subtle text-success">
                        <i class="fas fa-calendar-check fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Events This Month</div>
                        <div class="fs-3 fw-bold mt-1" style="color: var(--color-brass-gold);">{{ $stats['this_month'] }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(184, 138, 68, 0.15); color: var(--color-brass-gold);">
                        <i class="fas fa-calendar-day fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card p-3 rounded-3 shadow-sm border bg-white" style="border-color: var(--color-border-subtle) !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Advance Recorded</div>
                        <div class="fs-4 fw-bold mt-1" style="color: var(--color-burgundy-rose);">₹{{ number_format($stats['revenue_advance'], 0) }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(110, 44, 58, 0.1); color: var(--color-burgundy-rose);">
                        <i class="fas fa-receipt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions & Filter Bar -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <!-- Search & Filters Form -->
                <form action="{{ route('admin.banquets.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search client name, phone, ref..." class="form-control form-control-sm" style="max-width: 240px;">
                    
                    <select name="status" class="form-select form-select-sm" style="max-width: 150px;">
                        <option value="">All Statuses</option>
                        <option value="inquiry" {{ request('status') === 'inquiry' ? 'selected' : '' }}>Inquiry</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>

                    <select name="slot" class="form-select form-select-sm" style="max-width: 140px;">
                        <option value="">All Slots</option>
                        <option value="morning" {{ request('slot') === 'morning' ? 'selected' : '' }}>Morning</option>
                        <option value="evening" {{ request('slot') === 'evening' ? 'selected' : '' }}>Evening</option>
                        <option value="full_day" {{ request('slot') === 'full_day' ? 'selected' : '' }}>Full Day</option>
                    </select>

                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm" style="max-width: 140px;" title="From Event Date">

                    <button type="submit" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'slot', 'date_from']))
                        <a href="{{ route('admin.banquets.index') }}" class="btn btn-sm btn-link text-muted">Reset</a>
                    @endif
                </form>

                <!-- New Booking Trigger -->
                <button type="button" class="btn btn-sm text-white px-3" data-bs-toggle="modal" data-bs-target="#newBanquetModal" style="background-color: var(--color-burgundy-rose);">
                    <i class="fas fa-plus me-1"></i> New Banquet Booking
                </button>
            </div>
        </div>
    </div>

    <!-- Banquet Table -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr style="border-bottom: 2px solid var(--color-border-subtle);">
                            <th class="ps-3 py-3 text-uppercase small text-muted">Ref / Date</th>
                            <th class="py-3 text-uppercase small text-muted">Client & Contact</th>
                            <th class="py-3 text-uppercase small text-muted">Event Details</th>
                            <th class="py-3 text-uppercase small text-muted">Slot / Guests</th>
                            <th class="py-3 text-uppercase small text-muted">Financials (Offline)</th>
                            <th class="py-3 text-uppercase small text-muted">Status</th>
                            <th class="pe-3 py-3 text-end text-uppercase small text-muted">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banquets as $b)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold" style="color: var(--color-burgundy-rose);">{{ $b->reference_id }}</div>
                                    <div class="small fw-semibold text-dark mt-1">
                                        <i class="far fa-calendar-alt me-1 text-muted"></i> {{ $b->event_date ? $b->event_date->format('d M, Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $b->customer_name }}</div>
                                    <div class="small text-muted">
                                        <i class="fas fa-phone-alt me-1" style="font-size: 10px;"></i> {{ $b->customer_phone }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $b->event_type }}</div>
                                    <div class="small text-muted" style="font-size: 11px;">
                                        Menu: {{ Str::limit($b->catering_package, 25) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $b->slot === 'full_day' ? 'bg-primary' : ($b->slot === 'evening' ? 'bg-indigo text-white' : 'bg-info text-dark') }}" style="font-size: 10px;">
                                        {{ strtoupper(str_replace('_', ' ', $b->slot)) }}
                                    </span>
                                    <div class="small text-muted mt-1">
                                        <i class="fas fa-users me-1"></i> {{ $b->guest_count }} Guests
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">₹{{ number_format($b->total_amount, 2) }}</div>
                                    <div class="small text-success">
                                        Adv: ₹{{ number_format($b->advance_paid, 2) }} ({{ $b->payment_mode }})
                                    </div>
                                    @if($b->balance_due > 0)
                                        <div class="small text-danger fw-semibold">Due: ₹{{ number_format($b->balance_due, 2) }}</div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $bBadge = match($b->status) {
                                            'confirmed' => 'bg-success',
                                            'completed' => 'bg-secondary',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-warning text-dark'
                                        };
                                    @endphp
                                    <span class="badge {{ $bBadge }}" style="font-size: 11px;">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                                <td class="pe-3 text-end">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        @php
                                            $waBanquetMsg = "Namaste {$b->customer_name}, regarding your Banquet Booking ({$b->reference_id}) at Hotel Rose Palace Surat for {$b->event_type} on " . ($b->event_date ? $b->event_date->format('d M, Y') : '') . " ({$b->slot} slot). Total Quote: Rs. " . number_format($b->total_amount, 0) . ", Advance: Rs. " . number_format($b->advance_paid, 0) . ". Looking forward to hosting your celebration!";
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $b->customer_phone);
                                            if (strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waBanquetMsg) }}" target="_blank" class="btn-whatsapp-pms p-1 px-2" title="Send WhatsApp Confirmation">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>

                                        <form action="{{ route('admin.banquets.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this banquet record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-champagne-glasses fa-3x mb-3 text-muted" style="opacity: 0.3;"></i>
                                    <p class="mb-2">No banquet bookings found matching your criteria.</p>
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newBanquetModal">
                                        Record First Banquet Booking
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($banquets->hasPages())
                <div class="p-3 border-top">
                    {{ $banquets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: New Banquet Booking -->
<div class="modal fade" id="newBanquetModal" tabindex="-1" aria-labelledby="newBanquetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--color-burgundy-rose);">
                <h5 class="modal-title" id="newBanquetModalLabel">
                    <i class="fas fa-champagne-glasses me-2"></i> New Banquet & Event Reservation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.banquets.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4" style="background-color: var(--color-sandstone-base);">
                    <!-- Client Details -->
                    <h6 class="fw-bold mb-3" style="color: var(--color-burgundy-rose);">1. Host / Client Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Client / Host Name *</label>
                            <input type="text" name="customer_name" class="form-control" required placeholder="e.g. Rajeshbhai Patel">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Contact Phone *</label>
                            <input type="text" name="customer_phone" class="form-control" required placeholder="10-digit mobile number">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Email (Optional)</label>
                            <input type="email" name="customer_email" class="form-control" placeholder="client@example.com">
                        </div>
                    </div>

                    <!-- Event Specifications -->
                    <h6 class="fw-bold mb-3" style="color: var(--color-burgundy-rose);">2. Event Specifications</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Event Date *</label>
                            <input type="date" name="event_date" class="form-control" required value="{{ now()->addDays(3)->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Time Slot *</label>
                            <select name="slot" class="form-select" required>
                                <option value="morning">Morning Slot (09:00 AM - 03:00 PM)</option>
                                <option value="evening" selected>Evening Slot (06:00 PM - 11:30 PM)</option>
                                <option value="full_day">Full Day (All Day Access)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Event Type *</label>
                            <input type="text" name="event_type" class="form-control" required placeholder="e.g. Wedding Reception, Corporate AGM, Birthday">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Guest Count *</label>
                            <input type="number" name="guest_count" min="10" max="1500" value="150" class="form-control" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Catering & Dietary Package *</label>
                            <input type="text" name="catering_package" class="form-control" required value="Pure Vegetarian Gujarati Jain Thali + Welcome Drinks & Live Counter">
                        </div>
                    </div>

                    <!-- Offline Financials -->
                    <h6 class="fw-bold mb-3" style="color: var(--color-burgundy-rose);">3. Financials & Offline Payment Mode</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Total Agreed Amount (₹) *</label>
                            <input type="number" name="total_amount" min="0" step="0.01" class="form-control" required placeholder="e.g. 75000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Advance Paid at Desk (₹)</label>
                            <input type="number" name="advance_paid" min="0" step="0.01" class="form-control" value="0" placeholder="e.g. 25000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Offline Payment Mode *</label>
                            <select name="payment_mode" class="form-select" required>
                                <option value="Cash at Reception">Cash at Reception</option>
                                <option value="UPI / GPay">UPI / GPay (QR Scan)</option>
                                <option value="Card Swipe">Card Swipe Machine</option>
                                <option value="Pay at Checkout">Balance Due on Event Day</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Payment Status *</label>
                            <select name="payment_status" class="form-select" required>
                                <option value="pending">Pending (Advance not paid)</option>
                                <option value="partial" selected>Partial (Advance Received)</option>
                                <option value="paid">Full Paid</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Booking Status *</label>
                            <select name="status" class="form-select" required>
                                <option value="confirmed" selected>Confirmed (Locks Hall Slot)</option>
                                <option value="inquiry">Preliminary Inquiry / Tentative</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Special Setup & Catering Notes</label>
                            <textarea name="special_notes" rows="2" class="form-control" placeholder="Stage decor preferences, projector/mic requirements, Jain counter notes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white px-4" style="background-color: var(--color-burgundy-rose);">
                        <i class="fas fa-check me-1"></i> Save Banquet Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
