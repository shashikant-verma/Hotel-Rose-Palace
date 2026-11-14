@extends('layouts.app')

@section('title', 'Hotel Rose Palace — Luxury Hospitality in Surat, Gujarat')
@section('meta_description', 'Experience unparalleled luxury at Hotel Rose Palace, Surat. Premium rooms, world-class dining, 24/7 concierge, and curated experiences in the heart of Gujarat.')
@section('meta_keywords', 'luxury hotel surat, hotel rose palace, premium stay surat, 5 star hotel gujarat, corporate hotel surat')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     1. HERO SECTION
═══════════════════════════════════════════════════════ --}}
<section class="hrp-hero" id="hero">
    <div class="hrp-hero-overlay"></div>

    {{-- Animated Particles --}}
    <div class="hrp-particles">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="container hrp-hero-container">
        <div class="hrp-hero-content">

            {{-- Gold Eyebrow Tag --}}
            <div class="hrp-hero-eyebrow">
                <span class="hrp-eyebrow-line"></span>
                <span class="hrp-eyebrow-text">✦ Luxury Hospitality in Surat ✦</span>
                <span class="hrp-eyebrow-line"></span>
            </div>

            {{-- Main Headline --}}
            <h1 class="hrp-hero-title">
                Where Elegance<br>
                <em class="hrp-hero-title-em">Meets Comfort</em>
            </h1>

            <p class="hrp-hero-subtitle">
                An unforgettable sanctuary of refined luxury, curated experiences,<br class="d-none d-md-block">
                and warm Gujarati hospitality — nestled in the heart of Surat.
            </p>

            {{-- CTA Buttons --}}
            <div class="hrp-hero-ctas">
                <a href="{{ route('rooms') }}" class="hrp-btn-gold" id="explore-rooms-btn">
                    <i class="fas fa-bed me-2"></i> Explore Rooms
                </a>
                <a href="{{ route('gallery') }}" class="hrp-btn-outline-white" id="view-gallery-btn">
                    <i class="fas fa-images me-2"></i> View Gallery
                </a>
            </div>

            {{-- Scroll Indicator --}}
            <div class="hrp-scroll-hint">
                <div class="hrp-scroll-mouse">
                    <div class="hrp-scroll-wheel"></div>
                </div>
                <span>Scroll to explore</span>
            </div>
        </div>
    </div>

    {{-- Stats Overlay Band --}}
    <div class="hrp-hero-stats">
        <div class="container">
            <div class="hrp-stats-row">
                <div class="hrp-stat-item">
                    <span class="hrp-stat-number">50<span class="hrp-stat-plus">+</span></span>
                    <span class="hrp-stat-label">Luxury Rooms</span>
                </div>
                <div class="hrp-stat-divider"></div>
                <div class="hrp-stat-item">
                    <span class="hrp-stat-number">4.8<span class="hrp-stat-plus">★</span></span>
                    <span class="hrp-stat-label">Guest Rating</span>
                </div>
                <div class="hrp-stat-divider"></div>
                <div class="hrp-stat-item">
                    <span class="hrp-stat-number">24<span class="hrp-stat-plus">/7</span></span>
                    <span class="hrp-stat-label">Concierge & Dining</span>
                </div>
                <div class="hrp-stat-divider"></div>
                <div class="hrp-stat-item">
                    <span class="hrp-stat-number">5<span class="hrp-stat-plus">★</span></span>
                    <span class="hrp-stat-label">Premium Service</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     QUICK BOOKING BAR
═══════════════════════════════════════════════════════ --}}
<div class="hrp-booking-bar-wrap">
    <div class="container">
        <div class="hrp-booking-bar" id="booking-bar">
            <div class="hrp-booking-title">
                <i class="fas fa-calendar-check"></i>
                <span>Quick Availability Check</span>
            </div>
            <div class="hrp-booking-fields">
                <div class="hrp-booking-field">
                    <label for="checkin-date"><i class="fas fa-sign-in-alt"></i> Check-in</label>
                    <input type="date" id="checkin-date" class="hrp-date-input" min="{{ date('Y-m-d') }}">
                </div>
                <div class="hrp-booking-sep"><i class="fas fa-arrow-right"></i></div>
                <div class="hrp-booking-field">
                    <label for="checkout-date"><i class="fas fa-sign-out-alt"></i> Check-out</label>
                    <input type="date" id="checkout-date" class="hrp-date-input" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                <div class="hrp-booking-field">
                    <label for="guests-select"><i class="fas fa-users"></i> Guests</label>
                    <select id="guests-select" class="hrp-date-input">
                        <option value="1">1 Adult</option>
                        <option value="2" selected>2 Adults</option>
                        <option value="3">2 Adults + 1 Child</option>
                        <option value="4">2 Adults + 2 Children</option>
                        <option value="5">3+ Adults</option>
                    </select>
                </div>
                <button class="hrp-btn-check" id="check-availability-btn" onclick="checkAvailability()">
                    <i class="fas fa-search me-2"></i> Check Availability
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     2. WELCOME / ABOUT SECTION
═══════════════════════════════════════════════════════ --}}
<section class="hrp-welcome-section" id="welcome">
    <div class="container">
        <div class="row align-items-center g-5">

            {{-- Image Column --}}
            <div class="col-lg-5 col-md-12">
                <div class="hrp-welcome-img-frame">
                    <div class="hrp-img-gold-border"></div>
                    <img
                        src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=700&q=85"
                        alt="Hotel Rose Palace — Luxury Lobby Interior"
                        class="hrp-welcome-img"
                        loading="lazy"
                    >
                    {{-- Floating Badge --}}
                    <div class="hrp-img-badge">
                        <i class="fas fa-award"></i>
                        <div>
                            <span class="hrp-badge-num">4★</span>
                            <span class="hrp-badge-txt">Luxury Hotel</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Text Column --}}
            <div class="col-lg-7 col-md-12">
                <div class="hrp-welcome-text">
                    <div class="hrp-section-eyebrow">
                        <span class="hrp-eyebrow-dash"></span>
                        <span>Welcome to Luxury</span>
                        <span class="hrp-eyebrow-dash"></span>
                    </div>
                    <div class="hrp-gold-rule"></div>

                    <h2 class="hrp-section-heading">
                        Hotel Rose Palace —<br>
                        <span class="hrp-heading-em">A Sanctuary of Elegance</span>
                    </h2>

                    <p class="hrp-welcome-para">
                        Nestled on the vibrant VIP Road in Vesu, Surat, Hotel Rose Palace redefines luxury hospitality in Gujarat. Our meticulously designed spaces blend modern sophistication with warm, traditional Gujarati warmth.
                    </p>
                    <p class="hrp-welcome-para">
                        From our expertly crafted rooms and suites to our curated dining experiences and world-class amenities, every detail is thoughtfully designed to exceed your expectations and create memories that last a lifetime.
                    </p>

                    {{-- Key Stats Row --}}
                    <div class="hrp-welcome-stats">
                        <div class="hrp-ws-item">
                            <i class="fas fa-bed"></i>
                            <div>
                                <strong>50+</strong>
                                <span>Luxury Rooms</span>
                            </div>
                        </div>
                        <div class="hrp-ws-item">
                            <i class="fas fa-concierge-bell"></i>
                            <div>
                                <strong>24/7</strong>
                                <span>Concierge & Dining</span>
                            </div>
                        </div>
                        <div class="hrp-ws-item">
                            <i class="fas fa-star"></i>
                            <div>
                                <strong>4.8★</strong>
                                <span>Guest Rating</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('about') }}" class="hrp-btn-gold mt-4" id="learn-about-btn">
                        <i class="fas fa-info-circle me-2"></i> Discover Our Story
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     3. FEATURED ROOMS SECTION
═══════════════════════════════════════════════════════ --}}
<section class="hrp-rooms-section hrp-bg-cream" id="rooms">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Our Accommodations</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Exquisite Room Categories</h2>
            <p class="hrp-section-sub">Choose from our hand-curated selection of rooms and suites, each designed to offer the perfect blend of comfort and luxury.</p>
        </div>

        <div class="row g-4">
            @php
            $defaultRooms = [
                [
                    'name' => 'Deluxe Double Room',
                    'desc' => 'Spacious and elegantly appointed, our Deluxe Rooms feature a plush king-size bed, premium linens, smart TV, and a marble en-suite bathroom.',
                    'price' => '3,999',
                    'img' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80',
                    'bed' => 'King Bed',
                    'size' => '320 sq.ft',
                    'slug' => 'deluxe-double-room',
                    'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-snowflake','AC'],['fas fa-tv','Smart TV'],['fas fa-coffee','Breakfast']]
                ],
                [
                    'name' => 'Executive Suite',
                    'desc' => 'A perfect blend of business comfort and leisure. Includes a separate living area, work desk, premium minibar, and panoramic city views.',
                    'price' => '6,499',
                    'img' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600&q=80',
                    'bed' => 'King Bed + Sofa',
                    'size' => '540 sq.ft',
                    'slug' => 'executive-suite',
                    'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-snowflake','AC'],['fas fa-tv','Smart TV'],['fas fa-utensils','Dining']]
                ],
                [
                    'name' => 'Royal Palace Suite',
                    'desc' => 'The pinnacle of luxury. Features a grand bedroom, private jacuzzi, butler service, and bespoke amenities — crafted for discerning royalty.',
                    'price' => '12,999',
                    'img' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&q=80',
                    'bed' => 'Super King Bed',
                    'size' => '860 sq.ft',
                    'slug' => 'royal-palace-suite',
                    'icons' => [['fas fa-wifi','Wi-Fi'],['fas fa-bath','Jacuzzi'],['fas fa-concierge-bell','Butler'],['fas fa-utensils','Fine Dining']]
                ],
            ];
            @endphp

            @forelse($featuredRooms as $room)
                <div class="col-lg-4 col-md-6">
                    <div class="hrp-room-card">
                        <div class="hrp-room-img-wrap">
                            <img
                                src="{{ $room->featuredImage?->image_url ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80' }}"
                                alt="{{ $room->roomType->name }}"
                                class="hrp-room-img"
                                loading="lazy"
                            >
                            <div class="hrp-room-price-badge">₹{{ number_format($room->current_price, 0) }} <span>/Night</span></div>
                            <div class="hrp-room-img-overlay">
                                <a href="{{ route('room-detail', $room->roomType->slug) }}" class="hrp-room-quick-view" id="room-detail-{{ $room->id }}">
                                    <i class="fas fa-eye"></i> Quick View
                                </a>
                            </div>
                        </div>
                        <div class="hrp-room-body">
                            <h3 class="hrp-room-name">{{ $room->roomType->name }}</h3>
                            <p class="hrp-room-desc">{{ Str::limit($room->roomType->description, 90) }}</p>
                            <div class="hrp-room-icons">
                                <span class="hrp-room-icon"><i class="fas fa-bed"></i> {{ $room->roomType->max_adults ?? 2 }} Adults</span>
                                <span class="hrp-room-icon"><i class="fas fa-wifi"></i> Wi-Fi</span>
                                <span class="hrp-room-icon"><i class="fas fa-snowflake"></i> AC</span>
                                <span class="hrp-room-icon"><i class="fas fa-coffee"></i> Breakfast</span>
                            </div>
                            <div class="hrp-room-actions">
                                <a href="{{ route('room-detail', $room->roomType->slug) }}" class="hrp-room-btn-secondary" id="view-details-{{ $room->id }}">View Details</a>
                                <a href="{{ route('rooms') }}" class="hrp-room-btn-primary" id="book-now-{{ $room->id }}">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Realistic Fallback Cards --}}
                @foreach($defaultRooms as $i => $dr)
                <div class="col-lg-4 col-md-6">
                    <div class="hrp-room-card">
                        <div class="hrp-room-img-wrap">
                            <img src="{{ $dr['img'] }}" alt="{{ $dr['name'] }}" class="hrp-room-img" loading="lazy">
                            <div class="hrp-room-price-badge">₹{{ $dr['price'] }} <span>/Night</span></div>
                            <div class="hrp-room-img-overlay">
                                <a href="{{ route('rooms') }}" class="hrp-room-quick-view" id="room-quick-view-{{ $i }}">
                                    <i class="fas fa-eye"></i> Quick View
                                </a>
                            </div>
                        </div>
                        <div class="hrp-room-body">
                            <h3 class="hrp-room-name">{{ $dr['name'] }}</h3>
                            <p class="hrp-room-desc">{{ $dr['desc'] }}</p>
                            <div class="hrp-room-icons">
                                @foreach($dr['icons'] as $icon)
                                    <span class="hrp-room-icon"><i class="{{ $icon[0] }}"></i> {{ $icon[1] }}</span>
                                @endforeach
                            </div>
                            <div class="hrp-room-meta">
                                <span class="hrp-rm-tag"><i class="fas fa-bed"></i> {{ $dr['bed'] }}</span>
                                <span class="hrp-rm-tag"><i class="fas fa-ruler-combined"></i> {{ $dr['size'] }}</span>
                            </div>
                            <div class="hrp-room-actions">
                                <a href="{{ route('rooms') }}" class="hrp-room-btn-secondary" id="default-room-details-{{ $i }}">View Details</a>
                                <a href="{{ route('rooms') }}" class="hrp-room-btn-primary" id="default-room-book-{{ $i }}">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('rooms') }}" class="hrp-btn-outline-navy" id="view-all-rooms-btn">
                View All Rooms & Suites <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     4. AMENITIES SECTION (Dark Navy)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-amenities-section" id="amenities">
    <div class="container">
        <div class="hrp-section-header text-center" style="color:#fff;">
            <div class="hrp-section-eyebrow justify-content-center" style="color:#C5A059;">
                <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
                <span>Premium Facilities</span>
                <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading" style="color:#fff;">World-Class Amenities</h2>
            <p class="hrp-section-sub" style="color:rgba(255,255,255,0.65);">Experience comfort and convenience with our premium facilities, designed to elevate your stay to extraordinary heights.</p>
        </div>

        <div class="row g-4">
            @php
            $defaultAmenities = [
                ['icon'=>'fas fa-wifi','name'=>'Free Wi-Fi','desc'=>'High-speed internet throughout the hotel'],
                ['icon'=>'fas fa-parking','name'=>'Free Parking','desc'=>'Secure complimentary parking for all guests'],
                ['icon'=>'fas fa-concierge-bell','name'=>'24/7 Concierge','desc'=>'Round-the-clock personalised service'],
                ['icon'=>'fas fa-utensils','name'=>'Restaurant & Bar','desc'=>'Multi-cuisine dining with curated menus'],
                ['icon'=>'fas fa-spa','name'=>'Spa & Wellness','desc'=>'Rejuvenate with our signature treatments'],
                ['icon'=>'fas fa-dumbbell','name'=>'Fitness Centre','desc'=>'State-of-the-art gym & yoga studio'],
                ['icon'=>'fas fa-tshirt','name'=>'Laundry Service','desc'=>'Premium dry cleaning & laundry'],
                ['icon'=>'fas fa-shield-alt','name'=>'24/7 Security','desc'=>'Full CCTV & security personnel coverage'],
            ];
            @endphp

            @forelse($amenities as $amenity)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="hrp-amenity-card">
                        <div class="hrp-amenity-icon-wrap">
                            <i class="{{ $amenity->icon_class ?? 'fas fa-star' }}"></i>
                        </div>
                        <div class="hrp-amenity-body">
                            <h5 class="hrp-amenity-name">{{ $amenity->name }}</h5>
                            <p class="hrp-amenity-desc">{{ $amenity->description ?: 'Available for all hotel guests' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                @foreach($defaultAmenities as $i => $da)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="hrp-amenity-card">
                        <div class="hrp-amenity-icon-wrap">
                            <i class="{{ $da['icon'] }}"></i>
                        </div>
                        <div class="hrp-amenity-body">
                            <h5 class="hrp-amenity-name">{{ $da['name'] }}</h5>
                            <p class="hrp-amenity-desc">{{ $da['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('amenities') }}" class="hrp-btn-gold-outline" id="all-amenities-btn">
                All Amenities <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     5. CURATED EXPERIENCES & OFFERS
═══════════════════════════════════════════════════════ --}}
<section class="hrp-experiences-section hrp-bg-cream" id="experiences">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Special Packages</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Curated Experiences</h2>
            <p class="hrp-section-sub">From corporate retreats to romantic getaways — we craft bespoke experiences tailored to your desires.</p>
        </div>

        <div class="row g-4">
            @php
            $experiences = [
                [
                    'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80',
                    'tag' => 'Business',
                    'icon' => 'fas fa-briefcase',
                    'title' => 'Corporate Stays',
                    'desc' => 'Purpose-built for business travellers — high-speed Wi-Fi, meeting rooms, express check-in, and tailored corporate billing.',
                    'wa' => 'I am interested in Corporate Stay packages at Hotel Rose Palace. Please share details.',
                    'id' => 'exp-corporate'
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600&q=80',
                    'tag' => 'Events',
                    'icon' => 'fas fa-glass-cheers',
                    'title' => 'Banquet & Events',
                    'desc' => 'From intimate gatherings to grand celebrations — our elegant banquet halls and expert event planners ensure a flawless event.',
                    'wa' => 'I would like to enquire about Banquet and Event spaces at Hotel Rose Palace.',
                    'id' => 'exp-banquet'
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&q=80',
                    'tag' => 'Leisure',
                    'icon' => 'fas fa-umbrella-beach',
                    'title' => 'Weekend Getaways',
                    'desc' => 'Recharge with our exclusive weekend packages — spa access, special dining, late check-out, and curated local experiences.',
                    'wa' => 'I am interested in Weekend Getaway packages at Hotel Rose Palace. Please send details.',
                    'id' => 'exp-weekend'
                ],
            ];
            $waBase = 'https://wa.me/' . preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) . '?text=';
            @endphp

            @foreach($experiences as $exp)
            <div class="col-lg-4 col-md-6">
                <div class="hrp-exp-card" id="{{ $exp['id'] }}">
                    <div class="hrp-exp-img-wrap">
                        <img src="{{ $exp['img'] }}" alt="{{ $exp['title'] }}" class="hrp-exp-img" loading="lazy">
                        <div class="hrp-exp-tag">
                            <i class="{{ $exp['icon'] }}"></i> {{ $exp['tag'] }}
                        </div>
                    </div>
                    <div class="hrp-exp-body">
                        <h4 class="hrp-exp-title">{{ $exp['title'] }}</h4>
                        <p class="hrp-exp-desc">{{ $exp['desc'] }}</p>
                        <a href="{{ $waBase . urlencode($exp['wa']) }}" target="_blank" class="hrp-exp-wa-btn" id="{{ $exp['id'] }}-wa">
                            <i class="fab fa-whatsapp"></i> Enquire on WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     6. GALLERY HIGHLIGHTS (Bento / Masonry Grid)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-gallery-section" id="gallery">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Visual Journey</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Gallery Highlights</h2>
            <p class="hrp-section-sub">A visual journey through the exquisite spaces and experiences that define Hotel Rose Palace.</p>
        </div>

        @php
        $fallbackGallery = [
            ['url'=>'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=700&q=80','title'=>'Luxury Suite'],
            ['url'=>'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=700&q=80','title'=>'Fine Dining'],
            ['url'=>'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=700&q=80','title'=>'Premium Lobby'],
            ['url'=>'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=700&q=80','title'=>'Royal Suite'],
            ['url'=>'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=700&q=80','title'=>'Spa & Wellness'],
            ['url'=>'https://images.unsplash.com/photo-1512918728672-f9d96f4fff8c?w=700&q=80','title'=>'City View Room'],
        ];
        $galleryItems = $galleryImages->count() > 0
            ? $galleryImages->take(6)->map(fn($g) => ['url' => \Storage::url($g->image_path), 'title' => $g->title ?? 'Gallery'])
            : collect($fallbackGallery);
        @endphp

        <div class="hrp-bento-grid">
            @foreach($galleryItems as $i => $gImg)
            <div class="hrp-bento-item hrp-bento-item--{{ $i }}" onclick="openLightbox('{{ $gImg['url'] }}','{{ addslashes($gImg['title']) }}')" id="gallery-item-{{ $i }}">
                <img src="{{ $gImg['url'] }}" alt="{{ $gImg['title'] }}" class="hrp-bento-img" loading="lazy">
                <div class="hrp-bento-overlay">
                    <span class="hrp-bento-label">{{ $gImg['title'] }}</span>
                    <i class="fas fa-expand hrp-bento-icon"></i>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('gallery') }}" class="hrp-btn-outline-navy" id="view-full-gallery-btn">
                <i class="fas fa-images me-2"></i> View Full Gallery
            </a>
        </div>
    </div>

    {{-- Lightbox --}}
    <div class="hrp-lightbox" id="hrp-lightbox" onclick="closeLightbox()">
        <button class="hrp-lightbox-close" onclick="closeLightbox()" id="close-lightbox-btn"><i class="fas fa-times"></i></button>
        <img src="" alt="" class="hrp-lightbox-img" id="lightbox-img">
        <div class="hrp-lightbox-caption" id="lightbox-caption"></div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     7. GUEST TESTIMONIALS
═══════════════════════════════════════════════════════ --}}
<section class="hrp-testimonials-section hrp-bg-cream" id="testimonials">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Guest Voices</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">What Our Guests Say</h2>
            <p class="hrp-section-sub">Real experiences shared by our valued guests — the trust and satisfaction of every visitor fuels our passion for excellence.</p>
        </div>

        <div class="row g-4">
            @php
            $testimonials = [
                ['name'=>'Sarah Johnson','loc'=>'New York, USA','init'=>'SJ','color'=>'#C5A059','review'=>'"Hotel Rose Palace exceeded every expectation. The staff\'s attentiveness, the room\'s opulence, and the dining — simply extraordinary. A must-stay in Surat!"'],
                ['name'=>'Priya Patel','loc'=>'Mumbai, India','init'=>'PP','color'=>'#9B59B6','review'=>'"A perfect harmony of luxury and warmth. The restaurant serves exceptional cuisine, and the ambiance transports you to a world of pure relaxation. Absolutely wonderful!"'],
                ['name'=>'David Chen','loc'=>'Singapore','init'=>'DC','color'=>'#1A7A5E','review'=>'"Outstanding hospitality from check-in to check-out. Every single detail was immaculate. We\'ve stayed at five-star hotels worldwide — Rose Palace stands apart."'],
            ];
            @endphp

            @foreach($testimonials as $i => $t)
            <div class="col-lg-4 col-md-6">
                <div class="hrp-testi-card" id="testimonial-{{ $i }}">
                    {{-- Gold Quote Watermark --}}
                    <div class="hrp-testi-quote-mark"><i class="fas fa-quote-right"></i></div>

                    {{-- Stars --}}
                    <div class="hrp-testi-stars">
                        @for($s=0;$s<5;$s++) <i class="fas fa-star"></i> @endfor
                    </div>

                    <p class="hrp-testi-text">{{ $t['review'] }}</p>

                    <div class="hrp-testi-author">
                        <div class="hrp-testi-avatar" style="background:{{ $t['color'] }};">{{ $t['init'] }}</div>
                        <div>
                            <strong class="hrp-testi-name">{{ $t['name'] }}</strong>
                            <span class="hrp-testi-loc"><i class="fas fa-map-marker-alt"></i> {{ $t['loc'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     8. LOCATION SECTION
═══════════════════════════════════════════════════════ --}}
<section class="hrp-location-section" id="location">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Find Us</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Our Location</h2>
            <p class="hrp-section-sub">Conveniently situated in the premium Vesu area of Surat — easily accessible from the airport, railway station, and city centre.</p>
        </div>

        <div class="row g-5 align-items-stretch">
            {{-- Map --}}
            <div class="col-lg-7">
                <div class="hrp-map-wrap">
                    <iframe
                        title="Hotel Rose Palace Location"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.139!2d72.792!3d21.146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e0bb55f9c3b%3A0x2b0e21e2a34a4c38!2sAtlanta%20Business%20Hub%2C%20VIP%20Rd%2C%20Vesu%2C%20Surat%2C%20Gujarat%20395007!5e0!3m2!1sen!2sin!4v1699999999999!5m2!1sen!2sin"
                        class="hrp-map-iframe"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        id="hotel-map"
                    ></iframe>
                    <div class="hrp-map-pin">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
            </div>

            {{-- Contact Details --}}
            <div class="col-lg-5">
                <div class="hrp-location-card">
                    <h3 class="hrp-location-title">Hotel Rose Palace</h3>
                    <p class="hrp-location-subtitle">Your Luxury Home Away From Home</p>

                    <div class="hrp-location-details">
                        <div class="hrp-loc-row">
                            <div class="hrp-loc-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <span class="hrp-loc-label">Address</span>
                                <span class="hrp-loc-val">4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007</span>
                            </div>
                        </div>
                        <div class="hrp-loc-row">
                            <div class="hrp-loc-icon"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <span class="hrp-loc-label">Phone</span>
                                <a href="tel:{{ config('hotel.contact.phone_1') }}" class="hrp-loc-val hrp-loc-link">{{ config('hotel.contact.phone_1') }}</a>
                                <a href="tel:{{ config('hotel.contact.phone_2') }}" class="hrp-loc-val hrp-loc-link">{{ config('hotel.contact.phone_2') }}</a>
                            </div>
                        </div>
                        <div class="hrp-loc-row">
                            <div class="hrp-loc-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <span class="hrp-loc-label">Email</span>
                                <a href="mailto:{{ config('hotel.contact.email') }}" class="hrp-loc-val hrp-loc-link">{{ config('hotel.contact.email') }}</a>
                            </div>
                        </div>
                        <div class="hrp-loc-row">
                            <div class="hrp-loc-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <span class="hrp-loc-label">Reception</span>
                                <span class="hrp-loc-val">Open 24 Hours, 7 Days a Week</span>
                            </div>
                        </div>
                    </div>

                    <div class="hrp-location-ctas">
                        <a href="{{ route('contact') }}" class="hrp-btn-gold" id="get-in-touch-btn">
                            <i class="fas fa-paper-plane me-2"></i> Get In Touch
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}" target="_blank" class="hrp-loc-wa-btn" id="location-wa-btn">
                            <i class="fab fa-whatsapp"></i> WhatsApp Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- ═══════════════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════════════ --}}
@section('extra_css')
<style>
/* ── Design Tokens ──────────────────────────────────────── */
:root {
    --navy:   #1A222D;
    --gold:   #C5A059;
    --gold-lt:#e8c97a;
    --cream:  #F8F6F2;
    --white:  #FFFFFF;
    --dark:   #0E1620;
    --txt:    #4A5568;
    --r-sm: 10px;
    --r-md: 16px;
    --r-lg: 24px;
}

/* ── Shared Components ──────────────────────────────────── */
.hrp-bg-cream { background: var(--cream); }

.hrp-section-eyebrow {
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 8px;
}
.hrp-eyebrow-dash {
    flex: 1;
    max-width: 40px;
    height: 1.5px;
    background: var(--gold);
    border-radius: 2px;
}
.hrp-gold-rule {
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--gold-lt));
    border-radius: 2px;
    margin: 10px 0 20px;
}
.hrp-gold-rule--center { margin: 10px auto 24px; }

.hrp-section-heading {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px,4vw,40px);
    color: var(--navy);
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.25;
}
.hrp-heading-em { color: var(--gold); font-style: italic; }

.hrp-section-sub {
    font-size: 15.5px;
    color: var(--txt);
    max-width: 620px;
    margin: 0 auto 48px;
    line-height: 1.75;
}

.hrp-section-header { margin-bottom: 0; }

/* Buttons */
.hrp-btn-gold {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    color: var(--navy);
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 14.5px;
    padding: 14px 32px;
    border-radius: 50px;
    text-decoration: none;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(197,160,89,0.35);
    white-space: nowrap;
}
.hrp-btn-gold:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(197,160,89,0.5);
    color: var(--navy);
}
.hrp-btn-outline-white {
    display: inline-flex;
    align-items: center;
    background: transparent;
    border: 2px solid rgba(255,255,255,0.7);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 14.5px;
    padding: 14px 32px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-btn-outline-white:hover {
    background: rgba(255,255,255,0.15);
    border-color: #fff;
    color: #fff;
    transform: translateY(-3px);
}
.hrp-btn-outline-navy {
    display: inline-flex;
    align-items: center;
    background: transparent;
    border: 2px solid var(--navy);
    color: var(--navy);
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 14.5px;
    padding: 13px 32px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-btn-outline-navy:hover {
    background: var(--navy);
    color: var(--gold);
    transform: translateY(-2px);
}
.hrp-btn-gold-outline {
    display: inline-flex;
    align-items: center;
    border: 2px solid var(--gold);
    color: var(--gold);
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 14.5px;
    padding: 12px 30px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-btn-gold-outline:hover {
    background: var(--gold);
    color: var(--navy);
    transform: translateY(-2px);
}

/* ── 1. HERO ────────────────────────────────────────────── */
.hrp-hero {
    position: relative;
    min-height: 100vh;
    min-height: 100dvh;
    background: linear-gradient(165deg, rgba(14,22,32,0.82) 0%, rgba(14,22,32,0.6) 50%, rgba(197,160,89,0.15) 100%),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&q=90') center/cover no-repeat;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hrp-hero-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 20% 50%, rgba(197,160,89,0.08) 0%, transparent 60%);
    pointer-events: none;
}

/* Animated gold particles */
.hrp-particles { position: absolute; inset: 0; pointer-events: none; }
.hrp-particles span {
    position: absolute;
    display: block;
    border-radius: 50%;
    background: rgba(197,160,89,0.3);
    animation: hrpFloat 8s ease-in-out infinite;
}
.hrp-particles span:nth-child(1){width:6px;height:6px;top:20%;left:15%;animation-delay:0s;}
.hrp-particles span:nth-child(2){width:4px;height:4px;top:60%;left:80%;animation-delay:2s;}
.hrp-particles span:nth-child(3){width:8px;height:8px;top:75%;left:30%;animation-delay:4s;}
.hrp-particles span:nth-child(4){width:5px;height:5px;top:35%;left:65%;animation-delay:1s;}
.hrp-particles span:nth-child(5){width:3px;height:3px;top:50%;left:50%;animation-delay:3s;}
@keyframes hrpFloat {
    0%,100% { transform: translateY(0) scale(1); opacity: 0.4; }
    50% { transform: translateY(-20px) scale(1.3); opacity: 0.9; }
}

.hrp-hero-container { position: relative; z-index: 2; padding-top: 80px; }
.hrp-hero-content { text-align: center; max-width: 820px; margin: 0 auto; }

/* Eyebrow */
.hrp-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 24px;
}
.hrp-eyebrow-line {
    display: block;
    width: 40px;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold));
}
.hrp-eyebrow-line:last-child { background: linear-gradient(90deg, var(--gold), transparent); }

.hrp-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(44px, 7vw, 80px);
    font-weight: 700;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 24px;
    text-shadow: 0 2px 40px rgba(0,0,0,0.3);
}
.hrp-hero-title-em {
    font-style: italic;
    color: var(--gold);
    display: block;
}
.hrp-hero-subtitle {
    font-size: clamp(15px, 2vw, 18px);
    color: rgba(255,255,255,0.8);
    line-height: 1.8;
    margin-bottom: 40px;
}

.hrp-hero-ctas {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 48px;
}

/* Scroll hint */
.hrp-scroll-hint {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.5);
    font-size: 11px;
    font-family: 'Poppins', sans-serif;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.hrp-scroll-mouse {
    width: 24px;
    height: 38px;
    border: 2px solid rgba(197,160,89,0.5);
    border-radius: 12px;
    display: flex;
    justify-content: center;
    padding-top: 6px;
}
.hrp-scroll-wheel {
    width: 3px;
    height: 8px;
    background: var(--gold);
    border-radius: 2px;
    animation: hrpScroll 1.8s ease-in-out infinite;
}
@keyframes hrpScroll { 0%,100%{opacity:1;transform:translateY(0)} 50%{opacity:0;transform:translateY(8px)} }

/* Hero Stats Band */
.hrp-hero-stats {
    position: relative;
    z-index: 2;
    width: 100%;
    background: linear-gradient(90deg, rgba(14,22,32,0.95), rgba(26,34,45,0.95));
    border-top: 1px solid rgba(197,160,89,0.2);
    padding: 20px 0;
    margin-top: auto;
}
.hrp-stats-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0;
    flex-wrap: wrap;
}
.hrp-stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px 36px;
    min-width: 140px;
}
.hrp-stat-number {
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    font-weight: 700;
    color: var(--gold);
    line-height: 1;
    margin-bottom: 4px;
}
.hrp-stat-plus { font-size: 18px; }
.hrp-stat-label {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-family: 'Poppins', sans-serif;
}
.hrp-stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(197,160,89,0.2);
}

/* ── BOOKING BAR ────────────────────────────────────────── */
.hrp-booking-bar-wrap {
    background: var(--white);
    padding: 0 0 0;
    position: relative;
    z-index: 10;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}
.hrp-booking-bar {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px 28px;
    background: var(--white);
    border-top: 3px solid var(--gold);
    flex-wrap: wrap;
}
.hrp-booking-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Playfair Display', serif;
    font-size: 15px;
    font-weight: 700;
    color: var(--navy);
    white-space: nowrap;
    min-width: 190px;
}
.hrp-booking-title i { color: var(--gold); font-size: 18px; }
.hrp-booking-fields {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    flex-wrap: wrap;
}
.hrp-booking-field {
    display: flex;
    flex-direction: column;
    gap: 3px;
    min-width: 150px;
    flex: 1;
}
.hrp-booking-field label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--gold);
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 0;
}
.hrp-date-input {
    border: 1.5px solid #E2D9C8;
    border-radius: 8px;
    padding: 9px 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    color: var(--navy);
    background: #FAFAF8;
    width: 100%;
    transition: border-color 0.25s ease;
    outline: none;
    margin: 0;
}
.hrp-date-input:focus { border-color: var(--gold); }
.hrp-booking-sep { color: rgba(197,160,89,0.5); font-size: 14px; }
.hrp-btn-check {
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    color: var(--navy);
    border: none;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 28px;
    border-radius: 50px;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(197,160,89,0.3);
    display: inline-flex;
    align-items: center;
}
.hrp-btn-check:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(197,160,89,0.45); }

/* ── 2. WELCOME ─────────────────────────────────────────── */
.hrp-welcome-section {
    padding: 96px 0;
    background: var(--white);
}
.hrp-welcome-img-frame {
    position: relative;
    padding-bottom: 32px;
    padding-right: 32px;
}
.hrp-img-gold-border {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 85%;
    height: 85%;
    border: 3px solid var(--gold);
    border-radius: var(--r-md);
    opacity: 0.4;
    z-index: 0;
}
.hrp-welcome-img {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 480px;
    object-fit: cover;
    border-radius: var(--r-md);
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}
.hrp-img-badge {
    position: absolute;
    bottom: 48px;
    right: 48px;
    z-index: 2;
    background: var(--white);
    border-radius: 12px;
    padding: 12px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    border-left: 4px solid var(--gold);
}
.hrp-img-badge i { color: var(--gold); font-size: 22px; }
.hrp-badge-num { display: block; font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: var(--navy); line-height: 1; }
.hrp-badge-txt { display: block; font-size: 11px; color: #888; font-family: 'Poppins', sans-serif; }

.hrp-welcome-text { padding-left: 24px; }
.hrp-welcome-para { font-size: 15.5px; line-height: 1.85; color: var(--txt); margin-bottom: 16px; }

.hrp-welcome-stats {
    display: flex;
    gap: 24px;
    padding: 24px;
    background: var(--cream);
    border-radius: var(--r-md);
    border-left: 4px solid var(--gold);
    flex-wrap: wrap;
    margin-top: 28px;
}
.hrp-ws-item {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 120px;
}
.hrp-ws-item i { font-size: 24px; color: var(--gold); }
.hrp-ws-item strong { display: block; font-family: 'Playfair Display', serif; font-size: 20px; color: var(--navy); }
.hrp-ws-item span { display: block; font-size: 12px; color: #888; font-family: 'Poppins', sans-serif; }

/* ── 3. ROOMS ───────────────────────────────────────────── */
.hrp-rooms-section { padding: 96px 0; }

.hrp-room-card {
    background: var(--white);
    border-radius: var(--r-md);
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.hrp-room-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.14);
}
.hrp-room-img-wrap {
    position: relative;
    overflow: hidden;
    height: 240px;
}
.hrp-room-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.hrp-room-card:hover .hrp-room-img { transform: scale(1.08); }

.hrp-room-price-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    color: var(--navy);
    font-family: 'Playfair Display', serif;
    font-size: 15px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 50px;
    box-shadow: 0 4px 14px rgba(197,160,89,0.4);
}
.hrp-room-price-badge span { font-size: 11px; font-family: 'Poppins', sans-serif; font-weight: 500; }

.hrp-room-img-overlay {
    position: absolute;
    inset: 0;
    background: rgba(14,22,32,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.hrp-room-card:hover .hrp-room-img-overlay { opacity: 1; }
.hrp-room-quick-view {
    background: rgba(255,255,255,0.15);
    border: 1.5px solid rgba(255,255,255,0.6);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 22px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.25s ease;
}
.hrp-room-quick-view:hover { background: var(--gold); border-color: var(--gold); color: var(--navy); }

.hrp-room-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
.hrp-room-name {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    color: var(--navy);
    margin-bottom: 10px;
}
.hrp-room-desc { font-size: 13.5px; color: var(--txt); line-height: 1.65; margin-bottom: 14px; flex: 1; }
.hrp-room-icons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}
.hrp-room-icon {
    font-size: 11.5px;
    color: #666;
    background: var(--cream);
    padding: 4px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.hrp-room-icon i { color: var(--gold); font-size: 10px; }
.hrp-room-meta { display: flex; gap: 10px; margin-bottom: 14px; flex-wrap: wrap; }
.hrp-rm-tag {
    font-size: 12px;
    color: var(--navy);
    background: rgba(197,160,89,0.1);
    border: 1px solid rgba(197,160,89,0.2);
    padding: 4px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.hrp-rm-tag i { color: var(--gold); }
.hrp-room-actions { display: flex; gap: 10px; margin-top: auto; }
.hrp-room-btn-primary {
    flex: 1;
    text-align: center;
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    color: var(--navy);
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 700;
    padding: 11px 16px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-room-btn-primary:hover { transform: translateY(-2px); color: var(--navy); box-shadow: 0 4px 14px rgba(197,160,89,0.4); }
.hrp-room-btn-secondary {
    flex: 1;
    text-align: center;
    border: 1.5px solid var(--navy);
    color: var(--navy);
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 16px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-room-btn-secondary:hover { background: var(--navy); color: var(--gold); }

/* ── 4. AMENITIES ───────────────────────────────────────── */
.hrp-amenities-section {
    padding: 96px 0;
    background: linear-gradient(160deg, #0E1620 0%, #1A222D 60%, #0E1620 100%);
    position: relative;
    overflow: hidden;
}
.hrp-amenities-section::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(197,160,89,0.06) 0%, transparent 70%);
    pointer-events: none;
}

.hrp-amenity-card {
    background: rgba(34,43,56,0.8);
    border: 1px solid rgba(197,160,89,0.18);
    border-radius: var(--r-md);
    padding: 28px 22px;
    display: flex;
    align-items: flex-start;
    gap: 18px;
    transition: all 0.35s ease;
    backdrop-filter: blur(4px);
    height: 100%;
}
.hrp-amenity-card:hover {
    border-color: rgba(197,160,89,0.5);
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.3);
    background: rgba(34,43,56,1);
}
.hrp-amenity-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: rgba(197,160,89,0.12);
    border: 1px solid rgba(197,160,89,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.hrp-amenity-card:hover .hrp-amenity-icon-wrap {
    background: rgba(197,160,89,0.2);
    box-shadow: 0 0 20px rgba(197,160,89,0.3);
}
.hrp-amenity-icon-wrap i { color: var(--gold); font-size: 20px; }
.hrp-amenity-name {
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 6px;
}
.hrp-amenity-desc { font-size: 13px; color: rgba(255,255,255,0.5); margin: 0; line-height: 1.6; }

/* ── 5. EXPERIENCES ─────────────────────────────────────── */
.hrp-experiences-section { padding: 96px 0; }
.hrp-exp-card {
    background: var(--white);
    border-radius: var(--r-md);
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.hrp-exp-card:hover { transform: translateY(-8px); box-shadow: 0 20px 60px rgba(0,0,0,0.13); }
.hrp-exp-img-wrap { position: relative; overflow: hidden; height: 220px; }
.hrp-exp-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.hrp-exp-card:hover .hrp-exp-img { transform: scale(1.06); }
.hrp-exp-tag {
    position: absolute;
    top: 16px;
    left: 16px;
    background: rgba(14,22,32,0.85);
    color: var(--gold);
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 50px;
    border: 1px solid rgba(197,160,89,0.3);
    display: flex;
    align-items: center;
    gap: 6px;
}
.hrp-exp-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
.hrp-exp-title { font-family: 'Playfair Display', serif; font-size: 20px; color: var(--navy); margin-bottom: 10px; }
.hrp-exp-desc { font-size: 14px; color: var(--txt); line-height: 1.7; flex: 1; margin-bottom: 20px; }
.hrp-exp-wa-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(37,211,102,0.1);
    border: 1.5px solid rgba(37,211,102,0.4);
    color: #1a9e4a;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    align-self: flex-start;
}
.hrp-exp-wa-btn:hover { background: #25D366; color: #fff; border-color: #25D366; }
.hrp-exp-wa-btn i { font-size: 16px; }

/* ── 6. GALLERY BENTO ───────────────────────────────────── */
.hrp-gallery-section { padding: 96px 0; background: var(--white); }

.hrp-bento-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: repeat(2, 260px);
    gap: 12px;
    margin-bottom: 0;
}
.hrp-bento-item {
    position: relative;
    overflow: hidden;
    border-radius: var(--r-sm);
    cursor: pointer;
}
.hrp-bento-item--0 { grid-column: 1/6; grid-row: 1/2; }
.hrp-bento-item--1 { grid-column: 6/9; grid-row: 1/2; }
.hrp-bento-item--2 { grid-column: 9/13; grid-row: 1/3; }
.hrp-bento-item--3 { grid-column: 1/4; grid-row: 2/3; }
.hrp-bento-item--4 { grid-column: 4/6; grid-row: 2/3; }
.hrp-bento-item--5 { grid-column: 6/9; grid-row: 2/3; }

.hrp-bento-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.hrp-bento-item:hover .hrp-bento-img { transform: scale(1.08); }

.hrp-bento-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(14,22,32,0.85) 0%, transparent 50%);
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 18px;
    opacity: 0;
    transition: opacity 0.35s ease;
}
.hrp-bento-item:hover .hrp-bento-overlay { opacity: 1; }
.hrp-bento-label {
    color: #fff;
    font-family: 'Playfair Display', serif;
    font-size: 15px;
    font-weight: 600;
}
.hrp-bento-icon { color: var(--gold); font-size: 18px; }

/* Lightbox */
.hrp-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.95);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 16px;
}
.hrp-lightbox.active { display: flex; }
.hrp-lightbox-img { max-width: 90vw; max-height: 80vh; border-radius: 8px; }
.hrp-lightbox-caption { color: rgba(255,255,255,0.7); font-family: 'Playfair Display', serif; font-size: 16px; }
.hrp-lightbox-close {
    position: absolute;
    top: 24px;
    right: 24px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    color: #fff;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
}
.hrp-lightbox-close:hover { background: rgba(197,160,89,0.3); border-color: var(--gold); color: var(--gold); }

/* ── 7. TESTIMONIALS ────────────────────────────────────── */
.hrp-testimonials-section { padding: 96px 0; }
.hrp-testi-card {
    background: #FAF8F5;
    border: 1.5px solid transparent;
    border-radius: var(--r-md);
    padding: 32px;
    position: relative;
    overflow: hidden;
    transition: all 0.35s ease;
    height: 100%;
}
.hrp-testi-card:hover { border-color: rgba(197,160,89,0.4); transform: translateY(-6px); box-shadow: 0 16px 50px rgba(0,0,0,0.09); }

.hrp-testi-quote-mark {
    position: absolute;
    top: 16px;
    right: 20px;
    font-size: 56px;
    color: rgba(197,160,89,0.12);
    line-height: 1;
    pointer-events: none;
}
.hrp-testi-stars { color: var(--gold); font-size: 14px; letter-spacing: 2px; margin-bottom: 16px; }
.hrp-testi-text {
    font-family: 'Playfair Display', serif;
    font-size: 15.5px;
    font-style: italic;
    color: #4A4A4A;
    line-height: 1.8;
    margin-bottom: 24px;
}
.hrp-testi-author { display: flex; align-items: center; gap: 14px; }
.hrp-testi-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    font-weight: 700;
    flex-shrink: 0;
}
.hrp-testi-name { display: block; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; color: var(--navy); }
.hrp-testi-loc { display: flex; align-items: center; gap: 5px; font-size: 12px; color: #888; }
.hrp-testi-loc i { color: var(--gold); font-size: 10px; }

/* ── 8. LOCATION ────────────────────────────────────────── */
.hrp-location-section {
    padding: 96px 0;
    background: var(--white);
}
.hrp-map-wrap {
    position: relative;
    border-radius: var(--r-md);
    overflow: hidden;
    height: 100%;
    min-height: 480px;
    box-shadow: 0 10px 50px rgba(0,0,0,0.12);
}
.hrp-map-iframe { width: 100%; height: 100%; border: none; display: block; min-height: 480px; }
.hrp-map-pin {
    position: absolute;
    top: 16px;
    left: 16px;
    background: var(--white);
    color: var(--gold);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    font-size: 18px;
}

.hrp-location-card {
    background: var(--white);
    border: 1.5px solid rgba(197,160,89,0.2);
    border-radius: var(--r-md);
    padding: 36px;
    height: 100%;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}
.hrp-location-title { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--navy); margin-bottom: 4px; }
.hrp-location-subtitle { font-size: 13px; color: var(--gold); font-family: 'Poppins', sans-serif; margin-bottom: 28px; letter-spacing: 0.5px; }
.hrp-location-details { margin-bottom: 28px; }
.hrp-loc-row { display: flex; gap: 14px; margin-bottom: 20px; align-items: flex-start; }
.hrp-loc-icon {
    width: 36px;
    height: 36px;
    background: rgba(197,160,89,0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.hrp-loc-icon i { color: var(--gold); font-size: 14px; }
.hrp-loc-label { display: block; font-size: 10.5px; text-transform: uppercase; letter-spacing: 1px; color: #AAA; font-family: 'Poppins', sans-serif; margin-bottom: 2px; }
.hrp-loc-val { display: block; font-size: 13.5px; color: var(--navy); line-height: 1.65; }
.hrp-loc-link { text-decoration: none; transition: color 0.25s ease; }
.hrp-loc-link:hover { color: var(--gold); }

.hrp-location-ctas { display: flex; gap: 12px; flex-wrap: wrap; }
.hrp-loc-wa-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: 1.5px solid rgba(37,211,102,0.5);
    color: #1a9e4a;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-loc-wa-btn:hover { background: #25D366; color: #fff; border-color: #25D366; }
.hrp-loc-wa-btn i { font-size: 18px; }

/* ── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 991px) {
    .hrp-bento-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(3, 200px);
    }
    .hrp-bento-item--0,.hrp-bento-item--1,.hrp-bento-item--2,
    .hrp-bento-item--3,.hrp-bento-item--4,.hrp-bento-item--5 {
        grid-column: auto;
        grid-row: auto;
    }
    .hrp-bento-item--0 { grid-column: 1/3; }
    .hrp-welcome-text { padding-left: 0; margin-top: 24px; }
    .hrp-stat-item { padding: 8px 20px; min-width: 100px; }
}

@media (max-width: 767px) {
    .hrp-hero { min-height: 100svh; }
    .hrp-hero-title { font-size: 36px; }
    .hrp-hero-subtitle { font-size: 14px; }
    .hrp-hero-ctas { flex-direction: column; align-items: center; gap: 12px; }
    .hrp-stats-row { gap: 0; }
    .hrp-stat-divider { display: none; }
    .hrp-stat-item { min-width: 50%; }
    .hrp-booking-bar { flex-direction: column; align-items: stretch; gap: 12px; }
    .hrp-booking-fields { flex-direction: column; }
    .hrp-booking-sep { display: none; }
    .hrp-booking-title { justify-content: center; }
    .hrp-bento-grid {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: repeat(4, 170px);
    }
    .hrp-bento-item--0 { grid-column: 1/3; }
    .hrp-bento-item--2 { grid-column: auto; grid-row: auto; }
    .hrp-welcome-img { height: 320px; }
    .hrp-welcome-stats { flex-direction: column; gap: 16px; }
    .hrp-room-actions { flex-direction: column; }
    .hrp-location-card { padding: 24px; margin-top: 20px; }
    .hrp-location-ctas { flex-direction: column; }
    .hrp-amenity-card { flex-direction: column; align-items: flex-start; }
    section { padding: 64px 0; }
}
</style>
@endsection

{{-- ═══════════════════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════════════════ --}}
@section('extra_js')
<script>
// ── Booking Bar: Check Availability ────────────────────────
function checkAvailability() {
    const checkin  = document.getElementById('checkin-date').value;
    const checkout = document.getElementById('checkout-date').value;
    const guests   = document.getElementById('guests-select').value;

    if (!checkin || !checkout) {
        // Simple visual shake
        const bar = document.getElementById('booking-bar');
        bar.style.animation = 'hrpShake 0.4s ease';
        setTimeout(() => bar.style.animation = '', 500);
        alert('Please select both check-in and check-out dates.');
        return;
    }
    if (new Date(checkout) <= new Date(checkin)) {
        alert('Check-out date must be after check-in date.');
        return;
    }

    // Build WhatsApp message
    const msg = `Hello Hotel Rose Palace! I'd like to check availability:\n\n📅 Check-in: ${checkin}\n📅 Check-out: ${checkout}\n👥 Guests: ${document.getElementById('guests-select').options[document.getElementById('guests-select').selectedIndex].text}\n\nPlease confirm availability and pricing. Thank you!`;
    const waNum = '{{ preg_replace("/\D/", "", config("hotel.contact.whatsapp_number", "919042424242")) }}';
    window.open(`https://wa.me/${waNum}?text=${encodeURIComponent(msg)}`, '_blank');
}

// ── Lightbox ───────────────────────────────────────────────
function openLightbox(src, caption) {
    const lb = document.getElementById('hrp-lightbox');
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').textContent = caption;
    lb.classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('hrp-lightbox').classList.remove('active');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeLightbox(); });

// ── Date defaults ──────────────────────────────────────────
(function(){
    const today   = new Date();
    const tmrw    = new Date(today); tmrw.setDate(today.getDate() + 1);
    const fmt     = d => d.toISOString().split('T')[0];
    const ci      = document.getElementById('checkin-date');
    const co      = document.getElementById('checkout-date');
    if(ci) ci.value  = fmt(today);
    if(co) co.value  = fmt(tmrw);
    if(ci) ci.addEventListener('change', function(){
        const next = new Date(this.value); next.setDate(next.getDate()+1);
        if(co && (!co.value || new Date(co.value) <= new Date(this.value))) co.value = fmt(next);
    });
})();

// ── Scroll-reveal animation ────────────────────────────────
(function(){
    if(!('IntersectionObserver' in window)) return;
    const els = document.querySelectorAll('.hrp-room-card,.hrp-amenity-card,.hrp-testi-card,.hrp-exp-card,.hrp-bento-item,.hrp-ws-item');
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if(e.isIntersecting){ e.target.classList.add('hrp-revealed'); io.unobserve(e.target); }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    els.forEach(el => { el.style.opacity = '0'; el.style.transform = 'translateY(24px)'; el.style.transition = 'opacity 0.6s ease, transform 0.6s ease'; io.observe(el); });
    document.querySelectorAll('.hrp-revealed').forEach(el => { el.style.opacity = '1'; el.style.transform = 'none'; });
    // Apply revealed styles via class
    document.head.insertAdjacentHTML('beforeend', '<style>.hrp-revealed{opacity:1!important;transform:none!important;}</style>');
})();
</script>
@endsection
