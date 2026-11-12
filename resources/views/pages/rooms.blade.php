@extends('layouts.app')

@section('title', 'Rooms & Suites — Hotel Rose Palace | Luxury Accommodation Surat')
@section('meta_description', 'Discover our collection of luxury rooms and suites at Hotel Rose Palace, Surat. From Deluxe Doubles to Royal Palace Suites — premium comfort for every occasion.')
@section('meta_keywords', 'hotel rooms surat, luxury suites surat, hotel rose palace rooms, book room surat, hotel accommodation surat')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="hrp-rooms-hero" id="rooms-hero">
    <div class="hrp-rooms-hero-overlay"></div>
    <div class="hrp-rooms-particles">
        <span></span><span></span><span></span>
    </div>
    <div class="container hrp-rooms-hero-container">
        <div class="hrp-page-hero-eyebrow">
            <span class="hrp-eyebrow-line"></span>
            <span>✦ Our Accommodations ✦</span>
            <span class="hrp-eyebrow-line"></span>
        </div>
        <h1 class="hrp-rooms-hero-title">Rooms & Suites</h1>
        <p class="hrp-rooms-hero-sub">Every room is a sanctuary of comfort and elegance, crafted to give you the perfect balance of luxury, privacy, and modern convenience.</p>
        <nav class="hrp-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="hrp-bc-sep"><i class="fas fa-chevron-right"></i></span>
            <span>Rooms & Suites</span>
        </nav>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     QUICK FILTER BAR
═══════════════════════════════════════════════════════ --}}
<div class="hrp-rooms-filter-bar-wrap">
    <div class="container">
        <div class="hrp-rooms-filter-bar">
            <div class="hrp-rfb-label">
                <i class="fas fa-sliders-h"></i>
                <span>Filter By:</span>
            </div>
            <div class="hrp-rfb-filters">
                <button class="hrp-rfb-btn active" data-filter="all" id="rfb-all">All Rooms</button>
                <button class="hrp-rfb-btn" data-filter="double" id="rfb-double">Double Rooms</button>
                <button class="hrp-rfb-btn" data-filter="suite" id="rfb-suite">Suites</button>
                <button class="hrp-rfb-btn" data-filter="business" id="rfb-business">Business</button>
            </div>
            <div class="hrp-rfb-cta">
                <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}?text={{ urlencode('Hello! I would like to enquire about room availability at Hotel Rose Palace.') }}"
                   target="_blank" class="hrp-rfb-wa" id="rfb-wa-btn">
                    <i class="fab fa-whatsapp"></i> Ask on WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     ROOM TYPES LISTING
═══════════════════════════════════════════════════════ --}}
<section class="hrp-rooms-listing" id="rooms-listing">
    <div class="container">

        @php
        $defaultRooms = [
            [
                'name' => 'Deluxe Double Room',
                'slug' => 'deluxe-double-room',
                'desc' => 'Spacious and elegantly appointed, our Deluxe Rooms feature a plush king-size bed, premium linen, smart TV, and a marble en-suite bathroom. The perfect retreat after a busy day.',
                'price' => '3,999',
                'img' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80',
                'bed' => 'King Bed',
                'size' => '320 sq.ft',
                'guests' => '2 Adults',
                'floor' => 'Floors 2–4',
                'type' => 'double',
                'features' => ['Free Wi-Fi (500 Mbps+)', 'Smart 55" LED TV', 'Air Conditioning', 'Minibar', 'Work Desk', 'En-suite Marble Bathroom', 'Daily Housekeeping', 'Complimentary Breakfast'],
                'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-snowflake','AC'],['fas fa-tv','Smart TV'],['fas fa-coffee','Breakfast']]
            ],
            [
                'name' => 'Superior Twin Room',
                'slug' => 'superior-twin-room',
                'desc' => 'Ideal for friends or colleagues, our Superior Twin Room features two premium single beds, contemporary décor, and all the amenities needed for a comfortable and productive stay.',
                'price' => '4,499',
                'img' => 'https://images.unsplash.com/photo-1512918728672-f9d96f4fff8c?w=800&q=80',
                'bed' => 'Twin Beds',
                'size' => '340 sq.ft',
                'guests' => '2 Adults',
                'floor' => 'Floors 2–4',
                'type' => 'double',
                'features' => ['Free Wi-Fi', 'Smart TV', 'Air Conditioning', 'Mini Fridge', 'City View', 'En-suite Bathroom', 'Daily Housekeeping', 'Breakfast Included'],
                'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-snowflake','AC'],['fas fa-tv','Smart TV'],['fas fa-city','City View']]
            ],
            [
                'name' => 'Executive Suite',
                'slug' => 'executive-suite',
                'desc' => 'A perfect blend of business functionality and leisure comfort. Features a separate living area, executive work desk, premium minibar, and panoramic city views — crafted for the discerning business traveller.',
                'price' => '6,499',
                'img' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80',
                'bed' => 'King Bed + Sofa Bed',
                'size' => '540 sq.ft',
                'guests' => '2 Adults + 1 Child',
                'floor' => 'Floors 5–6',
                'type' => 'suite',
                'features' => ['High-Speed Wi-Fi', 'Smart TV + Projector', 'AC + Air Purifier', 'Premium Minibar', 'Separate Living Area', 'Executive Work Desk', 'Espresso Machine', 'Fine Dining In-Room'],
                'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-snowflake','AC'],['fas fa-briefcase','Business'],['fas fa-utensils','Dining']]
            ],
            [
                'name' => 'Business Executive Room',
                'slug' => 'business-executive-room',
                'desc' => 'Purpose-built for business travellers — high-speed Wi-Fi, ergonomic workstation, express check-in and check-out, flexible meal timings, and complimentary business centre access.',
                'price' => '5,299',
                'img' => 'https://images.unsplash.com/photo-1521783593447-5702b9bfd267?w=800&q=80',
                'bed' => 'King Bed',
                'size' => '420 sq.ft',
                'guests' => '2 Adults',
                'floor' => 'Floors 3–5',
                'type' => 'business',
                'features' => ['Gigabit Wi-Fi', 'Smart TV', 'Air Conditioning', 'Ergonomic Workstation', 'Express Check-in', 'Business Centre Access', 'Complimentary Breakfast', 'Evening Snacks'],
                'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-briefcase','Business'],['fas fa-coffee','Breakfast'],['fas fa-bolt','Express']]
            ],
            [
                'name' => 'Royal Palace Suite',
                'slug' => 'royal-palace-suite',
                'desc' => 'The pinnacle of luxury at Hotel Rose Palace. Features a grand bedroom, private jacuzzi, dedicated butler service, bespoke amenities, and sweeping city views — exclusively crafted for discerning royalty.',
                'price' => '12,999',
                'img' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80',
                'bed' => 'Super King Bed',
                'size' => '860 sq.ft',
                'guests' => '2 Adults + 2 Children',
                'floor' => 'Top Floor (Floor 7)',
                'type' => 'suite',
                'features' => ['Premium Wi-Fi', 'Smart TV + Sound System', 'Private Jacuzzi', 'Dedicated Butler', 'Full Kitchen', 'Private Dining Area', 'VIP Check-in', 'Bespoke Amenities'],
                'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-bath','Jacuzzi'],['fas fa-concierge-bell','Butler'],['fas fa-utensils','Fine Dining']]
            ],
        ];
        $roomData = isset($roomTypes) && method_exists($roomTypes, 'count') && $roomTypes->count() > 0 ? $roomTypes : null;
        @endphp

        @if($roomData)
            {{-- From Database --}}
            @foreach($roomData as $i => $roomType)
            <div class="hrp-room-block {{ $i % 2 == 1 ? 'hrp-room-block--reverse' : '' }}" id="room-type-{{ $roomType->id }}">
                <div class="hrp-rb-img-col">
                    <div class="hrp-rb-img-wrap">
                        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80"
                             alt="{{ $roomType->name }}" class="hrp-rb-img" loading="lazy">
                        <div class="hrp-rb-price-badge">
                            <span class="hrp-rb-from">From</span>
                            <span class="hrp-rb-price">₹{{ number_format($roomType->base_price, 0) }}</span>
                            <span class="hrp-rb-night">/Night</span>
                        </div>
                    </div>
                </div>
                <div class="hrp-rb-content-col">
                    <div class="hrp-rb-content">
                        <div class="hrp-rb-meta-row">
                            <span class="hrp-rb-meta-tag"><i class="fas fa-ruler-combined"></i> —</span>
                            <span class="hrp-rb-meta-tag"><i class="fas fa-users"></i> {{ $roomType->max_occupancy }} Guests</span>
                        </div>
                        <h2 class="hrp-rb-name">{{ $roomType->name }}</h2>
                        <p class="hrp-rb-desc">{{ $roomType->description }}</p>
                        <div class="hrp-rb-features">
                            @foreach($roomType->amenities->take(6) as $am)
                            <div class="hrp-rb-feat"><i class="fas fa-check"></i> {{ $am->name }}</div>
                            @endforeach
                        </div>
                        <div class="hrp-rb-actions">
                            <a href="{{ route('room-detail', $roomType->slug) }}" class="hrp-btn-gold" id="room-details-{{ $roomType->id }}">
                                <i class="fas fa-eye me-2"></i> View Details & Book
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}?text={{ urlencode('Hello! I am interested in ' . $roomType->name . ' at Hotel Rose Palace. Please share availability and pricing.') }}"
                               target="_blank" class="hrp-rb-wa-btn" id="room-wa-{{ $roomType->id }}">
                                <i class="fab fa-whatsapp"></i> Enquire
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            {{-- Default Rooms --}}
            @foreach($defaultRooms as $i => $room)
            <div class="hrp-room-block {{ $i % 2 == 1 ? 'hrp-room-block--reverse' : '' }}" data-type="{{ $room['type'] }}" id="room-block-{{ $i }}">
                <div class="hrp-rb-img-col">
                    <div class="hrp-rb-img-wrap">
                        <img src="{{ $room['img'] }}" alt="{{ $room['name'] }}" class="hrp-rb-img" loading="lazy">
                        <div class="hrp-rb-price-badge">
                            <span class="hrp-rb-from">From</span>
                            <span class="hrp-rb-price">₹{{ $room['price'] }}</span>
                            <span class="hrp-rb-night">/Night</span>
                        </div>
                        <div class="hrp-rb-img-overlay">
                            <div class="hrp-rb-quick-tags">
                                @foreach($room['icons'] as $ic)
                                <span class="hrp-rb-qtag"><i class="{{ $ic[0] }}"></i> {{ $ic[1] }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hrp-rb-content-col">
                    <div class="hrp-rb-content">
                        <div class="hrp-rb-meta-row">
                            <span class="hrp-rb-meta-tag"><i class="fas fa-bed"></i> {{ $room['bed'] }}</span>
                            <span class="hrp-rb-meta-tag"><i class="fas fa-ruler-combined"></i> {{ $room['size'] }}</span>
                            <span class="hrp-rb-meta-tag"><i class="fas fa-users"></i> {{ $room['guests'] }}</span>
                            <span class="hrp-rb-meta-tag"><i class="fas fa-layer-group"></i> {{ $room['floor'] }}</span>
                        </div>
                        <h2 class="hrp-rb-name">{{ $room['name'] }}</h2>
                        <p class="hrp-rb-desc">{{ $room['desc'] }}</p>
                        <div class="hrp-rb-features">
                            @foreach($room['features'] as $feat)
                            <div class="hrp-rb-feat"><i class="fas fa-check"></i> {{ $feat }}</div>
                            @endforeach
                        </div>
                        <div class="hrp-rb-actions">
                            <a href="{{ route('rooms') }}" class="hrp-btn-gold" id="room-view-{{ $i }}">
                                <i class="fas fa-eye me-2"></i> View Details & Book
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}?text={{ urlencode('Hello! I am interested in ' . $room['name'] . ' at Hotel Rose Palace. Please share availability and pricing.') }}"
                               target="_blank" class="hrp-rb-wa-btn" id="room-wa-{{ $i }}">
                                <i class="fab fa-whatsapp"></i> Enquire
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     ALL ROOMS INCLUDE (Standard Amenities)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-rooms-std-section hrp-bg-cream" id="standard-amenities">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Standard In Every Room</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Every Room Includes</h2>
            <p class="hrp-section-sub">Regardless of your room type, every guest at Hotel Rose Palace enjoys these premium standard amenities as part of their stay.</p>
        </div>

        <div class="row g-4">
            @php
            $stdAmenities = [
                ['icon' => 'fas fa-wifi', 'name' => 'High-Speed Wi-Fi', 'desc' => 'Free 500 Mbps+ internet'],
                ['icon' => 'fas fa-snowflake', 'name' => 'Air Conditioning', 'desc' => 'Individual climate control'],
                ['icon' => 'fas fa-tv', 'name' => 'Smart LED TV', 'desc' => 'Premium channels + OTT'],
                ['icon' => 'fas fa-tshirt', 'name' => 'Daily Housekeeping', 'desc' => 'Twice-daily service'],
                ['icon' => 'fas fa-bath', 'name' => 'En-Suite Bathroom', 'desc' => 'Premium toiletries included'],
                ['icon' => 'fas fa-coffee', 'name' => 'Tea & Coffee Maker', 'desc' => 'Complimentary supply'],
                ['icon' => 'fas fa-phone-alt', 'name' => '24/7 Room Service', 'desc' => 'Round-the-clock dining'],
                ['icon' => 'fas fa-lock', 'name' => 'In-Room Safe', 'desc' => 'Digital security locker'],
            ];
            @endphp
            @foreach($stdAmenities as $i => $sa)
            <div class="col-lg-3 col-md-6" id="std-amenity-{{ $i }}">
                <div class="hrp-std-card">
                    <div class="hrp-std-icon"><i class="{{ $sa['icon'] }}"></i></div>
                    <div class="hrp-std-info">
                        <h5 class="hrp-std-name">{{ $sa['name'] }}</h5>
                        <p class="hrp-std-desc">{{ $sa['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     BOOKING CTA (Dark)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-rooms-cta-section" id="rooms-cta">
    <div class="container">
        <div class="hrp-rooms-cta-card">
            <div class="hrp-rooms-cta-bg-deco"></div>
            <div class="hrp-rooms-cta-content text-center">
                <div class="hrp-section-eyebrow justify-content-center" style="color:#C5A059;">
                    <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
                    <span>Book Your Stay</span>
                    <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
                </div>
                <div class="hrp-gold-rule hrp-gold-rule--center"></div>
                <h2 class="hrp-rooms-cta-heading">Ready to Experience Luxury?</h2>
                <p class="hrp-rooms-cta-sub">Contact our reservations team on WhatsApp to check availability, receive a personalised quote, and confirm your booking within minutes.</p>
                <div class="hrp-rooms-cta-btns">
                    <a href="{{ route('contact') }}" class="hrp-btn-gold" id="rooms-contact-cta">
                        <i class="fas fa-paper-plane me-2"></i> Send an Enquiry
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to check room availability and get a quote for my stay.') }}"
                       target="_blank" class="hrp-rooms-wa-cta" id="rooms-wa-cta">
                        <i class="fab fa-whatsapp"></i> Book via WhatsApp
                    </a>
                </div>
                <p class="hrp-rooms-cta-note"><i class="fas fa-shield-alt"></i> Instant confirmation · Best rates guaranteed · 24/7 support</p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('extra_css')
<style>
/* ── Design Tokens ──────────────────────────────────────── */
:root {
    --navy: #1A222D; --gold: #C5A059; --gold-lt: #e8c97a;
    --cream: #F8F6F2; --white: #FFFFFF; --dark: #0E1620; --txt: #4A5568;
}
.hrp-bg-cream { background: var(--cream); }

/* ── SHARED ─────────────────────────────────────────────── */
.hrp-section-eyebrow { display: flex; align-items: center; gap: 12px; font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 8px; }
.hrp-eyebrow-dash { flex: 1; max-width: 40px; height: 1.5px; background: var(--gold); border-radius: 2px; }
.hrp-gold-rule { width: 50px; height: 3px; background: linear-gradient(90deg, var(--gold), var(--gold-lt)); border-radius: 2px; margin: 10px 0 20px; }
.hrp-gold-rule--center { margin: 10px auto 24px; }
.hrp-section-heading { font-family: 'Playfair Display', serif; font-size: clamp(28px,4vw,40px); color: var(--navy); font-weight: 700; margin-bottom: 12px; line-height: 1.25; }
.hrp-section-sub { font-size: 15.5px; color: var(--txt); max-width: 620px; margin: 0 auto 48px; line-height: 1.75; }
.hrp-section-header { margin-bottom: 0; }
.hrp-btn-gold { display: inline-flex; align-items: center; background: linear-gradient(135deg, var(--gold), var(--gold-lt)); color: var(--navy); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14.5px; padding: 14px 32px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(197,160,89,0.35); white-space: nowrap; }
.hrp-btn-gold:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(197,160,89,0.5); color: var(--navy); }

/* ── HERO ───────────────────────────────────────────────── */
.hrp-rooms-hero {
    position: relative; min-height: 480px;
    background: linear-gradient(165deg, rgba(14,22,32,0.9) 0%, rgba(14,22,32,0.68) 50%, rgba(197,160,89,0.12) 100%),
                url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1600&q=90') center/cover no-repeat;
    display: flex; align-items: center; overflow: hidden;
}
.hrp-rooms-hero-overlay { position: absolute; inset: 0; background: radial-gradient(ellipse at 25% 50%, rgba(197,160,89,0.07) 0%, transparent 65%); }
.hrp-rooms-particles { position: absolute; inset: 0; pointer-events: none; }
.hrp-rooms-particles span { position: absolute; display: block; border-radius: 50%; background: rgba(197,160,89,0.3); animation: hrpFloat 8s ease-in-out infinite; }
.hrp-rooms-particles span:nth-child(1){width:5px;height:5px;top:25%;left:18%;animation-delay:0s;}
.hrp-rooms-particles span:nth-child(2){width:3px;height:3px;top:60%;left:78%;animation-delay:2.5s;}
.hrp-rooms-particles span:nth-child(3){width:7px;height:7px;top:72%;left:38%;animation-delay:4s;}
@keyframes hrpFloat { 0%,100%{transform:translateY(0);opacity:0.4;} 50%{transform:translateY(-18px);opacity:0.9;} }
.hrp-rooms-hero-container { position: relative; z-index: 2; padding: 100px 24px 60px; text-align: center; }
.hrp-page-hero-eyebrow { display: inline-flex; align-items: center; gap: 14px; font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3.5px; text-transform: uppercase; color: var(--gold); margin-bottom: 20px; }
.hrp-eyebrow-line { display: block; width: 40px; height: 1px; background: linear-gradient(90deg, transparent, var(--gold)); }
.hrp-eyebrow-line:last-child { background: linear-gradient(90deg, var(--gold), transparent); }
.hrp-rooms-hero-title { font-family: 'Playfair Display', serif; font-size: clamp(40px,6vw,70px); font-weight: 700; color: #fff; margin-bottom: 16px; line-height: 1.1; text-shadow: 0 2px 40px rgba(0,0,0,0.3); }
.hrp-rooms-hero-sub { font-size: clamp(14px,1.8vw,17px); color: rgba(255,255,255,0.75); max-width: 600px; margin: 0 auto 24px; line-height: 1.8; }
.hrp-breadcrumb { display: inline-flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-size: 12.5px; color: rgba(255,255,255,0.5); }
.hrp-breadcrumb a { color: var(--gold); text-decoration: none; }
.hrp-breadcrumb a:hover { color: #fff; }
.hrp-bc-sep { font-size: 9px; color: rgba(255,255,255,0.3); }

/* ── FILTER BAR ─────────────────────────────────────────── */
.hrp-rooms-filter-bar-wrap { background: var(--white); border-top: 3px solid var(--gold); box-shadow: 0 8px 30px rgba(0,0,0,0.08); position: relative; z-index: 10; }
.hrp-rooms-filter-bar { display: flex; align-items: center; gap: 16px; padding: 16px 24px; flex-wrap: wrap; }
.hrp-rfb-label { display: flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 700; color: var(--navy); white-space: nowrap; }
.hrp-rfb-label i { color: var(--gold); }
.hrp-rfb-filters { display: flex; gap: 8px; flex-wrap: wrap; flex: 1; }
.hrp-rfb-btn { background: transparent; border: 1.5px solid #E2D9C8; color: var(--txt); font-family: 'Poppins', sans-serif; font-size: 12.5px; font-weight: 600; padding: 8px 18px; border-radius: 50px; cursor: pointer; transition: all 0.3s ease; }
.hrp-rfb-btn:hover, .hrp-rfb-btn.active { background: var(--navy); border-color: var(--navy); color: var(--gold); }
.hrp-rfb-wa { display: inline-flex; align-items: center; gap: 7px; background: rgba(37,211,102,0.1); border: 1.5px solid rgba(37,211,102,0.4); color: #1a9e4a; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; padding: 9px 18px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; white-space: nowrap; }
.hrp-rfb-wa:hover { background: #25D366; color: #fff; border-color: #25D366; }
.hrp-rfb-wa i { font-size: 16px; }

/* ── ROOM LISTING ───────────────────────────────────────── */
.hrp-rooms-listing { padding: 80px 0; background: var(--white); }
.hrp-room-block {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 0; margin-bottom: 48px; border-radius: 20px;
    overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
    border: 1.5px solid rgba(197,160,89,0.1);
}
.hrp-room-block:hover { box-shadow: 0 20px 70px rgba(0,0,0,0.13); transform: translateY(-4px); border-color: rgba(197,160,89,0.3); }
.hrp-room-block--reverse { direction: rtl; }
.hrp-room-block--reverse > * { direction: ltr; }
.hrp-rb-img-col { position: relative; overflow: hidden; }
.hrp-rb-img-wrap { position: relative; height: 100%; min-height: 420px; }
.hrp-rb-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; display: block; }
.hrp-room-block:hover .hrp-rb-img { transform: scale(1.05); }
.hrp-rb-price-badge { position: absolute; top: 20px; right: 20px; background: rgba(14,22,32,0.9); border: 1px solid rgba(197,160,89,0.3); border-radius: 12px; padding: 10px 16px; display: flex; flex-direction: column; align-items: center; backdrop-filter: blur(8px); }
.hrp-rb-from { font-size: 10px; font-family: 'Poppins', sans-serif; color: rgba(197,160,89,0.7); text-transform: uppercase; letter-spacing: 1px; }
.hrp-rb-price { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700; color: var(--gold); line-height: 1; }
.hrp-rb-night { font-size: 10px; font-family: 'Poppins', sans-serif; color: rgba(255,255,255,0.5); }
.hrp-rb-img-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(14,22,32,0.85) 0%, transparent 50%); display: flex; align-items: flex-end; padding: 20px; opacity: 0; transition: opacity 0.4s ease; }
.hrp-room-block:hover .hrp-rb-img-overlay { opacity: 1; }
.hrp-rb-quick-tags { display: flex; gap: 8px; flex-wrap: wrap; }
.hrp-rb-qtag { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.9); background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 50px; display: flex; align-items: center; gap: 5px; }
.hrp-rb-qtag i { color: var(--gold); font-size: 10px; }

/* Content side */
.hrp-rb-content-col { background: var(--white); display: flex; align-items: center; }
.hrp-rb-content { padding: 40px; width: 100%; }
.hrp-rb-meta-row { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; }
.hrp-rb-meta-tag { font-family: 'Poppins', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--gold); background: rgba(197,160,89,0.1); border: 1px solid rgba(197,160,89,0.2); padding: 4px 12px; border-radius: 50px; display: flex; align-items: center; gap: 5px; }
.hrp-rb-meta-tag i { font-size: 10px; }
.hrp-rb-name { font-family: 'Playfair Display', serif; font-size: clamp(22px,2.5vw,30px); font-weight: 700; color: var(--navy); margin-bottom: 14px; }
.hrp-rb-desc { font-size: 14.5px; color: var(--txt); line-height: 1.8; margin-bottom: 20px; }
.hrp-rb-features { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 24px; }
.hrp-rb-feat { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; font-family: 'Poppins', sans-serif; }
.hrp-rb-feat i { color: var(--gold); font-size: 10px; flex-shrink: 0; }
.hrp-rb-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.hrp-rb-wa-btn { display: inline-flex; align-items: center; gap: 8px; background: rgba(37,211,102,0.08); border: 1.5px solid rgba(37,211,102,0.35); color: #1a9e4a; font-family: 'Poppins', sans-serif; font-size: 13.5px; font-weight: 600; padding: 12px 22px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; }
.hrp-rb-wa-btn i { font-size: 16px; }
.hrp-rb-wa-btn:hover { background: #25D366; color: #fff; border-color: #25D366; }

/* ── STANDARD AMENITIES ─────────────────────────────────── */
.hrp-rooms-std-section { padding: 80px 0; }
.hrp-std-card { display: flex; align-items: center; gap: 16px; background: var(--white); border-radius: 14px; padding: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid rgba(197,160,89,0.1); transition: all 0.3s ease; height: 100%; }
.hrp-std-card:hover { border-color: rgba(197,160,89,0.3); transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
.hrp-std-icon { width: 48px; height: 48px; border-radius: 12px; background: rgba(197,160,89,0.1); border: 1px solid rgba(197,160,89,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.3s ease; }
.hrp-std-card:hover .hrp-std-icon { background: rgba(197,160,89,0.18); }
.hrp-std-icon i { color: var(--gold); font-size: 18px; }
.hrp-std-name { font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 3px; }
.hrp-std-desc { font-size: 12.5px; color: #888; margin: 0; }

/* ── CTA SECTION ────────────────────────────────────────── */
.hrp-rooms-cta-section { padding: 0 0 80px; background: var(--white); }
.hrp-rooms-cta-card { background: linear-gradient(135deg, #0E1620 0%, #1A222D 50%, #0E1620 100%); border-radius: 24px; padding: 72px 48px; position: relative; overflow: hidden; }
.hrp-rooms-cta-bg-deco { position: absolute; top: -80px; right: -80px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(197,160,89,0.07) 0%, transparent 70%); pointer-events: none; }
.hrp-rooms-cta-heading { font-family: 'Playfair Display', serif; font-size: clamp(28px,4vw,42px); color: #fff; margin-bottom: 12px; }
.hrp-rooms-cta-sub { font-size: 15px; color: rgba(255,255,255,0.65); max-width: 540px; margin: 0 auto 32px; line-height: 1.8; }
.hrp-rooms-cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 20px; }
.hrp-rooms-wa-cta { display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid rgba(37,211,102,0.5); color: #25D366; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; padding: 13px 28px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; }
.hrp-rooms-wa-cta i { font-size: 18px; }
.hrp-rooms-wa-cta:hover { background: #25D366; color: #fff; border-color: #25D366; }
.hrp-rooms-cta-note { font-size: 12.5px; color: rgba(255,255,255,0.4); font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; gap: 8px; }
.hrp-rooms-cta-note i { color: var(--gold); font-size: 11px; }

/* ── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 991px) {
    .hrp-room-block { grid-template-columns: 1fr; direction: ltr; }
    .hrp-rb-img-wrap { min-height: 280px; }
    .hrp-room-block--reverse { direction: ltr; }
}
@media (max-width: 767px) {
    .hrp-rb-features { grid-template-columns: 1fr; }
    .hrp-rb-content { padding: 24px; }
    .hrp-rb-actions { flex-direction: column; }
    .hrp-rooms-cta-card { padding: 40px 24px; }
    .hrp-rooms-cta-btns { flex-direction: column; align-items: stretch; }
    .hrp-rooms-filter-bar { flex-direction: column; align-items: stretch; }
    section { padding: 64px 0; }
}
</style>
@endsection

@section('extra_js')
<script>
// Filter rooms by type
document.querySelectorAll('.hrp-rfb-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.hrp-rfb-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        document.querySelectorAll('.hrp-room-block[data-type]').forEach(block => {
            if (filter === 'all' || block.dataset.type === filter) {
                block.style.display = 'grid';
                block.style.opacity = '1';
            } else {
                block.style.display = 'none';
            }
        });
    });
});

// Scroll-reveal animation
(function(){
    if(!('IntersectionObserver' in window)) return;
    const els = document.querySelectorAll('.hrp-room-block,.hrp-std-card');
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if(e.isIntersecting) {
                e.target.classList.add('hrp-revealed');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    els.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(24px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        io.observe(el);
    });
    document.head.insertAdjacentHTML('beforeend', '<style>.hrp-revealed{opacity:1!important;transform:none!important;}</style>');
})();
</script>
@endsection
