@extends('layouts.app')

@section('title', 'Rooms & Suites — Hotel Rose Palace | Luxury Accommodation Surat')
@section('meta_description', 'Explore luxury rooms and suites at Hotel Rose Palace Surat. Deluxe rooms, twin executive rooms, and royal suites with pure comfort, free high-speed Wi-Fi, and 24/7 service.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="text-center" style="background: linear-gradient(180deg, rgba(110,44,58,0.4) 0%, rgba(46,31,34,0.85) 100%), url('{{ asset('images/hotel/hero-hd-2.jpg') }}') center/cover no-repeat; padding: 100px 20px 80px; position: relative;">
    <div class="container position-relative" style="z-index: 2;">
        <span style="color: var(--hrp-gold-light); font-family: var(--font-ui); font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 12px;">
            ✦ Bespoke Living Spaces ✦
        </span>
        <h1 style="color: var(--hrp-surface); font-size: 46px; margin-bottom: 16px;">Rooms & Royal Suites</h1>
        <p style="color: var(--hrp-tint); font-size: 18px; max-width: 680px; margin: 0 auto 24px; line-height: 1.6;">
            A sanctuary of tranquility and refined taste in Vesu, Surat. Designed for restful nights, productive business days, and family comforts.
        </p>
        <div class="d-inline-flex align-items-center gap-2" style="background: rgba(247,241,232,0.15); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(247,241,232,0.3); font-size: 13px; color: var(--hrp-surface);">
            <a href="{{ route('home') }}" style="color: var(--hrp-surface);">Home</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; color: var(--hrp-gold);"></i>
            <span>Accommodations</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     FILTER & SORT TOOLBAR
═══════════════════════════════════════════════════════ --}}
<div style="background: var(--hrp-tint); border-bottom: 1px solid var(--hrp-border); padding: 16px 0; position: sticky; top: 72px; z-index: 100;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            
            {{-- Category Filter Pills --}}
            <div class="d-flex flex-wrap align-items-center gap-2" id="roomCategoryFilters">
                <button class="hrp-menu-tab-btn active" data-filter="all" onclick="filterRoomCards('all', this)">All Accommodations</button>
                @foreach($roomTypes as $filterType)
                    <button class="hrp-menu-tab-btn" data-filter="{{ $filterType->slug }}" onclick="filterRoomCards('{{ $filterType->slug }}', this)">
                        {{ $filterType->name }}
                    </button>
                @endforeach
                <button type="button" class="btn btn-outline-secondary btn-sm ms-md-2" onclick="clearAllRoomFilters()">
                    <i class="fas fa-rotate-left me-1"></i> Clear Filters
                </button>
            </div>

            {{-- Price Sort Dropdown & Quick WhatsApp --}}
            <div class="d-flex align-items-center gap-2">
                <label for="priceSortSelect" style="font-size: 13px; font-weight: 600; color: var(--hrp-plum); white-space: nowrap;">Sort by:</label>
                <select id="priceSortSelect" class="hrp-field-input" style="padding: 6px 12px; font-size: 13px; width: auto; cursor: pointer;" onchange="sortRoomCards(this.value)">
                    <option value="recommended">Featured / Recommended</option>
                    <option value="low-to-high">Price: Low to High</option>
                    <option value="high-to-low">Price: High to Low</option>
                </select>
                <a href="{{ route('booking.search.form') }}" class="btn btn-primary btn-sm d-none d-md-inline-flex" style="padding: 7px 16px; text-decoration: none;">
                    <i class="fas fa-calculator"></i> Check Rates
                </a>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     ROOMS LISTING GRID (3-COLUMN COMPARISON CARDS)
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 50px 0;">
    <div class="container">

        <div class="row g-4" id="roomsContainer">
            @forelse($roomTypes as $roomType)
            @php
                // Image determination: Check first room's image, or room image from relation, or category fallback
                $firstRoom = $roomType->rooms->first();
                $featuredImage = $firstRoom?->images->first(fn($img) => $img->is_featured) ?? $firstRoom?->images->first();
                
                if ($featuredImage && Storage::disk('public')->exists($featuredImage->image_path)) {
                    $roomImg = Storage::url($featuredImage->image_path);
                } elseif ($firstRoom && $firstRoom->image_path && file_exists(public_path($firstRoom->image_path))) {
                    $roomImg = asset($firstRoom->image_path);
                } elseif (str_contains(strtolower($roomType->slug), 'executive')) {
                    $roomImg = asset('images/rooms/executive.jpg');
                } else {
                    $roomImg = asset('images/rooms/deluxe.jpg');
                }

                $basePrice = (float) $roomType->base_price;
                $gst12 = round($basePrice * 0.12, 2);
                $totalIndicative = $basePrice + $gst12;
            @endphp
            <div class="col-12 room-card-item" data-category="{{ $roomType->slug }}" data-price="{{ $basePrice }}">
                <div class="card p-0 overflow-hidden shadow-sm" style="border: 1px solid var(--hrp-border); border-radius: 12px; background: #fff;">
                    <div class="row g-0">

                        {{-- ── COLUMN 1: Room Information & Verified Specs ── --}}
                        <div class="col-lg-5 col-md-12 p-3 p-lg-4 d-flex flex-column" style="border-right: 1px solid var(--hrp-border);">
                            <div class="position-relative overflow-hidden rounded mb-3" style="aspect-ratio: 16 / 10;">
                                <img src="{{ $roomImg }}" alt="{{ $roomType->name }}" class="w-100 h-100 hrp-room-img" style="object-fit: cover; transition: transform 0.3s ease;" loading="lazy">
                                <span class="badge position-absolute top-0 start-0 m-2" style="background: rgba(110,44,58,0.92); color: #F7F1E8; padding: 6px 12px; font-size: 11px; text-transform: uppercase;">
                                    {{ $roomType->name }}
                                </span>
                            </div>

                            <h3 class="h4 mb-2" style="color: var(--hrp-plum);">
                                <a href="{{ route('room-detail', $roomType->slug) }}" style="color: inherit; text-decoration: none;">
                                    {{ $roomType->name }}
                                </a>
                            </h3>

                            {{-- Verified Specs Badges --}}
                            <div class="d-flex flex-wrap gap-2 mb-3 pb-2" style="border-bottom: 1px solid var(--hrp-border); font-size: 12px; color: var(--hrp-mauve);">
                                <span class="badge bg-light text-dark border"><i class="fas fa-user-friends text-gold me-1"></i> Up to {{ $roomType->max_occupancy }} Guests</span>
                                @if(!empty($roomType->bed_type))
                                    <span class="badge bg-light text-dark border"><i class="fas fa-bed text-gold me-1"></i> {{ $roomType->bed_type }}</span>
                                @endif
                                @if($roomType->size_sqft > 0)
                                    <span class="badge bg-light text-dark border"><i class="fas fa-vector-square text-gold me-1"></i> {{ $roomType->size_sqft }} sq.ft</span>
                                @endif
                                @if(!empty($roomType->view_type))
                                    <span class="badge bg-light text-dark border"><i class="fas fa-eye text-gold me-1"></i> {{ $roomType->view_type }}</span>
                                @endif
                                @if($roomType->bedroom_count > 0)
                                    <span class="badge bg-light text-dark border"><i class="fas fa-door-open text-gold me-1"></i> {{ $roomType->bedroom_count }} {{ Str::plural('Bed', $roomType->bedroom_count) }}</span>
                                @endif
                                @if($roomType->living_room_count > 0)
                                    <span class="badge bg-light text-dark border"><i class="fas fa-couch text-gold me-1"></i> {{ $roomType->living_room_count }} Living</span>
                                @endif
                                @if($roomType->bathroom_count > 0)
                                    <span class="badge bg-light text-dark border"><i class="fas fa-bath text-gold me-1"></i> {{ $roomType->bathroom_count }} {{ Str::plural('Bath', $roomType->bathroom_count) }}</span>
                                @endif
                            </div>

                            {{-- Amenities --}}
                            @if($roomType->amenities && $roomType->amenities->count() > 0)
                            <div class="row g-2 mb-3" style="font-size: 12px; color: var(--hrp-plum);">
                                @foreach($roomType->amenities->take(6) as $amenity)
                                <div class="col-6 d-flex align-items-center gap-2">
                                    <i class="fas fa-check-circle text-gold" style="font-size: 11px;"></i>
                                    <span>{{ $amenity->name }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <div class="mt-auto pt-2">
                                <a href="{{ route('room-detail', $roomType->slug) }}" class="fw-semibold text-decoration-none" style="color: var(--hrp-plum); font-size: 13px;">
                                    More Room Details & House Rules <i class="fas fa-arrow-right ms-1 text-gold"></i>
                                </a>
                            </div>
                        </div>

                        {{-- ── COLUMN 2: Rate Plan & Verified Inclusions ── --}}
                        <div class="col-lg-4 col-md-12 p-3 p-lg-4 d-flex flex-column justify-content-between" style="background-color: var(--hrp-tint); border-right: 1px solid var(--hrp-border);">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge" style="background: var(--hrp-gold); color: #fff; font-size: 11px; text-transform: uppercase;">Standard Rate Plan</span>
                                    <span class="badge bg-light text-dark border" style="font-size: 10px;">EP (Room Only)</span>
                                </div>
                                <h5 class="fw-bold mb-3" style="color: var(--hrp-plum);">Room Only Tariff Plan</h5>

                                <ul class="list-unstyled mb-3" style="font-size: 12.5px; line-height: 1.7; color: var(--hrp-plum);">
                                    <li class="d-flex align-items-start gap-2 mb-2">
                                        <i class="fas fa-check-circle text-success mt-1"></i>
                                        <span><strong>Confirmed Room Accommodation</strong></span>
                                    </li>
                                    <li class="d-flex align-items-start gap-2 mb-2">
                                        <i class="fas fa-wifi text-gold mt-1"></i>
                                        <span>Free High-Speed Wi-Fi in room</span>
                                    </li>
                                    <li class="d-flex align-items-start gap-2 mb-2">
                                        <i class="fas fa-snowflake text-gold mt-1"></i>
                                        <span>Air Conditioning & Television included</span>
                                    </li>
                                    <li class="d-flex align-items-start gap-2 mb-2">
                                        <i class="fas fa-concierge-bell text-gold mt-1"></i>
                                        <span>Daily Housekeeping & In-Room Dining Service</span>
                                    </li>
                                    <li class="d-flex align-items-start gap-2 mb-2">
                                        <i class="fas fa-exclamation-circle text-warning mt-1"></i>
                                        <span><strong>Breakfast:</strong> <span class="badge bg-warning text-dark" style="font-size: 10px;">Pending Hotel Confirmation</span><br><small class="text-muted">Inquire at front desk upon arrival</small></span>
                                    </li>
                                    <li class="d-flex align-items-start gap-2 mb-2">
                                        <i class="fas fa-shield-alt text-gold mt-1"></i>
                                        <span><strong>Cancellation:</strong> Manager-approved policy (prior to 24 hrs)</span>
                                    </li>
                                    <li class="d-flex align-items-start gap-2">
                                        <i class="fas fa-lock text-gold mt-1"></i>
                                        <span><strong>Payment:</strong> 100% Secure Instant Razorpay (No pay-at-hotel)</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="pt-2 border-top" style="border-color: var(--hrp-border) !important; font-size: 12px; color: var(--hrp-mauve);">
                                <i class="fas fa-clock text-gold me-1"></i> <strong>Check-in:</strong> 12:00 PM | <strong>Check-out:</strong> 11:00 AM
                            </div>
                        </div>

                        {{-- ── COLUMN 3: Pricing & Action CTA ── --}}
                        <div class="col-lg-3 col-md-12 p-3 p-lg-4 d-flex flex-column justify-content-between text-center" style="background-color: #fff;">
                            <div>
                                <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Starting From</span>
                                
                                @if(!empty($roomType->original_price) && $roomType->original_price > $roomType->base_price)
                                    <div class="text-decoration-line-through text-muted mb-1" style="font-size: 14px;">
                                        ₹{{ number_format($roomType->original_price, 0) }}
                                    </div>
                                @endif

                                <div class="d-flex align-items-baseline justify-content-center gap-1 mb-2">
                                    <span class="fs-2 fw-bold" style="color: var(--hrp-plum);">₹{{ number_format($basePrice, 0) }}</span>
                                    <span class="text-muted" style="font-size: 12px;">/ night</span>
                                </div>

                                {{-- 12% GST Itemized Breakdown Box --}}
                                <div class="p-2 mb-3 rounded text-start" style="background-color: var(--hrp-tint); border: 1px solid var(--hrp-border); font-size: 11.5px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Base Tariff:</span>
                                        <span class="fw-semibold">₹{{ number_format($basePrice, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">GST (12%):</span>
                                        <span class="fw-semibold">₹{{ number_format($gst12, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between pt-1 border-top" style="border-color: var(--hrp-border) !important;">
                                        <span class="fw-bold" style="color: var(--hrp-plum);">Total Indicative:</span>
                                        <span class="fw-bold text-gold">₹{{ number_format($totalIndicative, 2) }}</span>
                                    </div>
                                    <div class="text-muted text-center mt-1" style="font-size: 10px;">
                                        Per room, per night. Calculated at checkout.
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('booking.search.form', ['room_type_id' => $roomType->id]) }}" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-calendar-check me-1"></i> Select Room
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to inquire about booking the ' . $roomType->name) }}" target="_blank" class="btn btn-whatsapp w-100 py-2" aria-label="Inquire on WhatsApp">
                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp Inquiry
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No rooms currently available in the catalogue.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     STANDARD INCLUSIONS BANNER (VERIFIED AMENITIES)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider" style="background-color: var(--hrp-surface); padding: 50px 0;">
    <div class="container text-center">
        <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 12px; letter-spacing: 2px; text-transform: uppercase;">✦ The Rose Palace Guarantee ✦</span>
        <h3 style="color: var(--hrp-plum); margin: 6px 0 28px;">Standard with Every Reservation</h3>

        <div class="row g-3 justify-content-center">
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-wifi text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">High-Speed Wi-Fi</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Dedicated Wi-Fi connection throughout the property.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-snowflake text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">Air Conditioning & TV</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Individual climate control and satellite television in every room.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-clock text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">Standard Timings</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Check-in: 12:00 PM | Check-out: 11:00 AM.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-concierge-bell text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">24-Hour Front Desk</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Dedicated front desk and room service assistance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('extra_js')
<script>
function filterRoomCards(category, btn) {
    document.querySelectorAll('#roomCategoryFilters button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const items = document.querySelectorAll('.room-card-item');
    items.forEach(item => {
        if (category === 'all' || item.getAttribute('data-category') === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function clearAllRoomFilters() {
    document.querySelectorAll('#roomCategoryFilters button').forEach(b => b.classList.remove('active'));
    const allBtn = document.querySelector('#roomCategoryFilters button[data-filter="all"]');
    if (allBtn) allBtn.classList.add('active');

    const items = document.querySelectorAll('.room-card-item');
    items.forEach(item => {
        item.style.display = 'block';
    });

    const sortSelect = document.getElementById('priceSortSelect');
    if (sortSelect) {
        sortSelect.value = 'recommended';
    }
}

function sortRoomCards(criteria) {
    const container = document.getElementById('roomsContainer');
    const items = Array.from(document.querySelectorAll('.room-card-item'));

    if (criteria === 'low-to-high') {
        items.sort((a, b) => parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price')));
    } else if (criteria === 'high-to-low') {
        items.sort((a, b) => parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price')));
    }

    items.forEach(item => container.appendChild(item));
}
</script>
@endsection
