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
            <div class="d-flex flex-wrap gap-2" id="roomCategoryFilters">
                <button class="hrp-menu-tab-btn active" data-filter="all" onclick="filterRoomCards('all', this)">All Accommodations</button>
                <button class="hrp-menu-tab-btn" data-filter="double" onclick="filterRoomCards('double', this)">Deluxe Rooms</button>
                <button class="hrp-menu-tab-btn" data-filter="suite" onclick="filterRoomCards('suite', this)">Suites</button>
                <button class="hrp-menu-tab-btn" data-filter="family" onclick="filterRoomCards('family', this)">Family Rooms</button>
                <button class="hrp-menu-tab-btn" data-filter="business" onclick="filterRoomCards('business', this)">Business Class</button>
            </div>

            {{-- Price Sort Dropdown & Quick WhatsApp --}}
            <div class="d-flex align-items-center gap-2">
                <label for="priceSortSelect" style="font-size: 13px; font-weight: 600; color: var(--hrp-plum); white-space: nowrap;">Sort by:</label>
                <select id="priceSortSelect" class="hrp-field-input" style="padding: 6px 12px; font-size: 13px; width: auto; cursor: pointer;" onchange="sortRoomCards(this.value)">
                    <option value="recommended">Featured / Recommended</option>
                    <option value="low-to-high">Price: Low to High</option>
                    <option value="high-to-low">Price: High to Low</option>
                </select>
                <button type="button" onclick="window.openBookingModal()" class="btn btn-primary btn-sm d-none d-md-inline-flex" style="padding: 7px 16px;">
                    <i class="fas fa-calculator"></i> Price Calculator
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     ROOMS LISTING GRID
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 60px 0;">
    <div class="container">

        @php
        $roomsList = [
            [
                'id' => 1,
                'slug' => 'deluxe-double-room',
                'name' => 'Deluxe Double Room',
                'category' => 'double',
                'price' => 1725,
                'img' => asset('images/rooms/deluxe.jpg'),
                'bed' => 'Plush King Bed',
                'size' => '320 sq.ft',
                'occupancy' => '2 Adults',
                'floor' => 'Floor 1',
                'desc' => 'Spacious and elegantly appointed, featuring a plush king-size bed, warm golden ambient lighting, study desk, and an en-suite rain shower.',
                'features' => ['Free Wi-Fi', 'Air Conditioning', 'Flat-Screen TV', 'En-suite Rain Shower', 'Complimentary Breakfast', 'Work Desk'],
            ],
            [
                'id' => 2,
                'slug' => 'deluxe-twin-room',
                'name' => 'Deluxe Twin Room',
                'category' => 'double',
                'price' => 1725,
                'img' => asset('images/rooms/executive.jpg'),
                'bed' => 'Dual Twin Beds',
                'size' => '340 sq.ft',
                'occupancy' => '2 Adults',
                'floor' => 'Floor 1',
                'desc' => 'Ideal for colleagues and friends, featuring two luxury single beds, silent split AC, bedside nightstand, and modern hospitality conveniences.',
                'features' => ['High-Speed Wi-Fi', 'Dual Single Beds', 'Split Air Conditioning', 'Luggage Bench', 'Complimentary Breakfast', 'Attached Bath'],
            ],
            [
                'id' => 3,
                'slug' => 'executive-business-room',
                'name' => 'Executive Business Room',
                'category' => 'business',
                'price' => 2399,
                'img' => asset('images/rooms/executive.jpg'),
                'bed' => 'Plush King Bed',
                'size' => '420 sq.ft',
                'occupancy' => '2 Adults',
                'floor' => 'Floor 1',
                'desc' => 'Purpose-built for corporate executives visiting Surat — wooden wardrobe, flat-screen TV console, high-speed internet, and flexible check-in.',
                'features' => ['Dedicated Wi-Fi', 'Wooden Wardrobe', 'Flat-Screen TV', 'Split AC', 'Tea & Coffee Maker', 'Business Centre Access'],
            ],
            [
                'id' => 4,
                'slug' => 'executive-suite',
                'name' => 'Executive Work-Desk Suite',
                'category' => 'suite',
                'price' => 2599,
                'img' => asset('images/rooms/deluxe.jpg'),
                'bed' => 'Plush King Bed',
                'size' => '480 sq.ft',
                'occupancy' => '3 Guests',
                'floor' => 'Floor 1',
                'desc' => 'A distinct sanctuary featuring an expansive king bed, warm ambient boutique lighting, luggage bench, and en-suite luxury bathroom.',
                'features' => ['Luggage Stool', 'Modern En-Suite Bathroom', 'Boutique Art Decor', 'Priority Room Service', 'Complimentary High Tea', 'Floor 1'],
            ],
            [
                'id' => 5,
                'slug' => 'royal-heritage-suite',
                'name' => 'Royal Heritage Suite',
                'category' => 'family',
                'price' => 3499,
                'img' => asset('images/rooms/family.jpg'),
                'bed' => 'King Bed + Coffee Table Lounge',
                'size' => '560 sq.ft',
                'occupancy' => '4 Guests (Family)',
                'floor' => 'Floor 1',
                'desc' => 'Spacious quarters featuring an independent sitting coffee table lounge, wooden wardrobe, ambient ceiling lighting, and attached marble bathroom.',
                'features' => ['Coffee Lounge Table', 'Large Wardrobe', 'Luxury Bath Amenities', 'Kid-friendly Setup', 'Complimentary Breakfast', 'Mini Refrigerator'],
            ],
            [
                'id' => 6,
                'slug' => 'maharaja-grand-suite',
                'name' => 'Maharaja Grand Suite',
                'category' => 'suite',
                'price' => 4499,
                'img' => asset('images/rooms/suite.jpg'),
                'bed' => 'Emperor Luxury Bed',
                'size' => '680 sq.ft',
                'occupancy' => '4 Guests',
                'floor' => 'Floor 1 (Royal Wing)',
                'desc' => 'The crown jewel of Hotel Rose Palace. Warm ambient glow, luxury headboard, flat-screen entertainment, and royal hospitality.',
                'features' => ['Embroidered Royal Runners', 'Dedicated Butler Call', 'Seating Salon', 'VIP Airport Transfer', 'Welcome Refreshments', 'Black Marble Bath'],
            ],
        ];
        @endphp

        <div class="row g-4" id="roomsContainer">
            @foreach($roomsList as $room)
            <div class="col-lg-6 room-card-item" data-category="{{ $room['category'] }}" data-price="{{ $room['price'] }}">
                <div class="card p-0 overflow-hidden h-100" style="display: flex; flex-direction: column;">
                    
                    {{-- Photo Banner --}}
                    <div style="position: relative; overflow: hidden; aspect-ratio: 16 / 10;">
                        <img src="{{ $room['img'] }}" alt="{{ $room['name'] }}" class="hrp-room-img" style="width: 100%; height: 100%; object-fit: cover; object-position: center; aspect-ratio: 16 / 10;" loading="lazy">
                        <div style="position: absolute; top: 16px; left: 16px; display: flex; gap: 8px;">
                            <span class="badge" style="background: rgba(110,44,58,0.92); color: #F7F1E8; padding: 6px 12px; font-size: 11px; text-transform: uppercase;">
                                {{ ucfirst($room['category']) }}
                            </span>
                        </div>
                        <div style="position: absolute; bottom: 16px; right: 16px; background: rgba(46,31,34,0.9); backdrop-filter: blur(8px); padding: 8px 16px; border-radius: 8px; border: 1px solid var(--hrp-gold); text-align: right;">
                            <span style="font-size: 10px; color: var(--hrp-tint); text-transform: uppercase; display: block;">From</span>
                            <span style="font-size: 22px; font-weight: 700; color: var(--hrp-gold-light); line-height: 1;">₹{{ number_format($room['price'], 0) }}</span>
                            <span style="font-size: 11px; color: var(--hrp-surface);">/night</span>
                        </div>
                    </div>

                    {{-- Room Details Body --}}
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 style="font-size: 22px; color: var(--hrp-plum); margin: 0;">{{ $room['name'] }}</h3>
                        </div>

                        {{-- Quick Specs --}}
                        <div class="d-flex flex-wrap gap-3 mb-3 pb-2" style="border-bottom: 1px solid var(--hrp-border); font-size: 12.5px; color: var(--hrp-mauve);">
                            <span><i class="fas fa-bed text-gold"></i> {{ $room['bed'] }}</span>
                            <span><i class="fas fa-vector-square text-gold"></i> {{ $room['size'] }}</span>
                            <span><i class="fas fa-user-friends text-gold"></i> {{ $room['occupancy'] }}</span>
                            <span><i class="fas fa-layer-group text-gold"></i> {{ $room['floor'] }}</span>
                        </div>

                        <p style="font-size: 14px; color: var(--hrp-mauve); line-height: 1.7; margin-bottom: 16px; flex-grow: 1;">
                            {{ $room['desc'] }}
                        </p>

                        {{-- Features Grid --}}
                        <div class="row g-2 mb-4" style="font-size: 12px; color: var(--hrp-plum);">
                            @foreach($room['features'] as $f)
                            <div class="col-6 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-gold" style="font-size: 11px;"></i>
                                <span>{{ $f }}</span>
                            </div>
                            @endforeach
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 flex-wrap pt-3" style="border-top: 1px solid var(--hrp-border);">
                            <button type="button" onclick="window.openBookingModal('{{ $room['slug'] }}')" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-calendar-check"></i> Book Now
                            </button>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to inquire about booking the ' . $room['name']) }}" target="_blank" class="btn btn-whatsapp" aria-label="Ask on WhatsApp" title="Ask on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                                <span class="d-none d-sm-inline">WhatsApp</span>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     STANDARD INCLUSIONS BANNER
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider" style="background-color: var(--hrp-surface); padding: 60px 0;">
    <div class="container text-center">
        <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 12px; letter-spacing: 2px; text-transform: uppercase;">✦ The Rose Palace Guarantee ✦</span>
        <h3 style="color: var(--hrp-plum); margin: 6px 0 28px;">Standard with Every Reservation</h3>

        <div class="row g-3 justify-content-center">
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-utensils text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">Complimentary Breakfast</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Pure veg and Jain breakfast buffet prepared fresh every morning.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-wifi text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">500 Mbps High-Speed Wi-Fi</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Dedicated room connection ideal for zoom calls and entertainment.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-parking text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">Free Valet Parking</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">Underground secured multi-level parking with CCTV surveillance.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card p-3 text-center h-100">
                    <i class="fas fa-clock text-gold fs-3 mb-2"></i>
                    <h6 style="color: var(--hrp-plum); margin-bottom: 4px;">Flexible 24-Hr Check-In</h6>
                    <p style="font-size: 12px; color: var(--hrp-mauve); margin: 0;">24/7 dedicated concierge desk to welcome your late-night arrivals.</p>
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
