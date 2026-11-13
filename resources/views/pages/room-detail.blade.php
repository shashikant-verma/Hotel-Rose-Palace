@extends('layouts.app')

@section('title', $roomType->name . ' — Hotel Rose Palace Surat')
@section('meta_description', 'Experience ' . $roomType->name . ' at Hotel Rose Palace, Surat. Featuring premium bedding, marble bathroom, high-speed Wi-Fi, and 24/7 room service on VIP Road, Vesu.')

@section('content')

{{-- Breadcrumb Strip --}}
<div style="background-color: var(--hrp-tint); border-bottom: 1px solid var(--hrp-border); padding: 14px 0;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0" style="font-size: 13px;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rooms') }}">Rooms & Suites</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: var(--hrp-burgundy); font-weight: 600;">{{ $roomType->name }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Main Room Details Section --}}
<section style="background-color: var(--hrp-canvas); padding: 50px 0 80px;">
    <div class="container">
        <div class="row g-5">
            
            {{-- Left Column: Gallery & In-Depth Details --}}
            <div class="col-lg-8 col-md-12">
                
                {{-- Main Gallery Viewer with Thumbnails --}}
                <div class="card p-0 overflow-hidden mb-4" style="border: 1px solid var(--hrp-border);">
                    @php
                        $realRoomPhotos = [
                            asset('images/hotel/room-deluxe.jpg'),
                            asset('images/hotel/hero-1.jpg'),
                            asset('images/hotel/hero-2.jpg'),
                            asset('images/hotel/room-executive.jpg'),
                            asset('images/hotel/room-suite.jpg'),
                            asset('images/hotel/gallery-4.jpg'),
                        ];
                        $initialPhoto = $realRoomPhotos[0];
                    @endphp
                    <div style="position: relative; height: 420px; overflow: hidden; background: var(--hrp-plum);">
                        <img id="mainGalleryViewer" src="{{ $initialPhoto }}" alt="{{ $roomType->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: all 0.3s ease;" class="hrp-lightbox-trigger" onclick="openLightbox(this.src)">
                        <button type="button" onclick="openLightbox(document.getElementById('mainGalleryViewer').src)" class="btn btn-secondary btn-sm" style="position: absolute; bottom: 16px; right: 16px; background: rgba(247,241,232,0.9); backdrop-filter: blur(8px);">
                            <i class="fas fa-expand"></i> Fullscreen View
                        </button>
                    </div>

                    {{-- Clickable Thumbnails Row --}}
                    <div class="p-3 d-flex gap-2 overflow-auto" style="background: var(--hrp-surface); border-top: 1px solid var(--hrp-border);">
                        @foreach($realRoomPhotos as $idx => $photo)
                        <img src="{{ $photo }}" alt="Thumbnail {{ $idx + 1 }}" style="width: 90px; height: 60px; object-fit: cover; border-radius: 6px; cursor: pointer; border: 2px solid {{ $idx === 0 ? 'var(--hrp-gold)' : 'transparent' }}; opacity: {{ $idx === 0 ? '1' : '0.75' }}; transition: all 0.2s ease;" onclick="switchMainPhoto('{{ $photo }}', this)" class="thumb-selector">
                        @endforeach
                    </div>
                </div>

                {{-- Key Room Meta Header --}}
                <div class="card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <span class="badge" style="background: rgba(184,138,68,0.15); color: #B88A44; border: 1px solid rgba(184,138,68,0.3); font-size: 11px; text-transform: uppercase;">
                                Premier Accommodations
                            </span>
                            <h1 style="color: var(--hrp-plum); font-size: 32px; margin: 4px 0 0;">{{ $roomType->name }}</h1>
                        </div>
                        <div class="text-end">
                            <span style="font-size: 12px; color: var(--hrp-mauve); text-transform: uppercase; display: block;">Starting from</span>
                            <span style="font-size: 32px; font-weight: 700; color: var(--hrp-burgundy);">₹{{ number_format($roomType->base_price, 0) }}</span>
                            <span style="font-size: 13px; color: var(--hrp-mauve);">/night</span>
                        </div>
                    </div>

                    {{-- Room Specs Ribbon --}}
                    <div class="row g-2 p-3 rounded mb-4" style="background: var(--hrp-tint); border: 1px solid var(--hrp-border);">
                        <div class="col-4 text-center">
                            <span style="font-size: 11px; color: var(--hrp-mauve); text-transform: uppercase; display: block;">Occupancy</span>
                            <strong style="color: var(--hrp-plum); font-size: 16px;">{{ $roomType->max_occupancy }} Guests</strong>
                        </div>
                        <div class="col-4 text-center" style="border-left: 1px solid var(--hrp-border); border-right: 1px solid var(--hrp-border);">
                            <span style="font-size: 11px; color: var(--hrp-mauve); text-transform: uppercase; display: block;">Dimensions</span>
                            <strong style="color: var(--hrp-plum); font-size: 16px;">350–550 sq.ft</strong>
                        </div>
                        <div class="col-4 text-center">
                            <span style="font-size: 11px; color: var(--hrp-mauve); text-transform: uppercase; display: block;">Available Inventory</span>
                            <strong style="color: var(--hrp-burgundy); font-size: 16px;">{{ count($rooms) > 0 ? count($rooms) . ' Rooms' : 'Available' }}</strong>
                        </div>
                    </div>

                    {{-- Description --}}
                    <h5 style="color: var(--hrp-plum); margin-bottom: 10px;">About This Sanctuary</h5>
                    <p style="color: var(--hrp-mauve); line-height: 1.8; margin-bottom: 24px; font-size: 15px;">
                        {{ $roomType->description ?: 'Designed for distinguished travelers, this room blends generous space with modern comforts. Relax on an orthopedic king bed with custom linens, stay connected with ultra-fast Wi-Fi, and refresh in an Italian marble en-suite bathroom with luxury toiletries.' }}
                    </p>

                    {{-- Room Amenities Checklist --}}
                    <h5 style="color: var(--hrp-plum); margin-bottom: 12px;">In-Room Amenities & Features</h5>
                    <div class="row g-3">
                        @if($roomType->amenities && $roomType->amenities->count() > 0)
                            @foreach($roomType->amenities as $am)
                            <div class="col-md-6 d-flex align-items-center gap-2" style="font-size: 14px; color: var(--hrp-plum);">
                                <i class="fas fa-check-circle text-gold"></i>
                                <span>{{ $am->name }}</span>
                            </div>
                            @endforeach
                        @else
                            <div class="col-md-6 d-flex align-items-center gap-2" style="font-size: 14px; color: var(--hrp-plum);">
                                <i class="fas fa-check-circle text-gold"></i>
                                <span>Plush Orthopedic Bedding</span>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2" style="font-size: 14px; color: var(--hrp-plum);">
                                <i class="fas fa-check-circle text-gold"></i>
                                <span>High-Speed 500 Mbps Wi-Fi</span>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2" style="font-size: 14px; color: var(--hrp-plum);">
                                <i class="fas fa-check-circle text-gold"></i>
                                <span>Silent Inverter Climate Control</span>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2" style="font-size: 14px; color: var(--hrp-plum);">
                                <i class="fas fa-check-circle text-gold"></i>
                                <span>Italian Marble Rain Shower</span>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2" style="font-size: 14px; color: var(--hrp-plum);">
                                <i class="fas fa-check-circle text-gold"></i>
                                <span>Complimentary Pure Veg Breakfast</span>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2" style="font-size: 14px; color: var(--hrp-plum);">
                                <i class="fas fa-check-circle text-gold"></i>
                                <span>55" 4K Smart TV with OTT Support</span>
                            </div>
                        @endif
                    </div>

                </div>

            </div>

            {{-- Right Column: Sticky Live Price Calculator & Instant Reservation Card --}}
            <div class="col-lg-4 col-md-12">
                <div style="position: sticky; top: 90px;">
                    
                    <div class="card p-4" style="border: 1.5px solid var(--hrp-gold); box-shadow: var(--shadow-lg);">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px solid var(--hrp-border);">
                            <div>
                                <span class="hrp-guarantee-badge">Best Rate Guaranteed</span>
                                <h4 style="margin: 4px 0 0; color: var(--hrp-plum); font-size: 20px;">Reserve This Room</h4>
                            </div>
                            <i class="fas fa-shield-alt text-gold fs-3"></i>
                        </div>

                        {{-- Direct Booking Form --}}
                        <form method="POST" action="{{ route('enquiry.store') }}" id="roomDetailBookingForm">
                            @csrf
                            <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">

                            <div class="mb-3">
                                <label class="hrp-field-label">Check-in Date *</label>
                                <input type="date" id="rdCheckIn" name="check_in_date" class="hrp-field-input" required onchange="calculateDetailPrice()">
                            </div>

                            <div class="mb-3">
                                <label class="hrp-field-label">Check-out Date *</label>
                                <input type="date" id="rdCheckOut" name="check_out_date" class="hrp-field-input" required onchange="calculateDetailPrice()">
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="hrp-field-label">Adults</label>
                                    <select id="rdAdults" name="num_adults" class="hrp-field-input" onchange="calculateDetailPrice()">
                                        <option value="1">1 Adult</option>
                                        <option value="2" selected>2 Adults</option>
                                        <option value="3">3 Adults</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="hrp-field-label">Children</label>
                                    <select id="rdChildren" name="num_children" class="hrp-field-input">
                                        <option value="0" selected>0 Children</option>
                                        <option value="1">1 Child</option>
                                        <option value="2">2 Children</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Live Price Summary --}}
                            <div class="hrp-calc-summary-card mt-2 mb-3">
                                <div class="hrp-calc-row">
                                    <span id="rdNightsCount">1 Night Stay:</span>
                                    <span id="rdBasePrice" style="font-weight: 600; color: var(--hrp-plum);">₹{{ number_format($roomType->base_price, 0) }}</span>
                                </div>
                                <div class="hrp-calc-row">
                                    <span>Taxes (GST 12%):</span>
                                    <span id="rdGstPrice" style="font-weight: 600; color: var(--hrp-plum);">₹{{ number_format($roomType->base_price * 0.12, 0) }}</span>
                                </div>
                                <div class="hrp-calc-total-row">
                                    <span style="font-size: 16px;">Total Payable:</span>
                                    <span id="rdTotalPrice" style="color: var(--hrp-burgundy);">₹{{ number_format($roomType->base_price * 1.12, 0) }}</span>
                                </div>
                            </div>

                            <div class="mb-2">
                                <input type="text" id="rdName" name="customer_name" class="hrp-field-input" placeholder="Your Full Name *" required>
                            </div>

                            <div class="mb-3">
                                <input type="tel" id="rdPhone" name="customer_phone" class="hrp-field-input" placeholder="Phone / WhatsApp Number *" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-check-circle"></i> Confirm Direct Reservation
                            </button>

                            <button type="button" onclick="bookRoomDetailWhatsApp()" class="btn btn-whatsapp w-100">
                                <i class="fab fa-whatsapp"></i> Book via WhatsApp
                            </button>

                        </form>

                        <div class="text-center mt-3" style="font-size: 11.5px; color: var(--hrp-mauve);">
                            <i class="fas fa-lock text-gold me-1"></i> No advance booking fees. Pay on arrival.
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@section('extra_js')
<script>
const roomBaseRate = {{ (float)$roomType->base_price }};

function switchMainPhoto(src, thumb) {
    const main = document.getElementById('mainGalleryViewer');
    if (main) main.src = src;

    document.querySelectorAll('.thumb-selector').forEach(t => {
        t.style.borderColor = 'transparent';
        t.style.opacity = '0.75';
    });
    thumb.style.borderColor = 'var(--hrp-gold)';
    thumb.style.opacity = '1';
}

function calculateDetailPrice() {
    const checkIn = document.getElementById('rdCheckIn')?.value;
    const checkOut = document.getElementById('rdCheckOut')?.value;
    if (!checkIn || !checkOut) return;

    const dIn = new Date(checkIn);
    const dOut = new Date(checkOut);
    let nights = Math.max(1, Math.round((dOut - dIn) / (1000 * 60 * 60 * 24)));
    if (isNaN(nights) || nights < 1) nights = 1;

    const base = roomBaseRate * nights;
    const gst = Math.round(base * 0.12);
    const total = base + gst;

    document.getElementById('rdNightsCount').textContent = `${nights} ${nights === 1 ? 'Night' : 'Nights'} Stay:`;
    document.getElementById('rdBasePrice').textContent = '₹' + base.toLocaleString('en-IN');
    document.getElementById('rdGstPrice').textContent = '₹' + gst.toLocaleString('en-IN');
    document.getElementById('rdTotalPrice').textContent = '₹' + total.toLocaleString('en-IN');
}

function bookRoomDetailWhatsApp() {
    const checkIn = document.getElementById('rdCheckIn')?.value || 'Not specified';
    const checkOut = document.getElementById('rdCheckOut')?.value || 'Not specified';
    const adults = document.getElementById('rdAdults')?.value || '2';
    const children = document.getElementById('rdChildren')?.value || '0';
    const name = document.getElementById('rdName')?.value || 'Guest';
    const phone = document.getElementById('rdPhone')?.value || '';
    const total = document.getElementById('rdTotalPrice')?.textContent || '';

    const msg = `*HOTEL ROSE PALACE — ROOM RESERVATION*
━━━━━━━━━━━━━━━━━━━━━━
🏨 *Room:* {{ $roomType->name }}
📅 *Dates:* ${checkIn} to ${checkOut}
👥 *Guests:* ${adults} Adults, ${children} Children
💰 *Estimated Price:* ${total} (incl. 12% GST)
━━━━━━━━━━━━━━━━━━━━━━
👤 *Guest Name:* ${name}
📞 *Contact:* ${phone}`;

    const waNumber = '{{ preg_replace("/\D/", "", config("hotel.contact.whatsapp_number", "918799129929")) }}';
    window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`, '_blank');
}

document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);

    const cIn = document.getElementById('rdCheckIn');
    const cOut = document.getElementById('rdCheckOut');
    if (cIn && cOut) {
        cIn.value = today.toISOString().split('T')[0];
        cIn.min = today.toISOString().split('T')[0];
        cOut.value = tomorrow.toISOString().split('T')[0];
        cOut.min = tomorrow.toISOString().split('T')[0];
    }
    calculateDetailPrice();
});
</script>
@endsection
