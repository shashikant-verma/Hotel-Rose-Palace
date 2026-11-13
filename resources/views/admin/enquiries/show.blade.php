@extends('admin.layouts.app')

@section('title', 'Reservation Details - ' . $enquiry->reference_id)
@section('page-title', 'Reservation #' . $enquiry->reference_id)

@section('content')
<div class="row g-4">
    <!-- Main Details Column -->
    <div class="col-lg-8">
        <!-- Guest & Room Information Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-5 fw-bold" style="color: var(--color-burgundy-rose); font-family: var(--font-heading);">
                        <i class="fas fa-file-invoice me-2"></i> {{ $enquiry->reference_id }}
                    </span>
                    <span class="badge bg-light text-secondary border">
                        {{ strtoupper($enquiry->booking_type ?? 'Web Enquiry') }}
                    </span>
                </div>
                <div>
                    @php
                        $statusBadge = match($enquiry->status) {
                            'checked_in' => 'bg-success text-white',
                            'checked_out' => 'bg-secondary text-white',
                            'booking_confirmed', 'confirmed' => 'bg-primary text-white',
                            'availability_confirmed' => 'bg-warning text-dark',
                            'contacted' => 'bg-info text-dark',
                            'pending' => 'bg-warning text-dark',
                            'cancelled' => 'bg-danger text-white',
                            default => 'bg-light text-dark border'
                        };
                    @endphp
                    <span class="badge {{ $statusBadge }} px-3 py-2 fs-6">
                        {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                    </span>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Guest Information -->
                <h6 class="text-uppercase small fw-bold mb-3" style="color: var(--color-brass-gold); letter-spacing: 1px;">
                    1. Guest & Identity Verification
                </h6>
                <div class="row g-3 mb-4 p-3 rounded-3" style="background-color: var(--color-champagne);">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Full Name</small>
                        <strong class="fs-6 text-dark">{{ $enquiry->customer_name }}</strong>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Contact Phone</small>
                        <a href="tel:{{ $enquiry->customer_phone }}" class="fw-semibold text-dark text-decoration-none">
                            <i class="fas fa-phone-alt me-1 text-success"></i> {{ $enquiry->customer_phone }}
                        </a>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Email Address</small>
                        <span class="text-dark">{{ $enquiry->customer_email ?? 'Not provided' }}</span>
                    </div>
                    <div class="col-md-6 mt-3 pt-2 border-top">
                        <small class="text-muted d-block">ID Proof Document</small>
                        <span class="fw-semibold text-dark">
                            <i class="fas fa-id-card me-1 text-primary"></i> {{ $enquiry->id_proof_type ?? 'Aadhaar Card' }}
                        </span>
                    </div>
                    <div class="col-md-6 mt-3 pt-2 border-top">
                        <small class="text-muted d-block">ID Document Number</small>
                        <span class="fw-bold text-dark font-monospace">
                            {{ $enquiry->id_proof_number ?? 'Verified at Reception' }}
                        </span>
                    </div>
                </div>

                <!-- Stay & Room Information -->
                <h6 class="text-uppercase small fw-bold mb-3" style="color: var(--color-brass-gold); letter-spacing: 1px;">
                    2. Stay Dates & Room Allocation
                </h6>
                <div class="row g-3 mb-4 p-3 rounded-3" style="background-color: var(--color-champagne);">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Assigned Room</small>
                        @if($enquiry->room)
                            <strong class="fs-5" style="color: var(--color-burgundy-rose);">
                                Room {{ $enquiry->room->room_number }}
                            </strong>
                            <span class="small text-muted d-block">Floor {{ $enquiry->room->floor }}</span>
                        @else
                            <span class="text-danger fw-semibold">No room assigned yet</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Room Category</small>
                        <strong class="text-dark">{{ $enquiry->roomType->name ?? 'Standard' }}</strong>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Occupancy</small>
                        <span class="text-dark fw-semibold">
                            {{ $enquiry->num_adults }} Adult(s), {{ $enquiry->num_children }} Child
                        </span>
                    </div>
                    <div class="col-md-4 mt-3 pt-2 border-top">
                        <small class="text-muted d-block">Check-In</small>
                        <strong class="text-dark">{{ $enquiry->check_in_date ? $enquiry->check_in_date->format('d M, Y (D)') : 'N/A' }}</strong>
                        <small class="text-muted d-block">Standard: 12:00 PM</small>
                    </div>
                    <div class="col-md-4 mt-3 pt-2 border-top">
                        <small class="text-muted d-block">Check-Out</small>
                        <strong class="text-dark">{{ $enquiry->check_out_date ? $enquiry->check_out_date->format('d M, Y (D)') : 'N/A' }}</strong>
                        <small class="text-muted d-block">Standard: 11:00 AM</small>
                    </div>
                    <div class="col-md-4 mt-3 pt-2 border-top">
                        <small class="text-muted d-block">Total Duration</small>
                        <span class="badge bg-secondary fs-6">{{ $enquiry->nights }} Night(s)</span>
                    </div>
                </div>

                @if($enquiry->special_requests)
                    <h6 class="text-uppercase small fw-bold mb-2" style="color: var(--color-brass-gold); letter-spacing: 1px;">
                        Special Guest Requests
                    </h6>
                    <div class="p-3 rounded-3 mb-4 bg-light border">
                        <p class="mb-0 text-dark">{{ $enquiry->special_requests }}</p>
                    </div>
                @endif

                <!-- Offline Billing Breakdown -->
                <h6 class="text-uppercase small fw-bold mb-3" style="color: var(--color-brass-gold); letter-spacing: 1px;">
                    3. Offline Settlement & GST Accounting (Zero Online Gateway)
                </h6>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center">SAC Code</th>
                                <th class="text-center">Rate / Night</th>
                                <th class="text-end">Taxable Tariff</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Room Stay &bull; {{ $enquiry->roomType->name ?? 'Deluxe Room' }}
                                    <small class="text-muted d-block">Stay for {{ $enquiry->nights }} night(s)</small>
                                </td>
                                <td class="text-center">996311</td>
                                <td class="text-center">₹{{ number_format((float)$enquiry->total_tariff / max(1, $enquiry->nights), 2) }}</td>
                                <td class="text-end fw-bold">₹{{ number_format((float)$enquiry->total_tariff, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-muted">CGST (6%):</td>
                                <td class="text-end">₹{{ number_format($enquiry->cgst, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-muted">SGST (6%):</td>
                                <td class="text-end">₹{{ number_format($enquiry->sgst, 2) }}</td>
                            </tr>
                            <tr class="table-active">
                                <td colspan="3" class="text-end fw-bold fs-6">Grand Total (Inclusive of 12% GST):</td>
                                <td class="text-end fw-bold fs-6" style="color: var(--color-burgundy-rose);">₹{{ number_format($enquiry->grand_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-success fw-semibold">
                                    Offline Amount Received (via {{ $enquiry->payment_mode ?? 'Cash at Reception' }}):
                                </td>
                                <td class="text-end text-success fw-bold">₹{{ number_format((float)$enquiry->paid_amount, 2) }}</td>
                            </tr>
                            <tr style="background-color: {{ $enquiry->balance_due > 0 ? '#fcf0f0' : '#f0fcf4' }};">
                                <td colspan="3" class="text-end fw-bold {{ $enquiry->balance_due > 0 ? 'text-danger' : 'text-success' }}">
                                    Balance Remaining:
                                </td>
                                <td class="text-end fw-bold fs-6 {{ $enquiry->balance_due > 0 ? 'text-danger' : 'text-success' }}">
                                    ₹{{ number_format($enquiry->balance_due, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Internal Notes -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-sticky-note me-2"></i> Front Desk Internal Notes
                </h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.enquiries.update-notes', $enquiry) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <textarea name="internal_notes" rows="3" class="form-control" placeholder="Internal reception notes, guest preferences, luggage tag, early checkout request...">{{ old('internal_notes', $enquiry->internal_notes) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-sm text-white px-3" style="background-color: var(--color-burgundy-rose);">
                        <i class="fas fa-save me-1"></i> Save Internal Notes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Front Desk Action Dock -->
    <div class="col-lg-4">
        <!-- PMS 1-Click Operations -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header text-white py-3" style="background-color: var(--color-burgundy-rose);">
                <h6 class="mb-0 fw-bold"><i class="fas fa-bolt me-2"></i> Reception Quick Actions</h6>
            </div>
            <div class="card-body p-3 d-grid gap-2">
                <!-- Check-In Action -->
                @if($enquiry->status !== 'checked_in' && $enquiry->status !== 'checked_out' && $enquiry->status !== 'cancelled')
                    <form action="{{ route('admin.enquiries.check-in', $enquiry) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                            <i class="fas fa-key me-2"></i> 1-Click Check-In Guest
                        </button>
                    </form>
                @endif

                <!-- Check-Out Action -->
                @if($enquiry->status === 'checked_in')
                    <form action="{{ route('admin.enquiries.check-out', $enquiry) }}" method="POST" onsubmit="return confirm('Check-out guest and mark room as dirty?');">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold" style="background-color: var(--color-burgundy-rose); border-color: var(--color-burgundy-rose);">
                            <i class="fas fa-sign-out-alt me-2"></i> 1-Click Check-Out & Mark Dirty
                        </button>
                    </form>
                @endif

                <!-- Print GST Receipt -->
                <a href="{{ route('admin.enquiries.invoice', $enquiry) }}" target="_blank" class="btn btn-outline-dark w-100 py-2 fw-semibold">
                    <i class="fas fa-print me-2"></i> Print Tax Receipt (A4 / Thermal)
                </a>

                <hr class="my-2">

                <!-- WhatsApp Concierge Buttons -->
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $enquiry->customer_phone);
                    if (strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;

                    $checkInText = $enquiry->check_in_date ? $enquiry->check_in_date->format('d M, Y') : '';
                    $checkOutText = $enquiry->check_out_date ? $enquiry->check_out_date->format('d M, Y') : '';
                    $roomNum = $enquiry->room->room_number ?? 'Allocated on arrival';

                    $waVoucher = "Namaste {$enquiry->customer_name}, your booking at Hotel Rose Palace Surat is confirmed!\n\n📋 Reference: {$enquiry->reference_id}\n🛏️ Room: {$roomNum} (" . ($enquiry->roomType->name ?? 'Standard') . ")\n📅 Check-In: {$checkInText} (12:00 PM)\n📅 Check-Out: {$checkOutText} (11:00 AM)\n📍 Location Map: https://maps.app.goo.gl/HotelRosePalaceVesu\n\nDirect Reception: +91 98765 43210. We look forward to hosting you!";
                    
                    $waCheckout = "Namaste {$enquiry->customer_name}, thank you for staying with us at Hotel Rose Palace Surat! We hope you enjoyed our hospitality and pure vegetarian dining.\n\nCould you take 30 seconds to share your review on Google? It means the world to our team:\n⭐ https://g.page/r/HotelRosePalaceSurat/review\n\nHave a safe journey!";
                @endphp

                <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waVoucher) }}" target="_blank" class="btn-whatsapp-pms justify-content-center py-2">
                    <i class="fab fa-whatsapp fa-lg"></i> Send Booking Voucher
                </a>

                <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($waCheckout) }}" target="_blank" class="btn btn-outline-success w-100 py-2 fw-semibold">
                    <i class="fas fa-star text-warning me-2"></i> Send Checkout & Review Link
                </a>
            </div>
        </div>

        <!-- Status Management Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-tasks me-2"></i> Update Status
                </h6>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('admin.enquiries.update-status', $enquiry) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select class="form-select" name="status" required>
                            @foreach(App\Models\Enquiry::getStatuses() as $val => $lbl)
                                <option value="{{ $val }}" {{ $enquiry->status === $val ? 'selected' : '' }}>
                                    {{ $lbl }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Timeline Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold" style="color: var(--color-burgundy-rose);">
                    <i class="fas fa-clock me-2"></i> Activity Timeline
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="timeline ps-2 border-start border-2" style="border-color: var(--color-border-subtle) !important;">
                    <div class="mb-3 ps-3">
                        <small class="text-muted d-block">Created On</small>
                        <strong class="text-dark">{{ $enquiry->created_at->format('d M, Y H:i') }}</strong>
                    </div>
                    @if($enquiry->confirmed_at)
                        <div class="mb-3 ps-3">
                            <small class="text-muted d-block">Confirmed On</small>
                            <strong class="text-success">{{ $enquiry->confirmed_at->format('d M, Y H:i') }}</strong>
                        </div>
                    @endif
                    @if($enquiry->checked_in_at)
                        <div class="mb-3 ps-3">
                            <small class="text-muted d-block">Checked In On</small>
                            <strong class="text-primary">{{ $enquiry->checked_in_at->format('d M, Y H:i') }}</strong>
                        </div>
                    @endif
                    @if($enquiry->checked_out_at)
                        <div class="mb-3 ps-3">
                            <small class="text-muted d-block">Checked Out On</small>
                            <strong class="text-secondary">{{ $enquiry->checked_out_at->format('d M, Y H:i') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary w-100">
            &larr; Back to Enquiries
        </a>
    </div>
</div>
@endsection
