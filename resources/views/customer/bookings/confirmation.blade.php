@extends('layouts.app')

@section('title', 'Booking Confirmation #' . $booking->booking_reference . ' — Hotel Rose Palace')

@section('content')
<div class="container py-5">
    {{-- Non-printable action toolbar --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('customer.bookings.show', ['booking' => $booking->id]) }}" class="btn btn-outline-secondary btn-sm fw-semibold">
            <i class="fas fa-arrow-left me-1"></i> Back to Booking Details
        </a>
        <div class="d-flex gap-2">
            <button type="button" onclick="window.print();" class="btn btn-dark btn-sm fw-semibold shadow-sm">
                <i class="fas fa-print me-1"></i> Print / Save as PDF
            </button>
            <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                <i class="fas fa-suitcase me-1"></i> My Bookings
            </a>
        </div>
    </div>

    @php
        $checkIn = \Carbon\Carbon::parse($booking->check_in_date);
        $checkOut = \Carbon\Carbon::parse($booking->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        if ($nights < 1) $nights = 1;
    @endphp

    {{-- Official Printable Receipt Card --}}
    <div class="card shadow border-0 print-receipt-card" style="border-radius: 12px; overflow: hidden; max-width: 860px; margin: 0 auto; background: #fff;">
        {{-- Card Header with Crest --}}
        <div class="p-4 p-md-5 text-white" style="background: linear-gradient(135deg, #800020, #4a0013);">
            <div class="row align-items-center g-3">
                <div class="col-sm-8">
                    <div class="d-flex align-items-center mb-2">
                        <div class="p-2 rounded-circle bg-white text-dark me-3" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-crown fa-lg" style="color: #b88a44;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold" style="font-family: 'Playfair Display', Georgia, serif; letter-spacing: 0.5px;">Hotel Rose Palace</h3>
                            <small class="text-uppercase" style="letter-spacing: 1.5px; opacity: 0.85;">Luxury Stays &bull; Surat, Gujarat</small>
                        </div>
                    </div>
                    <small class="d-block" style="opacity: 0.9;">VIP Road, Vesu, Surat, Gujarat 395007 &bull; Tel: +91 88667 71900</small>
                </div>
                <div class="col-sm-4 text-sm-end">
                    <span class="badge bg-success fs-6 px-3 py-2 text-uppercase mb-2 d-inline-block">
                        <i class="fas fa-check-circle me-1"></i> Confirmed
                    </span>
                    <div class="small" style="opacity: 0.85;">Official Booking Voucher</div>
                </div>
            </div>
        </div>

        <div class="card-body p-4 p-md-5">
            {{-- Reference Strip --}}
            <div class="p-3 rounded mb-4 d-flex flex-wrap justify-content-between align-items-center" style="background-color: #fdf8f4; border: 1px solid #e8dbcd;">
                <div>
                    <span class="text-muted small text-uppercase fw-bold d-block">Booking Reference</span>
                    <span class="fs-4 fw-bold font-monospace text-dark">{{ $booking->booking_reference }}</span>
                </div>
                <div class="text-sm-end mt-2 mt-sm-0">
                    <span class="text-muted small text-uppercase fw-bold d-block">Booking Date</span>
                    <span class="fw-semibold text-dark">{{ $booking->created_at?->format('d M Y, h:i A') }}</span>
                </div>
            </div>

            {{-- Guest & Stay Details --}}
            <div class="row g-4 mb-4 pb-4 border-bottom">
                <div class="col-md-6">
                    <h6 class="text-uppercase fw-bold small text-muted mb-3">Guest Information</h6>
                    <p class="mb-1"><strong class="text-dark">{{ $booking->customer_name }}</strong></p>
                    <p class="mb-1 text-muted"><i class="fas fa-phone-alt me-2 text-secondary"></i> {{ $booking->customer_mobile }}</p>
                    @if ($booking->customer_email)
                        <p class="mb-0 text-muted"><i class="fas fa-envelope me-2 text-secondary"></i> {{ $booking->customer_email }}</p>
                    @endif
                </div>

                <div class="col-md-6">
                    <h6 class="text-uppercase fw-bold small text-muted mb-3">Reservation Summary</h6>
                    <p class="mb-1">
                        <strong>Room Type:</strong> {{ $booking->roomType?->name ?? 'Deluxe Room' }}
                    </p>
                    <p class="mb-1">
                        <strong>Rooms & Guests:</strong> {{ $booking->room_quantity }} Room(s), {{ $booking->total_guests }} Guest(s)
                    </p>
                    @if ($booking->allocations->isNotEmpty())
                        <p class="mb-0">
                            <strong>Allocated Room(s):</strong>
                            <span class="badge bg-light text-dark border">
                                Room {{ $booking->allocations->pluck('room.room_number')->filter()->implode(', Room ') ?: 'Assigned on arrival' }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>

            {{-- Schedule Timeline --}}
            <div class="row g-3 mb-4 pb-4 border-bottom text-center">
                <div class="col-sm-5 text-sm-start">
                    <span class="text-muted small text-uppercase fw-bold d-block">Check-In</span>
                    <div class="fs-5 fw-bold text-dark">{{ $checkIn->format('D, d M Y') }}</div>
                    <small class="text-muted">Standard Time: from 12:00 PM</small>
                </div>
                <div class="col-sm-2 my-auto text-center">
                    <span class="badge bg-light text-primary border px-3 py-2 fw-bold">
                        <i class="fas fa-moon me-1"></i> {{ $nights }} Night(s)
                    </span>
                </div>
                <div class="col-sm-5 text-sm-end">
                    <span class="text-muted small text-uppercase fw-bold d-block">Check-Out</span>
                    <div class="fs-5 fw-bold text-dark">{{ $checkOut->format('D, d M Y') }}</div>
                    <small class="text-muted">Standard Time: by 11:00 AM</small>
                </div>
            </div>

            {{-- Payment Details Breakdown --}}
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="text-uppercase fw-bold small text-muted mb-3">Payment Receipt (100% Paid Online)</h6>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Description</th>
                                <th class="text-end" style="width: 180px;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Room Tariff ({{ $booking->roomType?->name }} &times; {{ $nights }} Night{{ $nights > 1 ? 's' : '' }})</td>
                                <td class="text-end fw-semibold">₹{{ number_format($booking->base_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Goods & Services Tax (GST 12%)</td>
                                <td class="text-end fw-semibold">₹{{ number_format($booking->tax_amount, 2) }}</td>
                            </tr>
                            <tr class="table-light">
                                <td class="fw-bold fs-6">Total Paid Amount</td>
                                <td class="text-end fw-bold fs-5" style="color: #800020;">₹{{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Gateway Metadata --}}
                <div class="row g-2 mt-2 pt-2 text-muted small">
                    <div class="col-sm-6">
                        <i class="fas fa-receipt me-1"></i> Transaction ID: 
                        <strong class="text-dark font-monospace">{{ $booking->razorpay_payment_id ?? $payment?->razorpay_payment_id }}</strong>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <i class="fas fa-clock me-1"></i> Paid On: 
                        <strong class="text-dark">{{ $payment?->captured_at?->format('d M Y, h:i A') ?? $booking->updated_at?->format('d M Y, h:i A') }}</strong>
                    </div>
                </div>
            </div>

            {{-- Hotel Policies & Instructions --}}
            <div class="p-3 bg-light rounded text-muted small">
                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle text-primary me-1"></i> Important Information for Guests:</h6>
                <ul class="mb-0 ps-3">
                    <li>Government-issued photo identification (Aadhaar, Passport, Driving License, or Voter ID) is mandatory for all adult guests at the time of check-in (PAN card is not accepted).</li>
                    <li>Complimentary high-speed Wi-Fi, air conditioning, and daily housekeeping are included with your stay.</li>
                    <li>For any assistance or special requests prior to arrival, please call our 24/7 Front Desk at <strong>+91 88667 71900</strong> or WhatsApp <strong>+91 87991 29929</strong>.</li>
                </ul>
            </div>
        </div>

        {{-- Footer --}}
        <div class="card-footer bg-light py-3 px-4 text-center border-top">
            <small class="text-muted">
                Thank you for choosing Hotel Rose Palace Surat. We wish you a peaceful and luxurious stay.
            </small>
        </div>
    </div>
</div>

<style>
@media print {
    /* Hide everything except printable receipt */
    body {
        background: #fff !important;
        color: #000 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .hrp-header,
    .hrp-top-strip,
    #main-navbar,
    footer,
    .no-print,
    .hrp-mobile-dock,
    #mobileActionDock {
        display: none !important;
    }

    .print-receipt-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        max-width: 100% !important;
        margin: 0 !important;
    }
}
</style>
@endsection
