@extends('layouts.app')

@section('title', 'About Us — Hotel Rose Palace | Comfort, Elegance & Warm Hospitality in Surat')
@section('meta_description', 'Discover Hotel Rose Palace in Vesu, Surat. A 3-star property offering comfortable rooms, attentive hospitality, modern amenities, and prime connectivity on VIP Road.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     1. HERO BANNER — OUR STORY & HERITAGE
═══════════════════════════════════════════════════════ --}}
<section class="hrp-boutique-hero position-relative">
    <div class="hrp-boutique-hero-content">
        <span class="hrp-boutique-eyebrow">
            ✦ COMFORT, ELEGANCE &amp; HOSPITALITY ✦
        </span>
        <h1 class="hrp-boutique-hero-title">Our Story &amp; Heritage</h1>
        <p class="hrp-boutique-hero-subtitle">
            Discover a welcoming stay where comfort, attentive service and warm hospitality come together in Vesu, Surat.
        </p>
        <div class="hrp-boutique-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right hrp-breadcrumb-sep"></i>
            <span>About Us</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     2. ABOUT THE HOTEL — PREMIUM EDITORIAL SPLIT SECTION
═══════════════════════════════════════════════════════ --}}
<section class="hrp-boutique-story-section">
    <div class="hrp-boutique-container">
        <div class="row align-items-center g-4 g-xl-5">
            
            {{-- Left Column: Visual Showcase --}}
            <div class="col-lg-6 col-md-12">
                <div class="hrp-boutique-story-img-card">
                    <img src="{{ asset('images/gallery/front-desk-reception.jpg') }}" onerror="this.onerror=null;this.src='{{ asset('images/gallery/reception-lobby-lounge.jpg') }}';" alt="Hotel Rose Palace Front Desk & Reception" class="hrp-boutique-story-img" loading="lazy">
                    
                    {{-- Floating Glassmorphism Badge --}}
                    <div class="hrp-floating-glass-badge">
                        <div class="d-flex align-items-center gap-3">
                            <div class="hrp-glass-icon-circle">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="text-start">
                                <strong class="hrp-glass-badge-title">Prime Location in Vesu, Surat</strong>
                                <span class="hrp-glass-badge-subtitle">Atlanta Business Hub • VIP Road</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Editorial Content --}}
            <div class="col-lg-6 col-md-12">
                <div class="hrp-boutique-story-content">
                    <span class="hrp-boutique-badge">
                        WELCOME TO HOTEL ROSE PALACE
                    </span>
                    <h2 class="hrp-boutique-section-heading">
                        Comfort, Elegance &amp; Warm Hospitality
                    </h2>
                    
                    <p class="hrp-boutique-lead-paragraph">
                        Experience a comfortable and welcoming stay at Hotel Rose Palace, a 3-star property in Vesu, Surat. Designed for business, family and leisure travellers, our property combines convenient accommodation with attentive hospitality.
                    </p>
                    <p class="hrp-boutique-body-paragraph">
                        From comfortable rooms and essential modern amenities to convenient online booking and guest assistance, we aim to make every stay pleasant, relaxing and memorable.
                    </p>

                    {{-- Mini Highlight Strip --}}
                    <div class="hrp-mini-highlight-strip">
                        <div class="hrp-mini-highlight-item">
                            <i class="fas fa-clock text-gold"></i>
                            <span>24-Hour Front Desk</span>
                        </div>
                        <div class="hrp-mini-divider"></div>
                        <div class="hrp-mini-highlight-item">
                            <i class="fas fa-map-marked-alt text-gold"></i>
                            <span>Prime VIP Road Location</span>
                        </div>
                        <div class="hrp-mini-divider"></div>
                        <div class="hrp-mini-highlight-item">
                            <i class="fas fa-snowflake text-gold"></i>
                            <span>Comfortable AC Rooms</span>
                        </div>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="d-flex flex-wrap gap-3 pt-2">
                        <a href="#explore-rooms" class="btn hrp-btn-boutique-primary">
                            <i class="fas fa-door-open me-2"></i>Explore Rooms
                        </a>
                        <a href="{{ route('gallery') }}" class="btn hrp-btn-boutique-secondary">
                            <i class="fas fa-images me-2"></i>View Full Gallery
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     3. WHAT MAKES OUR STAY SPECIAL — PREMIUM FEATURE CARDS
═══════════════════════════════════════════════════════ --}}
<section class="hrp-boutique-features-section">
    <div class="hrp-boutique-container">
        
        <div class="text-center mb-5">
            <span class="hrp-boutique-section-eyebrow">
                ✦ HOSPITALITY HIGHLIGHTS ✦
            </span>
            <h2 class="hrp-boutique-section-title">What Makes Our Stay Special</h2>
            <p class="hrp-boutique-section-subtitle">
                Essential comforts, attentive guest care and convenient services designed around your needs in Surat.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            
            {{-- Feature Card 1 --}}
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="hrp-boutique-feature-card">
                    <div class="hrp-feature-icon-pod">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h4 class="hrp-feature-card-title">Comfortable Accommodation</h4>
                    <p class="hrp-feature-card-text">
                        Comfortable guest rooms designed to provide a relaxing stay.
                    </p>
                </div>
            </div>

            {{-- Feature Card 2 --}}
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="hrp-boutique-feature-card">
                    <div class="hrp-feature-icon-pod">
                        <i class="fas fa-fan"></i>
                    </div>
                    <h4 class="hrp-feature-card-title">Essential Modern Amenities</h4>
                    <p class="hrp-feature-card-text">
                        Air conditioning, flat-screen television with cable channels and other available guest facilities.
                    </p>
                </div>
            </div>

            {{-- Feature Card 3 --}}
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="hrp-boutique-feature-card">
                    <div class="hrp-feature-icon-pod">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="hrp-feature-card-title">Convenient Online Booking</h4>
                    <p class="hrp-feature-card-text">
                        A direct online reservation experience with secure payment functionality.
                    </p>
                </div>
            </div>

            {{-- Feature Card 4 --}}
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="hrp-boutique-feature-card">
                    <div class="hrp-feature-icon-pod">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h4 class="hrp-feature-card-title">Attentive Hospitality</h4>
                    <p class="hrp-feature-card-text">
                        Guest assistance through the existing front desk and hotel support services.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     4. EXPLORE OUR ROOMS — PREMIUM ROOM CATEGORIES
═══════════════════════════════════════════════════════ --}}
<section id="explore-rooms" class="hrp-boutique-rooms-section">
    <div class="hrp-boutique-container">
        
        <div class="text-center mb-5">
            <span class="hrp-boutique-section-eyebrow">
                ✦ ACCOMMODATIONS ✦
            </span>
            <h2 class="hrp-boutique-section-title">Explore Our Rooms</h2>
            <p class="hrp-boutique-section-subtitle">
                Choose from our two distinctive room categories, each tailored for supreme comfort, restful slumber, and essential modern amenities.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($roomTypes as $roomType)
                @php
                    $isDeluxe = str_contains(strtolower($roomType->name), 'deluxe');
                    $badgeText = $isDeluxe ? 'Deluxe Category • Most Popular' : 'Executive Category • Business Travel Choice';
                    $badgeBg = $isDeluxe ? '#881337' : '#B45309';
                    $imgSrc = $isDeluxe 
                        ? asset('images/rooms/WhatsApp Image 2026-11-17 at 6.53.49 PM.jpeg') 
                        : asset('images/rooms/hotel-rose-palace-room-view-window.jpeg');
                    $imgFallback = $isDeluxe 
                        ? asset('images/rooms/hotel-rose-palace-room-102-door.jpeg') 
                        : asset('images/rooms/WhatsApp Image 2026-11-17 at 6.54.48 PM.jpeg');
                    
                    // Approved manager-certified specifications
                    $dimDisplay = $isDeluxe ? '189 sq.ft. (17.56 m²)' : '169 sq.ft. (15.70 m²)';
                    $bedLayout = $isDeluxe ? '1 King Bed + 1 Living Room' : '1 King Bed';
                    $descText = $isDeluxe
                        ? 'Spacious family accommodation featuring 1 King Bed + 1 Living Room, ambient LED ceilings, high-speed Wi-Fi, and VIP Road city views.'
                        : 'Crafted for corporate and textile travelers featuring 1 King Bed, ergonomic workstation, high-speed Wi-Fi, and city vistas of VIP Road.';
                    
                    // Starting rate dynamic calculation (6% direct savings + taxes)
                    $discountRate = round($roomType->base_price * 0.94);
                    $taxAmount = round($roomType->base_price * 0.14);
                @endphp
                <div class="col-lg-6 col-md-12">
                    <div class="hrp-boutique-room-card">
                        <div style="position: relative; overflow: hidden; aspect-ratio: 16 / 10;">
                            <img src="{{ $imgSrc }}" onerror="this.onerror=null;this.src='{{ $imgFallback }}';" alt="{{ $roomType->name }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center;" loading="lazy">
                            <span class="badge" style="position: absolute; top: 16px; left: 16px; background: {{ $badgeBg }}; color: #FFFFFF; padding: 7px 14px; font-size: 12.5px; border-radius: 6px; font-weight: 600; letter-spacing: 0.3px; box-shadow: 0 4px 12px rgba(0,0,0,0.18);">
                                {{ $badgeText }}
                            </span>
                        </div>
                        <div class="p-4 p-xl-5 d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2 mb-2">
                                <h4 class="hrp-room-card-heading">{{ $roomType->name }}</h4>
                                <span class="badge rounded-pill hrp-room-base-price-pill">
                                    Base Price ₹{{ number_format($roomType->base_price, 0) }}/night
                                </span>
                            </div>
                            <p class="hrp-room-card-desc">
                                {{ $descText }}
                            </p>
                            <div class="d-flex flex-wrap gap-2 mb-4 hrp-room-spec-row">
                                <span><i class="fas fa-bed text-gold me-1"></i> {{ $bedLayout }}</span> •
                                <span><i class="fas fa-vector-square text-gold me-1"></i> {{ $dimDisplay }}</span> •
                                <span><i class="fas fa-user-friends text-gold me-1"></i> Max 3 Guests</span> •
                                <span><i class="fas fa-eye text-gold me-1"></i> City View</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pt-3 hrp-room-card-footer">
                                <div>
                                    <span class="hrp-starting-rate-label">Starting Rate</span>
                                    <span class="hrp-starting-rate-price">₹{{ number_format($discountRate, 0) }}</span><span class="hrp-starting-rate-tax">/night <small class="text-muted">(+ ₹{{ number_format($taxAmount, 0) }} taxes)</small></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('room-detail', ['slug' => $roomType->slug]) }}" class="btn hrp-btn-room-details">
                                        View Room Details
                                    </a>
                                    <a href="{{ route('booking.search.form') }}" class="btn hrp-btn-room-book">
                                        Check Availability
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p style="color: #64748B;">Rooms information will be updated shortly.</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     5. HOSPITALITY COMMITMENT — EDITORIAL STATEMENT
═══════════════════════════════════════════════════════ --}}
<section class="hrp-boutique-commitment-section">
    <div class="hrp-boutique-container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-10 col-lg-11 col-md-12">
                <div class="hrp-boutique-commitment-card">
                    
                    <div class="hrp-commitment-quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    
                    <span class="hrp-commitment-eyebrow">
                        ✦ OUR PROMISE OF HOSPITALITY ✦
                    </span>
                    <h3 class="hrp-commitment-heading">
                        Our Promise of Hospitality
                    </h3>

                    <p class="hrp-commitment-message">
                        "At Hotel Rose Palace, we believe a pleasant stay begins with comfort, cleanliness and thoughtful hospitality. Our team strives to provide a welcoming environment and attentive assistance throughout every guest's stay."
                    </p>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pt-4 text-start hrp-commitment-bottom-bar">
                        <div>
                            <strong class="hrp-commitment-author-title">Management &amp; Front Office Team</strong>
                            <span class="hrp-commitment-author-sub">Hotel Rose Palace • VIP Road, Vesu, Surat</span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('booking.search.form') }}" class="btn hrp-btn-commitment-book">
                                <i class="fas fa-calendar-check me-2"></i>Book Your Stay
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918866771900')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to inquire about room availability.') }}" target="_blank" class="btn hrp-btn-commitment-whatsapp">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp Us
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     6. FIND YOUR STAY — LOCATION & CONNECTIVITY
═══════════════════════════════════════════════════════ --}}
<section class="hrp-boutique-location-section text-center">
    <div class="hrp-boutique-container">
        <span class="hrp-boutique-section-eyebrow">
            ✦ DESTINATION &amp; CONNECTIVITY ✦
        </span>
        <h2 class="hrp-boutique-section-title">Find Your Stay</h2>
        <p class="hrp-boutique-section-subtitle">
            Discover convenient accommodation at Atlanta Business Hub, VIP Road, Vesu, Surat.
        </p>

        {{-- Compact Connectivity Highlights --}}
        <div class="row g-3 justify-content-center mb-4">
            <div class="col-md-4 col-sm-6">
                <div class="hrp-location-mini-card">
                    <i class="fas fa-map-marker-alt text-gold fs-5 mb-2"></i>
                    <h5 class="hrp-location-mini-card-title">Prime Vesu Location</h5>
                    <p class="hrp-location-mini-card-sub">Atlanta Business Hub, VIP Road</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="hrp-location-mini-card">
                    <i class="fas fa-plane-departure text-gold fs-5 mb-2"></i>
                    <h5 class="hrp-location-mini-card-title">Near Surat Airport</h5>
                    <p class="hrp-location-mini-card-sub">Quick access via VIP Road corridor</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="hrp-location-mini-card">
                    <i class="fas fa-clock text-gold fs-5 mb-2"></i>
                    <h5 class="hrp-location-mini-card-title">24-Hour Assistance</h5>
                    <p class="hrp-location-mini-card-sub">Front desk assistance around the clock</p>
                </div>
            </div>
        </div>

        {{-- Direct CTA Actions --}}
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('contact') }}" class="btn hrp-btn-boutique-primary">
                <i class="fas fa-envelope me-2"></i>Contact Us
            </a>
            <a href="{{ config('hotel.contact.google_maps', 'https://www.google.com/maps') }}" target="_blank" rel="noopener noreferrer" class="btn hrp-btn-boutique-secondary">
                <i class="fas fa-directions me-2 text-gold"></i>Get Directions
            </a>
        </div>
    </div>
</section>

@endsection

@section('extra_css')
<style>
    /* ═════════════════════════════════════════════════════════
       HOTEL ROSE PALACE — ULTRA-PREMIUM BOUTIQUE ABOUT STYLING
       Color Palette:
       - Champagne Sandstone: #F5EFE6
       - Soft Neutral Background: #F8F9FA
       - Pure White: #FFFFFF
       - Deep Charcoal: #1E293B
       - Burgundy Rose: #881337
       - Warm Gold: #B45309
       ═════════════════════════════════════════════════════════ */

    /* Global Container for Boutique About Page */
    .hrp-boutique-container {
        width: 100%;
        max-width: 1280px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
    }

    /* 1. Hero Section — Bottom-Left Aligned & Unobstructed Signboard */
    .hrp-boutique-hero {
        position: relative;
        background: linear-gradient(
            to top,
            rgba(20, 15, 18, 0.88) 0%,
            rgba(20, 15, 18, 0.45) 55%,
            rgba(20, 15, 18, 0.15) 100%
        ),
        url('{{ asset('images/hotel/exterior-facade-main.jpg') }}') center 38% / cover no-repeat;
        height: 420px;
        min-height: 420px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: flex-start;
    }

    .hrp-boutique-hero-content {
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px 38px;
        text-align: left;
        position: relative;
        z-index: 2;
    }

    .hrp-boutique-eyebrow {
        color: #F3D08A;
        font-family: var(--font-ui);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 8px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);
        white-space: nowrap;
    }

    .hrp-boutique-hero-title {
        color: #FFFFFF;
        font-family: var(--font-heading);
        font-size: clamp(32px, 3.5vw, 42px);
        font-weight: 700;
        line-height: 1.15;
        margin-bottom: 8px;
        text-shadow: 0 2px 14px rgba(0, 0, 0, 0.75);
    }

    .hrp-boutique-hero-subtitle {
        color: #F8F9FA;
        font-size: clamp(14.5px, 1.15vw, 16px);
        max-width: 600px;
        margin: 0 0 14px 0;
        line-height: 1.55;
        text-shadow: 0 1px 8px rgba(0, 0, 0, 0.6);
    }

    .hrp-boutique-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 5px 16px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        font-size: 13px;
        color: #FFFFFF;
    }

    .hrp-boutique-breadcrumb a {
        color: #FFFFFF;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .hrp-boutique-breadcrumb a:hover {
        color: #F3D08A;
    }

    .hrp-breadcrumb-sep {
        font-size: 10px;
        color: #F3D08A;
    }

    /* 2. About The Hotel (Editorial Split Section) */
    .hrp-boutique-story-section {
        background-color: #F8F9FA;
        padding: 85px 0 80px;
    }

    .hrp-boutique-story-img-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        border: 1.5px solid rgba(180, 83, 9, 0.32);
        background: #FFFFFF;
        box-shadow: 0 20px 48px rgba(30, 41, 59, 0.12);
        height: 100%;
        min-height: 520px;
        display: flex;
        flex-direction: column;
    }

    .hrp-boutique-story-img {
        width: 100%;
        height: 100%;
        min-height: 520px;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .hrp-floating-glass-badge {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 10px 30px rgba(30, 41, 59, 0.16);
        border-radius: 14px;
        padding: 12px 20px;
    }

    .hrp-glass-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(180, 83, 9, 0.12);
        color: #B45309;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .hrp-glass-badge-title {
        color: #1E293B;
        font-size: 14px;
        display: block;
        line-height: 1.3;
    }

    .hrp-glass-badge-subtitle {
        color: #64748B;
        font-size: 12px;
        display: block;
        line-height: 1.4;
    }

    .hrp-boutique-story-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .hrp-boutique-badge {
        color: #B45309;
        font-family: var(--font-ui);
        font-weight: 700;
        font-size: 12.5px;
        letter-spacing: 2px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 12px;
    }

    .hrp-boutique-section-heading {
        font-size: clamp(32px, 3.2vw, 42px);
        font-family: var(--font-heading);
        color: #1E293B;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.25;
    }

    .hrp-boutique-lead-paragraph {
        font-size: clamp(16px, 1.15vw, 17px);
        line-height: 1.82;
        color: #475569;
        margin-bottom: 16px;
    }

    .hrp-boutique-body-paragraph {
        font-size: clamp(15.5px, 1.1vw, 16.5px);
        line-height: 1.82;
        color: #475569;
        margin-bottom: 24px;
    }

    /* Mini Highlight Strip */
    .hrp-mini-highlight-strip {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        background: #FFFFFF;
        border: 1px solid rgba(216, 203, 184, 0.6);
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 28px;
        box-shadow: 0 4px 16px rgba(30, 41, 59, 0.04);
    }

    .hrp-mini-highlight-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: #1E293B;
    }

    .hrp-mini-divider {
        width: 1px;
        height: 22px;
        background: #E2E8F0;
    }

    /* Boutique Button Styles */
    .hrp-btn-boutique-primary {
        background-color: #881337;
        color: #FFFFFF !important;
        border: 1.5px solid #881337;
        border-radius: 8px;
        padding: 12px 28px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(136, 19, 55, 0.25);
        transition: all 0.25s ease;
    }

    .hrp-btn-boutique-primary:hover {
        background-color: #6B0E2A;
        border-color: #6B0E2A;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(136, 19, 55, 0.35);
    }

    .hrp-btn-boutique-secondary {
        background-color: #FFFFFF;
        color: #881337 !important;
        border: 1.5px solid #881337;
        border-radius: 8px;
        padding: 12px 28px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .hrp-btn-boutique-secondary:hover {
        background-color: #881337;
        color: #FFFFFF !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(136, 19, 55, 0.20);
    }

    /* 3. Features Section */
    .hrp-boutique-features-section {
        background-color: #F5EFE6;
        padding: 85px 0;
    }

    .hrp-boutique-section-eyebrow {
        color: #B45309;
        font-family: var(--font-ui);
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 2px;
        text-transform: uppercase;
        display: block;
        margin-bottom: 8px;
    }

    .hrp-boutique-section-title {
        font-size: clamp(30px, 3.2vw, 40px);
        color: #1E293B;
        font-family: var(--font-heading);
        font-weight: 700;
        margin-bottom: 12px;
    }

    .hrp-boutique-section-subtitle {
        max-width: 660px;
        margin: 0 auto;
        color: #64748B;
        font-size: 16px;
        line-height: 1.7;
    }

    .hrp-boutique-feature-card {
        background: #FFFFFF;
        border: 1px solid rgba(216, 203, 184, 0.65);
        border-radius: 20px;
        padding: 34px 26px;
        height: 100%;
        text-align: center;
        box-shadow: 0 4px 20px rgba(30, 41, 59, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .hrp-boutique-feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 36px rgba(30, 41, 59, 0.10);
        border-bottom: 3.5px solid #B45309;
    }

    .hrp-feature-icon-pod {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        background: rgba(136, 19, 55, 0.08);
        color: #881337;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 20px;
        border: 1px solid rgba(136, 19, 55, 0.15);
    }

    .hrp-feature-card-title {
        color: #1E293B;
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 12px;
        font-family: var(--font-heading);
    }

    .hrp-feature-card-text {
        color: #475569;
        font-size: 14.5px;
        line-height: 1.72;
        margin: 0;
    }

    /* 4. Rooms Section */
    .hrp-boutique-rooms-section {
        background-color: #F8F9FA;
        padding: 85px 0;
    }

    .hrp-boutique-room-card {
        border: 1px solid rgba(216, 203, 184, 0.65);
        border-radius: 20px;
        background: #FFFFFF;
        box-shadow: 0 8px 30px rgba(30, 41, 59, 0.06);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hrp-boutique-room-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(30, 41, 59, 0.12);
    }

    .hrp-room-card-heading {
        color: #1E293B;
        margin: 0;
        font-size: 24px;
        font-family: var(--font-heading);
        font-weight: 700;
    }

    .hrp-room-base-price-pill {
        background: rgba(180, 83, 9, 0.12);
        color: #881337;
        font-size: 12.5px;
        padding: 5px 12px;
        font-weight: 600;
        border: 1px solid rgba(180, 83, 9, 0.25);
    }

    .hrp-room-card-desc {
        font-size: 14.5px;
        color: #475569;
        margin-bottom: 18px;
        flex-grow: 1;
        line-height: 1.68;
    }

    .hrp-room-spec-row {
        font-size: 13px;
        color: #475569;
    }

    .hrp-room-card-footer {
        border-top: 1px solid #E2E8F0;
        margin-top: auto;
    }

    .hrp-starting-rate-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #64748B;
        display: block;
        letter-spacing: 0.8px;
        font-weight: 600;
    }

    .hrp-starting-rate-price {
        font-size: 25px;
        font-weight: 700;
        color: #881337;
    }

    .hrp-starting-rate-tax {
        font-size: 12.5px;
        color: #64748B;
    }

    .hrp-btn-room-details {
        background: #F8F9FA;
        border: 1.5px solid #CBD5E1;
        color: #1E293B !important;
        text-decoration: none;
        padding: 8px 16px;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .hrp-btn-room-details:hover {
        background: #E2E8F0;
        color: #0F172A !important;
    }

    .hrp-btn-room-book {
        background: #881337;
        border: 1.5px solid #881337;
        color: #FFFFFF !important;
        text-decoration: none;
        padding: 8px 18px;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(136, 19, 55, 0.20);
        transition: all 0.2s ease;
    }

    .hrp-btn-room-book:hover {
        background: #6B0E2A;
        border-color: #6B0E2A;
    }

    /* 5. Hospitality Commitment */
    .hrp-boutique-commitment-section {
        background-color: #F5EFE6;
        padding: 85px 0;
    }

    .hrp-boutique-commitment-card {
        border: 1.5px solid rgba(180, 83, 9, 0.4);
        border-radius: 22px;
        background: linear-gradient(135deg, #881337 0%, #581C2C 100%);
        color: #FFFFFF;
        padding: 55px 45px 42px;
        box-shadow: 0 20px 50px rgba(30, 41, 59, 0.16);
        text-align: center;
        position: relative;
    }

    .hrp-commitment-quote-icon {
        color: #F5EFE6;
        opacity: 0.85;
        font-size: 36px;
        margin-bottom: 12px;
    }

    .hrp-commitment-eyebrow {
        font-size: 13px;
        font-weight: 700;
        color: #C5A059;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        display: block;
        margin-bottom: 10px;
    }

    .hrp-commitment-heading {
        color: #FFFFFF;
        margin: 0 auto 20px;
        font-size: clamp(28px, 2.8vw, 36px);
        font-family: var(--font-heading);
        max-width: 660px;
        font-weight: 700;
    }

    .hrp-commitment-message {
        font-size: clamp(16px, 1.25vw, 17.5px);
        line-height: 1.88;
        color: #F8F9FA;
        max-width: 820px;
        margin: 0 auto 32px;
    }

    .hrp-commitment-bottom-bar {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hrp-commitment-author-title {
        color: #FFFFFF;
        font-size: 17px;
        display: block;
        font-family: var(--font-heading);
    }

    .hrp-commitment-author-sub {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.75);
    }

    .hrp-btn-commitment-book {
        background: #FFFFFF;
        color: #881337 !important;
        border: 1.5px solid #FFFFFF;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .hrp-btn-commitment-book:hover {
        background: #F5EFE6;
        border-color: #F5EFE6;
        transform: translateY(-2px);
    }

    .hrp-btn-commitment-whatsapp {
        background: #25D366;
        color: #FFFFFF !important;
        border: 1.5px solid #25D366;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .hrp-btn-commitment-whatsapp:hover {
        background: #1EBE5D;
        border-color: #1EBE5D;
        transform: translateY(-2px);
    }

    /* 6. Find Your Stay */
    .hrp-boutique-location-section {
        background-color: #F8F9FA;
        padding: 85px 0;
    }

    .hrp-location-mini-card {
        background: #FFFFFF;
        border: 1px solid rgba(216, 203, 184, 0.65);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(30, 41, 59, 0.04);
        height: 100%;
    }

    .hrp-location-mini-card-title {
        font-size: 15px;
        color: #1E293B;
        margin-bottom: 4px;
        font-family: var(--font-heading);
        font-weight: 700;
    }

    .hrp-location-mini-card-sub {
        font-size: 13px;
        color: #64748B;
        margin: 0;
    }

    /* Responsive Overrides */
    @media (max-width: 991.98px) {
        .hrp-boutique-hero {
            height: 390px;
            min-height: 390px;
            background-position: center 35%;
        }
        .hrp-boutique-hero-content {
            padding: 0 20px 32px;
        }
        .hrp-boutique-story-img-card,
        .hrp-boutique-story-img {
            min-height: 380px;
            height: 380px;
        }
        .hrp-boutique-story-section,
        .hrp-boutique-features-section,
        .hrp-boutique-rooms-section,
        .hrp-boutique-commitment-section,
        .hrp-boutique-location-section {
            padding: 60px 0;
        }
        .hrp-boutique-commitment-card {
            padding: 40px 24px 34px;
        }
        .hrp-mini-highlight-strip {
            gap: 12px;
        }
        .hrp-mini-divider {
            display: none;
        }
    }

    @media (max-width: 575.98px) {
        .hrp-boutique-container {
            padding-left: 16px;
            padding-right: 16px;
        }
        .hrp-boutique-hero {
            height: 360px;
            min-height: 360px;
            background-position: center 20%;
        }
        .hrp-boutique-hero-content {
            padding: 0 16px 24px;
        }
        .hrp-boutique-eyebrow {
            white-space: normal;
            font-size: 11.5px;
            letter-spacing: 1.8px;
            margin-bottom: 6px;
        }
        .hrp-boutique-hero-title {
            font-size: clamp(26px, 6.5vw, 32px);
            margin-bottom: 6px;
        }
        .hrp-boutique-hero-subtitle {
            font-size: 13.5px;
            line-height: 1.45;
            margin-bottom: 12px;
        }
        .hrp-boutique-story-img-card,
        .hrp-boutique-story-img {
            min-height: 290px;
            height: 290px;
        }
        .hrp-floating-glass-badge {
            left: 12px;
            right: 12px;
            bottom: 12px;
            padding: 10px 14px;
        }
        .hrp-boutique-story-section,
        .hrp-boutique-features-section,
        .hrp-boutique-rooms-section,
        .hrp-boutique-commitment-section,
        .hrp-boutique-location-section {
            padding: 50px 0;
        }
    }
</style>
@endsection
