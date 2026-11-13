@extends('admin.layouts.app')

@section('title', 'Manage Bookings & Enquiries')
@section('page-title', 'Front Desk — Room Bookings & Enquiries')

@section('content')
<!-- Top Actions & Walk-In Trigger -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h5 class="mb-1" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
            <i class="fas fa-concierge-bell me-2"></i> Reservations & Front Desk
        </h5>
        <div class="text-muted small">Manage online enquiries, reception walk-ins, phone bookings, and offline billing.</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.calendar') }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-calendar-alt me-1"></i> Occupancy Calendar
        </a>
        <button type="button" class="btn btn-sm text-white px-3" data-bs-toggle="modal" data-bs-target="#walkInBookingModal" style="background-color: var(--color-burgundy-rose);">
            <i class="fas fa-user-plus me-1"></i> New Walk-In / Phone Booking
        </button>
    </div>
</div>

<!-- Filters and Search -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.enquiries.index') }}" id="filter-form">
            <div class="row g-2 align-items-center">
                <!-- Search -->
                <div class="col-md-3">
                    <input 
                        type="text" 
                        class="form-control form-control-sm" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search reference, name, phone..."
                    >
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="status">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Room Type Filter -->
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="room_type">
                        <option value="">All Room Types</option>
                        @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" {{ request('room_type') == $roomType->id ? 'selected' : '' }}>
                                {{ $roomType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div class="col-md-2">
                    <input 
                        type="date" 
                        class="form-control form-control-sm" 
                        name="date_from" 
                        value="{{ request('date_from') }}" 
                        title="Check-in From"
                    >
                </div>

                <!-- Date To -->
                <div class="col-md-2">
                    <input 
                        type="date" 
                        class="form-control form-control-sm" 
                        name="date_to" 
                        value="{{ request('date_to') }}" 
                        title="Check-in To"
                    >
                </div>

                <!-- Buttons -->
                <div class="col-md-1">
                    <button type="submit" class="btn btn-sm btn-outline-dark w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                <small class="text-muted">
                    Found <strong>{{ $enquiries->total() }}</strong> reservation record(s).
                </small>
                <div class="d-flex gap-2">
                    @if(request()->hasAny(['search', 'status', 'room_type', 'date_from', 'date_to']))
                        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-link text-muted p-0 me-3">
                            <i class="fas fa-times-circle me-1"></i> Clear Filters
                        </a>
                    @endif
                    <a href="{{ route('admin.enquiries.export', request()->all()) }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-file-csv me-1"></i> Export CSV
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table Card & Bulk Actions -->
<form method="POST" id="bulk-form">
    @csrf
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        @if($enquiries->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr style="border-bottom: 2px solid var(--color-border-subtle);">
                            <th width="40" class="ps-3">
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th class="py-3 text-uppercase small text-muted">Booking Ref</th>
                            <th class="py-3 text-uppercase small text-muted">Guest & ID</th>
                            <th class="py-3 text-uppercase small text-muted">Room / Cat</th>
                            <th class="py-3 text-uppercase small text-muted">Stay Dates</th>
                            <th class="py-3 text-uppercase small text-muted">Offline Payment</th>
                            <th class="py-3 text-uppercase small text-muted">Status</th>
                            <th class="pe-3 py-3 text-end text-uppercase small text-muted">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $enquiry)
                        <tr>
                            <td class="ps-3">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input enquiry-checkbox" 
                                    name="enquiry_ids[]" 
                                    value="{{ $enquiry->id }}"
                                >
                            </td>
                            <td>
                                <strong class="d-block" style="color: var(--color-burgundy-rose);">{{ $enquiry->reference_id }}</strong>
                                <span class="badge bg-light text-secondary border" style="font-size: 10px;">
                                    {{ strtoupper($enquiry->booking_type ?? 'Web') }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $enquiry->customer_name }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-phone-alt me-1" style="font-size: 10px;"></i> {{ $enquiry->customer_phone }}
                                </div>
                                @if($enquiry->id_proof_number)
                                    <div class="small text-muted" style="font-size: 10px;">
                                        <i class="fas fa-id-card me-1"></i> {{ $enquiry->id_proof_type }}: {{ $enquiry->id_proof_number }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($enquiry->room)
                                    <span class="badge bg-light text-dark border fw-bold" style="font-size: 11px;">
                                        Room {{ $enquiry->room->room_number }}
                                    </span>
                                    <div class="small text-muted" style="font-size: 11px;">{{ $enquiry->roomType->name ?? 'Standard' }}</div>
                                @else
                                    <span class="small text-muted fst-italic">Room Unassigned</span>
                                    <div class="small text-dark fw-semibold">{{ $enquiry->roomType->name ?? 'Any' }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">
                                    {{ $enquiry->check_in_date ? $enquiry->check_in_date->format('d M') : 'N/A' }} &rarr; {{ $enquiry->check_out_date ? $enquiry->check_out_date->format('d M') : 'N/A' }}
                                </div>
                                <small class="text-muted">{{ $enquiry->nights }} night(s) &bull; {{ $enquiry->num_adults }}A, {{ $enquiry->num_children }}C</small>
                            </td>
                            <td>
                                @php
                                    $tariff = (float)$enquiry->total_tariff;
                                    $paid = (float)$enquiry->paid_amount;
                                    $bal = $enquiry->balance_due;
                                @endphp
                                @if($tariff > 0)
                                    <div class="fw-bold text-dark">₹{{ number_format($tariff, 0) }}</div>
                                    <div class="small text-success">
                                        Paid: ₹{{ number_format($paid, 0) }} ({{ $enquiry->payment_mode ?? 'Offline' }})
                                    </div>
                                    @if($bal > 0)
                                        <div class="small text-danger fw-semibold">Due: ₹{{ number_format($bal, 0) }}</div>
                                    @endif
                                @else
                                    <span class="small text-muted">Tariff Pending</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusBadge = match($enquiry->status) {
                                        'checked_in' => 'bg-success text-white',
                                        'checked_out' => 'bg-secondary text-white',
                                        'booking_confirmed', 'confirmed' => 'bg-primary text-white',
                                        'availability_confirmed' => 'bg-warning text-dark',
                                        'contacted' => 'bg-info text-dark',
                                        'pending' => 'bg-warning-subtle text-warning-emphasis border border-warning',
                                        'cancelled' => 'bg-danger text-white',
                                        default => 'bg-light text-dark border'
                                    };
                                @endphp
                                <span class="badge {{ $statusBadge }}" style="font-size: 11px;">
                                    {{ $statuses[$enquiry->status] ?? ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                                </span>
                            </td>
                            <td class="pe-3 text-end">
                                <div class="d-inline-flex align-items-center gap-1">
                                    <!-- 1-Click Check In Button -->
                                    @if($enquiry->status !== 'checked_in' && $enquiry->status !== 'checked_out' && $enquiry->status !== 'cancelled')
                                        <form action="{{ route('admin.enquiries.check-in', $enquiry) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-pms-checkin" title="Check-In Guest Now">
                                                <i class="fas fa-key me-1"></i> Check In
                                            </button>
                                        </form>
                                    @elseif($enquiry->status === 'checked_in')
                                        <!-- 1-Click Check Out Button -->
                                        <form action="{{ route('admin.enquiries.check-out', $enquiry) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-pms-checkout" title="Check-Out & Flag Room Dirty">
                                                <i class="fas fa-sign-out-alt me-1"></i> Check Out
                                            </button>
                                        </form>
                                    @endif

                                    <!-- WhatsApp Concierge Dropdown -->
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $enquiry->customer_phone);
                                        if (strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;
                                        
                                        $checkInText = $enquiry->check_in_date ? $enquiry->check_in_date->format('d M, Y') : '';
                                        $checkOutText = $enquiry->check_out_date ? $enquiry->check_out_date->format('d M, Y') : '';
                                        $roomNum = $enquiry->room->room_number ?? 'Allocated on arrival';

                                        // Pre-filled Voucher message
                                        $waVoucher = "Namaste {$enquiry->customer_name}, your booking at Hotel Rose Palace Surat is confirmed!\n\n📋 Reference: {$enquiry->reference_id}\n🛏️ Room: {$roomNum} (" . ($enquiry->roomType->name ?? 'Standard') . ")\n📅 Check-In: {$checkInText} (12:00 PM)\n📅 Check-Out: {$checkOutText} (11:00 AM)\n📍 Location Map: https://maps.app.goo.gl/HotelRosePalaceVesu\n\nDirect Reception: +91 98765 43210. We look forward to hosting you!";
                                        
                                        // Pre-filled Checkout Thank You message
                                        $waCheckout = "Namaste {$enquiry->customer_name}, thank you for staying with us at Hotel Rose Palace Surat! We hope you enjoyed our hospitality and pure vegetarian dining.\n\nCould you take 30 seconds to share your review on Google? It means the world to our team:\n⭐ https://g.page/r/HotelRosePalaceSurat/review\n\nHave a safe journey!";
                                    @endphp

                                    <div class="dropdown d-inline-block">
                                        <button class="btn-whatsapp-pms dropdown-toggle py-1 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="WhatsApp Concierge">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border p-2" style="min-width: 260px; font-size: 12px;">
                                            <li><h6 class="dropdown-header px-2 py-1">WhatsApp Concierge</h6></li>
                                            <li>
                                                <a class="dropdown-item rounded py-2 d-flex align-items-center gap-2" href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waVoucher) }}" target="_blank">
                                                    <i class="fas fa-ticket-alt text-success"></i>
                                                    <div>
                                                        <div class="fw-bold">Send Booking Voucher</div>
                                                        <small class="text-muted">Dates, room & Vesu map link</small>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item rounded py-2 d-flex align-items-center gap-2" href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waCheckout) }}" target="_blank">
                                                    <i class="fas fa-star text-warning"></i>
                                                    <div>
                                                        <div class="fw-bold">Send Checkout & Review</div>
                                                        <small class="text-muted">Thank you note & Google Review</small>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Print GST Receipt Button -->
                                    <a href="{{ route('admin.enquiries.invoice', $enquiry) }}" target="_blank" class="btn btn-sm btn-outline-secondary p-1 px-2" title="Print GST Invoice / Receipt">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    <!-- Details View -->
                                    <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="btn btn-sm btn-outline-dark p-1 px-2" title="View & Edit Booking">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Bulk Update Toolbar & Pagination -->
            <div class="p-3 border-top bg-light d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="small text-muted">Bulk Actions:</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="bulkAction('status', 'booking_confirmed')">
                        Confirm Selected
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="bulkAction('status', 'checked_in')">
                        Check In Selected
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkAction('delete')">
                        Delete Selected
                    </button>
                </div>

                <div>
                    {{ $enquiries->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-concierge-bell fa-3x mb-3 text-muted" style="opacity: 0.3;"></i>
                <p class="mb-2">No enquiries or reservations found matching your criteria.</p>
                <button type="button" class="btn btn-sm text-white px-3" data-bs-toggle="modal" data-bs-target="#walkInBookingModal" style="background-color: var(--color-burgundy-rose);">
                    <i class="fas fa-plus me-1"></i> Create First Walk-In Booking
                </button>
            </div>
        @endif
    </div>
</form>

<!-- Modal: New Walk-In / Phone Reservation -->
<div class="modal fade" id="walkInBookingModal" tabindex="-1" aria-labelledby="walkInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--color-burgundy-rose);">
                <h5 class="modal-title" id="walkInModalLabel">
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
                            <select name="room_id" id="modal_room_id" class="form-select" required onchange="calculateTariff()">
                                <option value="">-- Select Available Room --</option>
                                @foreach($rooms as $r)
                                    <option value="{{ $r->id }}" 
                                            data-price="{{ $r->current_price }}" 
                                            data-type="{{ $r->room_type_id }}"
                                            {{ ($r->housekeeping_status ?? 'clean') !== 'clean' ? 'style=color:#c0392b;' : '' }}>
                                        Room {{ $r->room_number }} (Floor {{ $r->floor }} &bull; {{ $r->roomType->name ?? 'Standard' }} &bull; ₹{{ number_format($r->current_price) }}/nt) [{{ strtoupper($r->housekeeping_status ?? 'clean') }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Check-In Date *</label>
                            <input type="date" name="check_in_date" id="modal_check_in" class="form-control" required value="{{ now()->format('Y-m-d') }}" onchange="calculateTariff()">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Check-Out Date *</label>
                            <input type="date" name="check_out_date" id="modal_check_out" class="form-control" required value="{{ now()->addDay()->format('Y-m-d') }}" onchange="calculateTariff()">
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
                            <label class="form-label small fw-bold">Special Requests / Dietary Notes</label>
                            <input type="text" name="special_requests" class="form-control" placeholder="Early check-in, Jain breakfast, high floor...">
                        </div>
                    </div>

                    <!-- 3. Offline Payment Mode & Action -->
                    <h6 class="fw-bold mb-3" style="color: var(--color-burgundy-rose);">3. Offline Payment & Instant Action</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Total Base Tariff (₹) *</label>
                            <input type="number" name="total_tariff" id="modal_total_tariff" class="form-control fw-bold" required min="0" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Amount Paid at Desk (₹)</label>
                            <input type="number" name="paid_amount" id="modal_paid_amount" class="form-control" min="0" step="0.01" value="0">
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
                                <option value="check_in" selected>Instant Check-In (Hands Over Key Now)</option>
                                <option value="reserve">Reserve Room (Future Arrival)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Reception Internal Note</label>
                            <textarea name="internal_notes" rows="2" class="form-control" placeholder="Luggage stored, VIP guest, key card #12 issued..."></textarea>
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
// Select all checkboxes
document.getElementById('select-all')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.enquiry-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Bulk actions
function bulkAction(action, value = null) {
    const checkboxes = document.querySelectorAll('.enquiry-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Please select at least one enquiry');
        return false;
    }

    const form = document.getElementById('bulk-form');
    if (action === 'status') {
        if (confirm(`Update ${checkboxes.length} booking(s) to status: ${value}?`)) {
            form.action = '{{ route("admin.enquiries.bulk-status") }}';
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = value;
            form.appendChild(statusInput);
            form.submit();
        }
    } else if (action === 'delete') {
        if (confirm(`Are you sure you want to delete ${checkboxes.length} reservation(s)?`)) {
            form.action = '{{ route("admin.enquiries.bulk-delete") }}';
            form.submit();
        }
    }
    return false;
}

// Auto-calculate walk-in modal tariff
function calculateTariff() {
    const roomSelect = document.getElementById('modal_room_id');
    const checkInInput = document.getElementById('modal_check_in');
    const checkOutInput = document.getElementById('modal_check_out');
    const totalTariffInput = document.getElementById('modal_total_tariff');

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
