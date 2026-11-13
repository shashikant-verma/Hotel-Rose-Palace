@extends('layouts.app')

@section('title', 'Hotel Rose Palace — Luxury Hotel in Vesu, Surat | Official Site')
@section('meta_description', 'Book direct at Hotel Rose Palace Surat for best rates, complimentary early check-in & dining discounts. Luxury rooms, pure veg dining, banquet halls on VIP Road, Vesu.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     1. CINEMATIC HERO CAROUSEL WITH KEN BURNS EFFECT
═══════════════════════════════════════════════════════ --}}
<div class="hrp-hero-wrapper">
    <div id="hrpHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000" data-bs-pause="false">
        
        {{-- Indicators --}}
        <div class="carousel-indicators mb-5">
            <button type="button" data-bs-target="#hrpHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#hrpHeroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#hrpHeroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        {{-- Slides --}}
        <div class="carousel-inner">
            
            {{-- Slide 1: Grand Facade / Entrance --}}
            <div class="carousel-item active hrp-carousel-item">
                <div class="hrp-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&q=85');"></div>
                <div class="hrp-hero-vignette"></div>
                <div class="hrp-hero-content container">
                    <span class="hrp-hero-eyebrow">✦ Premier Luxury in Surat ✦</span>
                    <h1 class="hrp-hero-title">Where Elegance Meets <em>Timeless Comfort</em></h1>
                    <p class="hrp-hero-sub">Immerse yourself in world-class hospitality on VIP Road, Vesu — crafted for discerning business travelers and memorable celebrations.</p>
                    <div class="hrp-hero-ctas">
                        <button type="button" onclick="window.openBookingModal()" class="btn btn-gold btn-lg">
                            <i class="fas fa-calendar-check"></i> Book Direct & Save 10%
                        </button>
                        <a href="#featured-rooms" class="btn btn-secondary btn-lg">
                            Explore Rooms & Suites
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 2: Royal Suites & Living Sanctuaries --}}
            <div class="carousel-item hrp-carousel-item">
                <div class="hrp-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1600&q=85');"></div>
                <div class="hrp-hero-vignette"></div>
                <div class="hrp-hero-content container">
                    <span class="hrp-hero-eyebrow">✦ Sanctuaries of Refinement ✦</span>
                    <h1 class="hrp-hero-title">Suites Designed for <em>Pure Indulgence</em></h1>
                    <p class="hrp-hero-sub">Plush king bedding, ambient designer lighting, high-speed Wi-Fi, and panoramic skyline views across Surat.</p>
                    <div class="hrp-hero-ctas">
                        <button type="button" onclick="window.openBookingModal()" class="btn btn-gold btn-lg">
                            <i class="fas fa-bed"></i> Reserve a Suite
                        </button>
                        <a href="{{ route('rooms') }}" class="btn btn-secondary btn-lg">
                            Compare All Rooms
                        </a>
                    </div>
                </div>
            </div>

            {{-- Slide 3: Pure Veg Culinary Delights & Banquets --}}
            <div class="carousel-item hrp-carousel-item">
                <div class="hrp-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1600&q=85');"></div>
                <div class="hrp-hero-vignette"></div>
                <div class="hrp-hero-content container">
                    <span class="hrp-hero-eyebrow">✦ Culinary Purity & Celebrations ✦</span>
                    <h1 class="hrp-hero-title">100% Pure Veg & <em>Jain Gastronomy</em></h1>
                    <p class="hrp-hero-sub">From authentic Surati Kathiyawadi thalis to grand celebratory banquets, experience gastronomic perfection.</p>
                    <div class="hrp-hero-ctas">
                        <a href="#dining-preview" class="btn btn-gold btn-lg">
                            <i class="fas fa-utensils"></i> View Dining Menu
                        </a>
                        <a href="#banquet-quote" class="btn btn-secondary btn-lg">
                            Banquet Hall Enquiries
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Controls --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#hrpHeroCarousel" data-bs-slide="prev" aria-label="Previous Slide">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0 2px 6px rgba(0,0,0,0.5));"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hrpHeroCarousel" data-bs-slide="next" aria-label="Next Slide">
            <span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0 2px 6px rgba(0,0,0,0.5));"></span>
        </button>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     2. FROSTED FLOATING RESERVATION BAR
═══════════════════════════════════════════════════════ --}}
<div class="hrp-reserve-bar-wrap">
    <div class="hrp-reserve-bar">
        
        <div class="hrp-reserve-bar-title">
            <span class="hrp-rbt-text">
                <i class="fas fa-concierge-bell text-gold"></i> Check Live Availability & Instant Pricing
            </span>
            <div class="d-flex align-items-center gap-2">
                <span class="d-none d-md-inline" style="font-size: 12px; color: var(--hrp-mauve);">Currency:</span>
                <div class="hrp-currency-toggle">
                    <button type="button" class="hrp-curr-btn active" id="heroCurrINR" onclick="setBookingCurrency('INR'); this.classList.add('active'); document.getElementById('heroCurrUSD').classList.remove('active');">INR (₹)</button>
                    <button type="button" class="hrp-curr-btn" id="heroCurrUSD" onclick="setBookingCurrency('USD'); this.classList.add('active'); document.getElementById('heroCurrINR').classList.remove('active');">USD ($)</button>
                </div>
            </div>
        </div>

        <div class="hrp-reserve-grid">
            
            {{-- Check-in --}}
            <div class="hrp-field-group">
                <label class="hrp-field-label" for="heroCheckIn">
                    <i class="fas fa-calendar-alt text-gold"></i> Check-in
                </label>
                <input type="date" id="heroCheckIn" class="hrp-field-input" onchange="syncHeroDates()">
            </div>

            {{-- Check-out --}}
            <div class="hrp-field-group">
                <label class="hrp-field-label" for="heroCheckOut">
                    <i class="fas fa-calendar-check text-gold"></i> Check-out
                </label>
                <input type="date" id="heroCheckOut" class="hrp-field-input" onchange="syncHeroDates()">
            </div>

            {{-- Guests & Room --}}
            <div class="hrp-field-group">
                <label class="hrp-field-label">
                    <i class="fas fa-user-friends text-gold"></i> Rooms & Guests
                </label>
                <select id="heroGuestsSelect" class="hrp-field-input" style="cursor: pointer;">
                    <option value="1">1 Room, 1 Adult</option>
                    <option value="2" selected>1 Room, 2 Adults</option>
                    <option value="3">1 Room, 3 Guests (Family)</option>
                    <option value="4">2 Rooms, 4 Guests</option>
                    <option value="5">Executive Suite Stay</option>
                </select>
            </div>

            {{-- Action Button --}}
            <div class="hrp-field-group">
                <label class="hrp-field-label d-none d-md-block" style="visibility: hidden;">Action</label>
                <button type="button" onclick="triggerHeroBookingModal()" class="btn btn-primary w-100" style="padding: 11px 20px; font-weight: 700;">
                    <i class="fas fa-search"></i> Check Rates
                </button>
            </div>

        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     3. HERITAGE NARRATIVE & KEY STATS
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 80px 0 60px;">
    <div class="container">
        <div class="row align-items-center g-5">
            
            {{-- Image with Arch Frame & Crest --}}
            <div class="col-lg-5 col-md-12">
                <div class="hrp-arch-frame" style="height: 480px;">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80" alt="Hotel Rose Palace Interior Architecture" loading="lazy">
                    <div class="hrp-crest-badge">
                        <span class="year">2024</span>
                        <span class="label">Surat, Gujarat</span>
                    </div>
                </div>
            </div>

            {{-- Narrative & Stats --}}
            <div class="col-lg-7 col-md-12">
                <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2.5px; text-transform: uppercase; display: block; margin-bottom: 12px;">
                    ✦ Heritage of Hospitality ✦
                </span>
                <h2 style="font-size: 38px; margin-bottom: 20px; color: var(--hrp-plum);">
                    Welcome to <span class="serif-italic" style="color: var(--hrp-burgundy);">Hotel Rose Palace</span>
                </h2>
                <p style="font-size: 16px; line-height: 1.8; margin-bottom: 18px; color: var(--hrp-mauve);">
                    Located at <strong>Atlanta Business Hub, VIP Road, Vesu</strong>, Hotel Rose Palace offers an exceptional sanctuary of luxury, comfort, and personalized care. Situated moments away from Surat International Airport and the world-renowned Surat Diamond Bourse, our hotel is the premier choice for corporate executives, vacationing families, and celebratory events.
                </p>
                <p style="font-size: 16px; line-height: 1.8; margin-bottom: 28px; color: var(--hrp-mauve);">
                    From our dedicated 100% Pure Vegetarian & Jain culinary offerings to acoustically insulated royal suites, every facet of your journey is curated with warmth and discreet efficiency.
                </p>

                {{-- 3 Key Stats Badges --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <div class="p-3 text-center rounded" style="background: var(--hrp-surface); border: 1px solid var(--hrp-border);">
                            <div style="font-family: var(--font-heading); font-size: 26px; font-weight: 700; color: var(--hrp-burgundy);">4.8 ★</div>
                            <div style="font-size: 12px; font-weight: 600; color: var(--hrp-mauve); text-transform: uppercase;">Google Rating</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 text-center rounded" style="background: var(--hrp-surface); border: 1px solid var(--hrp-border);">
                            <div style="font-family: var(--font-heading); font-size: 26px; font-weight: 700; color: var(--hrp-burgundy);">35+</div>
                            <div style="font-size: 12px; font-weight: 600; color: var(--hrp-mauve); text-transform: uppercase;">Luxury Rooms</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 text-center rounded" style="background: var(--hrp-surface); border: 1px solid var(--hrp-border);">
                            <div style="font-family: var(--font-heading); font-size: 26px; font-weight: 700; color: var(--hrp-burgundy);">100%</div>
                            <div style="font-size: 12px; font-weight: 600; color: var(--hrp-mauve); text-transform: uppercase;">Pure Veg & Jain</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('about') }}" class="btn btn-secondary">
                        Our Full Story →
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-primary">
                        Contact Concierge
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     4. FEATURED ROOMS & SIDE-BY-SIDE COMPARISON MATRIX
═══════════════════════════════════════════════════════ --}}
<section id="featured-rooms" class="hrp-section-divider" style="background-color: var(--hrp-surface);">
    <div class="container">
        
        <div class="text-center mb-5">
            <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">✦ Bespoke Accommodations ✦</span>
            <h2 style="font-size: 38px; color: var(--hrp-plum);">Curated Rooms & Suites</h2>
            <p style="max-width: 650px; margin: 0 auto; color: var(--hrp-mauve);">Each room is thoughtfully outfitted with plush Italian bedding, silent climate control, smart entertainment, and marble bathrooms.</p>
        </div>

        {{-- Featured Room Cards Grid --}}
        <div class="row g-4 mb-5">
            
            {{-- Room 1: Deluxe Double Room --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 p-0 overflow-hidden">
                    <div style="position: relative; height: 250px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=700&q=80" alt="Deluxe Double Room" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" loading="lazy">
                        <span class="badge" style="position: absolute; top: 16px; left: 16px; background: rgba(110,44,58,0.92); color: #F7F1E8; padding: 6px 12px; font-size: 12px; border-radius: 4px;">
                            Most Popular
                        </span>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h4 style="color: var(--hrp-plum); margin-bottom: 8px;">Deluxe Double Room</h4>
                        <p style="font-size: 13.5px; color: var(--hrp-mauve); margin-bottom: 16px; flex-grow: 1;">
                            Spacious king room featuring ambient LED ceilings, high-speed Wi-Fi, executive desk, and en-suite rain shower.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-3" style="font-size: 12px; color: var(--hrp-mauve);">
                            <span><i class="fas fa-bed text-gold"></i> King Bed</span> •
                            <span><i class="fas fa-vector-square text-gold"></i> 320 sq.ft</span> •
                            <span><i class="fas fa-user-friends text-gold"></i> 2 Adults</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid var(--hrp-border);">
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; color: var(--hrp-mauve); display: block;">From</span>
                                <span style="font-size: 22px; font-weight: 700; color: var(--hrp-burgundy);">₹3,999</span><span style="font-size: 12px; color: var(--hrp-mauve);">/night</span>
                            </div>
                            <button type="button" onclick="window.openBookingModal('deluxe-double-room')" class="btn btn-primary btn-sm">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Room 2: Superior Twin Room --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 p-0 overflow-hidden">
                    <div style="position: relative; height: 250px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1512918728672-f9d96f4fff8c?w=700&q=80" alt="Superior Twin Room" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" loading="lazy">
                        <span class="badge" style="position: absolute; top: 16px; left: 16px; background: rgba(184,138,68,0.92); color: #2E1F22; padding: 6px 12px; font-size: 12px; border-radius: 4px; font-weight: 700;">
                            Business Travel Choice
                        </span>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h4 style="color: var(--hrp-plum); margin-bottom: 8px;">Superior Twin Room</h4>
                        <p style="font-size: 13.5px; color: var(--hrp-mauve); margin-bottom: 16px; flex-grow: 1;">
                            Crafted for colleagues and friends with dual luxury single beds, ergonomic workstation, and garden vistas.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-3" style="font-size: 12px; color: var(--hrp-mauve);">
                            <span><i class="fas fa-bed text-gold"></i> Twin Beds</span> •
                            <span><i class="fas fa-vector-square text-gold"></i> 340 sq.ft</span> •
                            <span><i class="fas fa-user-friends text-gold"></i> 2 Adults</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid var(--hrp-border);">
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; color: var(--hrp-mauve); display: block;">From</span>
                                <span style="font-size: 22px; font-weight: 700; color: var(--hrp-burgundy);">₹4,499</span><span style="font-size: 12px; color: var(--hrp-mauve);">/night</span>
                            </div>
                            <button type="button" onclick="window.openBookingModal('superior-twin-room')" class="btn btn-primary btn-sm">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Room 3: Executive Suite --}}
            <div class="col-lg-4 col-md-12">
                <div class="card h-100 p-0 overflow-hidden">
                    <div style="position: relative; height: 250px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=700&q=80" alt="Executive Suite" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" loading="lazy">
                        <span class="badge" style="position: absolute; top: 16px; left: 16px; background: rgba(110,44,58,0.92); color: #F7F1E8; padding: 6px 12px; font-size: 12px; border-radius: 4px;">
                            VIP Suite
                        </span>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h4 style="color: var(--hrp-plum); margin-bottom: 8px;">Executive Suite</h4>
                        <p style="font-size: 13.5px; color: var(--hrp-mauve); margin-bottom: 16px; flex-grow: 1;">
                            Expansive living room lounge, plush king bedroom, marble bathroom with soaking tub, and priority room service.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-3" style="font-size: 12px; color: var(--hrp-mauve);">
                            <span><i class="fas fa-couch text-gold"></i> Living Lounge</span> •
                            <span><i class="fas fa-vector-square text-gold"></i> 450 sq.ft</span> •
                            <span><i class="fas fa-users text-gold"></i> Up to 3</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid var(--hrp-border);">
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; color: var(--hrp-mauve); display: block;">From</span>
                                <span style="font-size: 22px; font-weight: 700; color: var(--hrp-burgundy);">₹6,499</span><span style="font-size: 12px; color: var(--hrp-mauve);">/night</span>
                            </div>
                            <button type="button" onclick="window.openBookingModal('executive-suite')" class="btn btn-primary btn-sm">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Collapsible Side-by-Side Room Comparison Table --}}
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h4 style="margin: 0; color: var(--hrp-plum);">Side-by-Side Room Comparison</h4>
                    <p style="margin: 0; font-size: 13.5px; color: var(--hrp-mauve);">Compare dimensions, amenities, and starting rates across all categories.</p>
                </div>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#roomComparisonCollapse" aria-expanded="true" aria-controls="roomComparisonCollapse">
                    <i class="fas fa-sliders-h"></i> Toggle Table View
                </button>
            </div>

            <div class="collapse show" id="roomComparisonCollapse">
                <div class="hrp-table-responsive">
                    <table class="hrp-comparison-table">
                        <thead>
                            <tr>
                                <th>Features</th>
                                <th>Deluxe Double</th>
                                <th>Superior Twin</th>
                                <th class="highlight-col">Executive Suite ★</th>
                                <th>Royal Palace Suite</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Floor Area</strong></td>
                                <td>320 sq.ft</td>
                                <td>340 sq.ft</td>
                                <td class="highlight-col">450 sq.ft</td>
                                <td>650 sq.ft</td>
                            </tr>
                            <tr>
                                <td><strong>Bedding</strong></td>
                                <td>Plush King Bed</td>
                                <td>2 Twin Single Beds</td>
                                <td class="highlight-col">King Bed + Living Sofa</td>
                                <td>Emperor Bed + Living Room</td>
                            </tr>
                            <tr>
                                <td><strong>Max Occupancy</strong></td>
                                <td>2 Adults</td>
                                <td>2 Adults</td>
                                <td class="highlight-col">3 Adults / Family</td>
                                <td>4 Adults / Family</td>
                            </tr>
                            <tr>
                                <td><strong>Complimentary Breakfast</strong></td>
                                <td>Included</td>
                                <td>Included</td>
                                <td class="highlight-col">Included + High Tea</td>
                                <td>Full In-Room Butler Service</td>
                            </tr>
                            <tr>
                                <td><strong>Bathroom Setup</strong></td>
                                <td>Rain Shower & Marble Vanity</td>
                                <td>Rain Shower En-suite</td>
                                <td class="highlight-col">Italian Marble + Soaking Tub</td>
                                <td>Jacuzzi Tub & Dual Vanities</td>
                            </tr>
                            <tr>
                                <td><strong>Wi-Fi Speed</strong></td>
                                <td>500 Mbps Ultra-fast</td>
                                <td>500 Mbps Ultra-fast</td>
                                <td class="highlight-col">1 Gbps Dedicated</td>
                                <td>1 Gbps Dedicated</td>
                            </tr>
                            <tr>
                                <td><strong>Starting Rate</strong></td>
                                <td><strong>₹3,999</strong>/night</td>
                                <td><strong>₹4,499</strong>/night</td>
                                <td class="highlight-col"><strong>₹6,499</strong>/night</td>
                                <td><strong>₹8,999</strong>/night</td>
                            </tr>
                            <tr>
                                <td><strong>Reserve</strong></td>
                                <td><button type="button" onclick="window.openBookingModal('deluxe-double-room')" class="btn btn-secondary btn-sm w-100">Book</button></td>
                                <td><button type="button" onclick="window.openBookingModal('superior-twin-room')" class="btn btn-secondary btn-sm w-100">Book</button></td>
                                <td class="highlight-col"><button type="button" onclick="window.openBookingModal('executive-suite')" class="btn btn-primary btn-sm w-100">Book Suite</button></td>
                                <td><button type="button" onclick="window.openBookingModal('royal-palace-suite')" class="btn btn-secondary btn-sm w-100">Book</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     5. CURATED EXPERIENCES & BANQUET QUOTE ESTIMATOR
═══════════════════════════════════════════════════════ --}}
<section id="banquet-quote" class="hrp-section-divider" style="background-color: var(--hrp-canvas);">
    <div class="container">
        
        <div class="row g-5 align-items-center">
            
            {{-- Experience Highlights --}}
            <div class="col-lg-6 col-md-12">
                <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">✦ Bespoke Events ✦</span>
                <h2 style="font-size: 38px; color: var(--hrp-plum); margin-bottom: 20px;">Banquets, Celebrations & Corporate Retreats</h2>
                <p style="color: var(--hrp-mauve); line-height: 1.8; margin-bottom: 24px;">
                    Whether you are hosting a high-level business conference, an engagement soiree, or an intimate family celebration, Hotel Rose Palace provides flexible event spaces, royal acoustics, and customized pure veg catering in Vesu.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="card p-3">
                            <i class="fas fa-briefcase text-gold fs-4 mb-2"></i>
                            <h5 style="color: var(--hrp-plum); font-size: 17px; margin-bottom: 4px;">Corporate Conclaves</h5>
                            <p style="font-size: 13px; color: var(--hrp-mauve); margin: 0;">Audio-visual setup, high-speed Wi-Fi, executive tea-breaks, and delegate rooms.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card p-3">
                            <i class="fas fa-heart text-gold fs-4 mb-2"></i>
                            <h5 style="color: var(--hrp-plum); font-size: 17px; margin-bottom: 4px;">Weddings & Sangeet</h5>
                            <p style="font-size: 13px; color: var(--hrp-mauve); margin: 0;">Capacity for 50–350 guests with bespoke floral decor and royal thali service.</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello! I would like to inquire about booking the Banquet Hall at Hotel Rose Palace.') }}" target="_blank" class="btn btn-whatsapp">
                        <i class="fab fa-whatsapp"></i> Chat with Banquet Manager
                    </a>
                </div>
            </div>

            {{-- Interactive Banquet Quote Estimator Card --}}
            <div class="col-lg-6 col-md-12">
                <div class="card p-4" style="border: 1.5px solid var(--hrp-gold); box-shadow: var(--shadow-lg);">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2" style="border-bottom: 1px solid var(--hrp-border);">
                        <div>
                            <span class="badge" style="background: var(--hrp-gold); color: #2E1F22; font-size: 11px;">Instant Calculator</span>
                            <h4 style="margin: 4px 0 0; color: var(--hrp-plum);">Banquet & Event Estimator</h4>
                        </div>
                        <i class="fas fa-calculator fs-3 text-gold"></i>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="hrp-field-label">Event Date</label>
                            <input type="date" id="banquetDate" class="hrp-field-input" onchange="calculateBanquetQuote()">
                        </div>
                        <div class="col-sm-6">
                            <label class="hrp-field-label">Event Type</label>
                            <select id="banquetType" class="hrp-field-input" onchange="calculateBanquetQuote()">
                                <option value="wedding">Wedding / Sangeet</option>
                                <option value="corporate">Corporate Conference</option>
                                <option value="birthday">Birthday / Anniversary</option>
                                <option value="exhibition">Exhibition / Seminar</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="hrp-field-label">Guests Count (<span id="banquetGuestNum">100</span> guests)</label>
                            <input type="range" id="banquetGuests" min="30" max="350" step="10" value="100" class="w-100" style="accent-color: var(--hrp-burgundy);" oninput="document.getElementById('banquetGuestNum').textContent = this.value; calculateBanquetQuote();">
                        </div>
                        <div class="col-sm-6">
                            <label class="hrp-field-label">Catering Menu</label>
                            <select id="banquetMenu" class="hrp-field-input" onchange="calculateBanquetQuote()">
                                <option value="750">Pure Veg Buffet (₹750/plate)</option>
                                <option value="950">Royal Surati Thali (₹950/plate)</option>
                                <option value="1250">Grand Marwari Feast (₹1,250/plate)</option>
                                <option value="450">High-Tea & Snacks (₹450/plate)</option>
                            </select>
                        </div>
                    </div>

                    <div class="hrp-calc-summary-card mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span style="font-size: 13.5px; color: var(--hrp-mauve);">Estimated Catering & Hall Subtotal:</span>
                            <span id="banquetSubtotal" style="font-weight: 700; color: var(--hrp-plum);">₹95,000</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size: 13.5px; color: var(--hrp-mauve);">Applicable GST (18%):</span>
                            <span id="banquetGst" style="font-weight: 700; color: var(--hrp-plum);">₹17,100</span>
                        </div>
                        <div class="hrp-calc-total-row">
                            <span style="font-size: 18px;">Estimated Budget:</span>
                            <span id="banquetTotal" style="color: var(--hrp-burgundy);">₹1,12,100</span>
                        </div>
                    </div>

                    <button type="button" onclick="sendBanquetWhatsAppQuote()" class="btn btn-whatsapp w-100 mt-3">
                        <i class="fab fa-whatsapp"></i> Get Custom Banquet Quote on WhatsApp
                    </button>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     6. DINING & PURE VEG / JAIN MENU PREVIEW
═══════════════════════════════════════════════════════ --}}
<section id="dining-preview" class="hrp-section-divider" style="background-color: var(--hrp-surface);">
    <div class="container">
        
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center gap-2 mb-2">
                <span class="hrp-diet-badge">
                    <span class="hrp-veg-icon"></span> 100% Pure Vegetarian Kitchen
                </span>
                <span class="badge" style="background: rgba(184,138,68,0.15); color: #B88A44; border: 1px solid rgba(184,138,68,0.3); padding: 5px 12px; border-radius: 20px;">
                    Special Jain Options
                </span>
            </div>
            <h2 style="font-size: 38px; color: var(--hrp-plum);">Culinary Excellence & Gastronomy</h2>
            <p style="max-width: 650px; margin: 0 auto; color: var(--hrp-mauve);">Prepared with pristine purity and age-old culinary craftsmanship by master chefs in Surat.</p>
        </div>

        {{-- Menu Category Tabs --}}
        <div class="hrp-menu-tabs">
            <button class="hrp-menu-tab-btn active" onclick="showMenuCategory('breakfast', this)">Royal Breakfast</button>
            <button class="hrp-menu-tab-btn" onclick="showMenuCategory('thali', this)">Authentic Gujarati Thali</button>
            <button class="hrp-menu-tab-btn" onclick="showMenuCategory('north', this)">North Indian & Continental</button>
            <button class="hrp-menu-tab-btn" onclick="showMenuCategory('dessert', this)">Beverages & Desserts</button>
        </div>

        {{-- Tab Content Panes --}}
        <div class="row g-4" id="menuItemsGrid">
            
            {{-- Breakfast --}}
            <div class="col-md-6 menu-cat-item menu-breakfast">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">🥞</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Surati Nylon Khaman & Farsan</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">Included in Stay</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">Steamed gram flour delight garnished with mustard seeds and fresh coriander.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 menu-cat-item menu-breakfast">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">☕</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Kulhad Masala Chai & Poha</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">Fresh Daily</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">Indori poha with ratlami sev and aromatic lemongrass ginger masala tea.</p>
                    </div>
                </div>
            </div>

            {{-- Thali --}}
            <div class="col-md-6 menu-cat-item menu-thali d-none">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">🍲</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Surati Undhiyu & Puri</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">Chef Special</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">Seasonal vegetables simmered with authentic spices, muthia, and warm puris.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 menu-cat-item menu-thali d-none">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">🍚</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Kathiyawadi Rotla & White Butter</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">Jain Available</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">Handmade bajra rotla served with homemade white butter and jaggery.</p>
                    </div>
                </div>
            </div>

            {{-- North Indian --}}
            <div class="col-md-6 menu-cat-item menu-north d-none">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">🥘</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Paneer Rose Lababdar</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">Signature</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">Fresh cottage cheese cubes in rich tomato cashew gravy with rose petal essence.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 menu-cat-item menu-north d-none">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">🍕</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Wood-Fired Margherita Pizza</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">Pure Veg</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">San Marzano tomato coulis, fresh mozzarella, and sweet garden basil.</p>
                    </div>
                </div>
            </div>

            {{-- Desserts --}}
            <div class="col-md-6 menu-cat-item menu-dessert d-none">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">🍨</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Royal Rose Falooda</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">House Delight</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">Damascus rose syrup, chilled vermicelli, chia seeds, and kulfi scoop.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 menu-cat-item menu-dessert d-none">
                <div class="card p-3 d-flex flex-row gap-3 align-items-center">
                    <div style="font-size: 28px; width: 50px; text-align: center; color: var(--hrp-gold);">🥛</div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 style="margin: 0; color: var(--hrp-plum); font-size: 16px;">Kesar Pista Shrikhand</h5>
                            <span style="font-weight: 700; color: var(--hrp-burgundy);">100% Traditional</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: var(--hrp-mauve);">Strained hung curd laced with Kashmiri saffron threads and sliced pistachios.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center mt-4">
            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello! I would like to reserve a table for dining at Hotel Rose Palace.') }}" target="_blank" class="btn btn-primary">
                <i class="fas fa-utensils"></i> Reserve a Table on WhatsApp
            </a>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     7. SURAT CONNECTIVITY & TRANSIT MATRIX
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider" style="background-color: var(--hrp-canvas);">
    <div class="container">
        
        <div class="text-center mb-5">
            <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">✦ Prime Vesu Location ✦</span>
            <h2 style="font-size: 38px; color: var(--hrp-plum);">Seamless Connectivity in Surat</h2>
            <p style="max-width: 650px; margin: 0 auto; color: var(--hrp-mauve);">Strategically located in Atlanta Business Hub, VIP Road, Vesu — minutes away from the city's key hubs.</p>
        </div>

        {{-- 5 Key Transit Cards --}}
        <div class="hrp-transit-grid">
            <div class="hrp-transit-card">
                <div class="hrp-transit-icon"><i class="fas fa-plane-departure"></i></div>
                <div>
                    <span class="hrp-transit-time">12 Mins Drive</span>
                    <h5 class="hrp-transit-name">Surat Int'l Airport</h5>
                    <span class="hrp-transit-dist">8.5 km • Direct VIP Rd</span>
                </div>
            </div>

            <div class="hrp-transit-card">
                <div class="hrp-transit-icon"><i class="fas fa-gem"></i></div>
                <div>
                    <span class="hrp-transit-time">15 Mins Drive</span>
                    <h5 class="hrp-transit-name">Diamond Bourse</h5>
                    <span class="hrp-transit-dist">11 km • Khajod Hub</span>
                </div>
            </div>

            <div class="hrp-transit-card">
                <div class="hrp-transit-icon"><i class="fas fa-store"></i></div>
                <div>
                    <span class="hrp-transit-time">18 Mins Drive</span>
                    <h5 class="hrp-transit-name">Textile Market</h5>
                    <span class="hrp-transit-dist">10 km • Ring Road</span>
                </div>
            </div>

            <div class="hrp-transit-card">
                <div class="hrp-transit-icon"><i class="fas fa-umbrella-beach"></i></div>
                <div>
                    <span class="hrp-transit-time">20 Mins Drive</span>
                    <h5 class="hrp-transit-name">Dumas Beach</h5>
                    <span class="hrp-transit-dist">14 km • Coastal Drive</span>
                </div>
            </div>

            <div class="hrp-transit-card">
                <div class="hrp-transit-icon"><i class="fas fa-shopping-bag"></i></div>
                <div>
                    <span class="hrp-transit-time">5 Mins Drive</span>
                    <h5 class="hrp-transit-name">VR Surat Mall</h5>
                    <span class="hrp-transit-dist">2.2 km • Dumas Rd</span>
                </div>
            </div>
        </div>

        {{-- Google Maps Embed & Address --}}
        <div class="row g-4 align-items-center mt-2">
            <div class="col-lg-7 col-md-12">
                <div class="rounded overflow-hidden" style="border: 1px solid var(--hrp-border); box-shadow: var(--shadow-md); height: 380px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.139!2d72.79!3d21.146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e0bb55f9c3b%3A0x2b0e21e2a34a4c38!2sAtlanta%20Business%20Hub%20VIP%20Rd%20Vesu%20Surat%20Gujarat!5e0!3m2!1sen!2sin!4v1234567890" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Hotel Rose Palace Google Maps"></iframe>
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="card p-4">
                    <span style="font-size: 12px; font-weight: 700; color: var(--hrp-gold); text-transform: uppercase; letter-spacing: 1px;">Property Address</span>
                    <h4 style="color: var(--hrp-plum); margin: 6px 0 16px;">Hotel Rose Palace</h4>
                    <p style="margin-bottom: 12px; color: var(--hrp-mauve); font-size: 14.5px;">
                        <i class="fas fa-map-marker-alt text-gold me-2"></i> 4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007
                    </p>
                    <p style="margin-bottom: 12px; color: var(--hrp-mauve); font-size: 14.5px;">
                        <i class="fas fa-phone-alt text-gold me-2"></i> <a href="tel:{{ config('hotel.contact.phone_1', '+918866771900') }}">{{ config('hotel.contact.phone_1', '+91 88667 71900') }}</a>
                    </p>
                    <p style="margin-bottom: 20px; color: var(--hrp-mauve); font-size: 14.5px;">
                        <i class="fas fa-envelope text-gold me-2"></i> <a href="mailto:{{ config('hotel.contact.email', 'Hotelrosepalacesurat@gmail.com') }}">{{ config('hotel.contact.email', 'Hotelrosepalacesurat@gmail.com') }}</a>
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ config('hotel.contact.google_maps', '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">
                            <i class="fas fa-directions"></i> Get GPS Directions
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-secondary btn-sm">
                            Contact Desk
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     8. AUTHENTIC GUEST REVIEWS, TRUST BADGES & FAQ
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider" style="background-color: var(--hrp-surface);">
    <div class="container">
        
        {{-- Reviews Header --}}
        <div class="text-center mb-5">
            <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">✦ Guest Experiences ✦</span>
            <h2 style="font-size: 38px; color: var(--hrp-plum);">Words from Our Honoured Guests</h2>
            <p style="max-width: 650px; margin: 0 auto; color: var(--hrp-mauve);">Verified reviews from diamond merchants, corporate travelers, and families visiting Surat.</p>
        </div>

        {{-- 3 Authentic Indian Reviews --}}
        <div class="row g-4 mb-5">
            
            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="d-flex align-items-center gap-1 text-gold mb-3" style="font-size: 14px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="ms-2" style="font-size: 12px; color: var(--hrp-mauve); font-weight: 600;">Verified Stay</span>
                    </div>
                    <p style="font-style: italic; color: var(--hrp-mauve); font-size: 14px; line-height: 1.7; flex-grow: 1;">
                        "Outstanding stay! Being only 15 minutes from the Surat Diamond Bourse in Khajod made all my business meetings stress-free. The rooms are brand new, spotlessly clean, and the staff is remarkably courteous."
                    </p>
                    <div class="d-flex align-items-center gap-3 pt-3" style="border-top: 1px solid var(--hrp-border);">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--hrp-tint); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--hrp-burgundy);">
                            RS
                        </div>
                        <div>
                            <h6 style="margin: 0; color: var(--hrp-plum);">Rajesh Shah</h6>
                            <span style="font-size: 12px; color: var(--hrp-mauve);">Diamond Merchant • Mumbai</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="d-flex align-items-center gap-1 text-gold mb-3" style="font-size: 14px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="ms-2" style="font-size: 12px; color: var(--hrp-mauve); font-weight: 600;">Family Celebration</span>
                    </div>
                    <p style="font-style: italic; color: var(--hrp-mauve); font-size: 14px; line-height: 1.7; flex-grow: 1;">
                        "We booked 8 rooms for a family wedding in Vesu. The pure veg breakfast buffet was heavenly, especially the Surati nylon khaman. The rooms were spacious with beautiful lighting. Highly recommended!"
                    </p>
                    <div class="d-flex align-items-center gap-3 pt-3" style="border-top: 1px solid var(--hrp-border);">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--hrp-tint); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--hrp-burgundy);">
                            AS
                        </div>
                        <div>
                            <h6 style="margin: 0; color: var(--hrp-plum);">Ananya & Prateek Sharma</h6>
                            <span style="font-size: 12px; color: var(--hrp-mauve);">Wedding Guests • Delhi NCR</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4">
                    <div class="d-flex align-items-center gap-1 text-gold mb-3" style="font-size: 14px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="ms-2" style="font-size: 12px; color: var(--hrp-mauve); font-weight: 600;">Corporate Stay</span>
                    </div>
                    <p style="font-style: italic; color: var(--hrp-mauve); font-size: 14px; line-height: 1.7; flex-grow: 1;">
                        "Excellent high-speed Wi-Fi, comfortable work desk, and seamless airport transit in just 12 minutes. The front desk team assisted with my early check-in seamlessly without extra hassle."
                    </p>
                    <div class="d-flex align-items-center gap-3 pt-3" style="border-top: 1px solid var(--hrp-border);">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--hrp-tint); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--hrp-burgundy);">
                            JP
                        </div>
                        <div>
                            <h6 style="margin: 0; color: var(--hrp-plum);">Dr. Jatin Patel</h6>
                            <span style="font-size: 12px; color: var(--hrp-mauve);">Healthcare Consultant • Ahmedabad</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Trust & Safety Badges --}}
        <div class="p-4 rounded mb-5 text-center" style="background: var(--hrp-tint); border: 1px solid var(--hrp-border);">
            <div class="row g-3 justify-content-center">
                <div class="col-sm-2 col-4">
                    <i class="fas fa-shield-virus text-gold fs-4 mb-2"></i>
                    <div style="font-size: 12px; font-weight: 700; color: var(--hrp-plum);">Sanitized Stays</div>
                </div>
                <div class="col-sm-2 col-4">
                    <i class="fas fa-parking text-gold fs-4 mb-2"></i>
                    <div style="font-size: 12px; font-weight: 700; color: var(--hrp-plum);">Free Valet Parking</div>
                </div>
                <div class="col-sm-2 col-4">
                    <i class="fas fa-wifi text-gold fs-4 mb-2"></i>
                    <div style="font-size: 12px; font-weight: 700; color: var(--hrp-plum);">500 Mbps Wi-Fi</div>
                </div>
                <div class="col-sm-2 col-4">
                    <i class="fas fa-user-shield text-gold fs-4 mb-2"></i>
                    <div style="font-size: 12px; font-weight: 700; color: var(--hrp-plum);">24/7 Front Desk</div>
                </div>
                <div class="col-sm-2 col-4">
                    <i class="fas fa-seedling text-gold fs-4 mb-2"></i>
                    <div style="font-size: 12px; font-weight: 700; color: var(--hrp-plum);">100% Pure Veg</div>
                </div>
            </div>
        </div>

        {{-- 5-Question Collapsible FAQ Accordion --}}
        <div class="hrp-faq-list">
            <div class="text-center mb-4">
                <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase;">✦ Frequent Inquiries ✦</span>
                <h3 style="color: var(--hrp-plum); font-size: 30px;">Frequently Asked Questions</h3>
            </div>

            <div class="hrp-faq-item active" onclick="toggleFaq(this)">
                <div class="hrp-faq-question">
                    <span>What are the check-in and check-out timings? Can I request early check-in?</span>
                    <i class="fas fa-chevron-down hrp-faq-icon"></i>
                </div>
                <div class="hrp-faq-answer">
                    Standard check-in is from 12:00 PM and check-out is until 11:00 AM. Direct website reservations enjoy complimentary priority early check-in (from 10:00 AM) and late check-out (up to 1:00 PM), subject to room availability upon arrival.
                </div>
            </div>

            <div class="hrp-faq-item" onclick="toggleFaq(this)">
                <div class="hrp-faq-question">
                    <span>What identity documents are required during hotel check-in?</span>
                    <i class="fas fa-chevron-down hrp-faq-icon"></i>
                </div>
                <div class="hrp-faq-answer">
                    In compliance with Indian government regulations, all adult guests must present an original government-issued photo ID (Aadhaar Card, Driving Licence, Voter ID, or Passport). PAN cards are not accepted as proof of residence. International guests must present a valid passport and Indian visa.
                </div>
            </div>

            <div class="hrp-faq-item" onclick="toggleFaq(this)">
                <div class="hrp-faq-question">
                    <span>Do you serve 100% Pure Vegetarian and Jain cuisine?</span>
                    <i class="fas fa-chevron-down hrp-faq-icon"></i>
                </div>
                <div class="hrp-faq-answer">
                    Yes, Hotel Rose Palace operates a strictly 100% Pure Vegetarian kitchen. Customized Jain preparations (made without onion, garlic, or root vegetables) are gladly prepared upon advance notice or dining order.
                </div>
            </div>

            <div class="hrp-faq-item" onclick="toggleFaq(this)">
                <div class="hrp-faq-question">
                    <span>How far is the hotel from Surat Airport and Surat Diamond Bourse?</span>
                    <i class="fas fa-chevron-down hrp-faq-icon"></i>
                </div>
                <div class="hrp-faq-answer">
                    Our hotel is located on VIP Road, Vesu — just 12 minutes (8.5 km) from Surat International Airport and 15 minutes (11 km) from the Surat Diamond Bourse in Khajod. We also provide direct airport pickup and drop-off taxi services upon request.
                </div>
            </div>

            <div class="hrp-faq-item" onclick="toggleFaq(this)">
                <div class="hrp-faq-question">
                    <span>What is your cancellation and booking modification policy?</span>
                    <i class="fas fa-chevron-down hrp-faq-icon"></i>
                </div>
                <div class="hrp-faq-answer">
                    Direct bookings via our official website can be cancelled or modified free of charge up to 24 hours prior to standard check-in time (12:00 PM). Cancellations made within 24 hours of arrival are subject to a one-night retention charge.
                </div>
            </div>

        </div>

    </div>
</section>

@endsection

@section('extra_js')
<script>
// Hero date synchronization
function syncHeroDates() {
    const dIn = document.getElementById('heroCheckIn')?.value;
    const dOut = document.getElementById('heroCheckOut')?.value;
    if (dIn && document.getElementById('modalCheckIn')) document.getElementById('modalCheckIn').value = dIn;
    if (dOut && document.getElementById('modalCheckOut')) document.getElementById('modalCheckOut').value = dOut;
}

function triggerHeroBookingModal() {
    const dIn = document.getElementById('heroCheckIn')?.value;
    const dOut = document.getElementById('heroCheckOut')?.value;
    const guests = document.getElementById('heroGuestsSelect')?.value || '2';
    window.openBookingModal(null, dIn, dOut, guests);
}

// Menu category tab switcher
function showMenuCategory(cat, btn) {
    document.querySelectorAll('.hrp-menu-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.menu-cat-item').forEach(el => el.classList.add('d-none'));
    document.querySelectorAll('.menu-' + cat).forEach(el => el.classList.remove('d-none'));
}

// Banquet quote calculator
function calculateBanquetQuote() {
    const guests = parseInt(document.getElementById('banquetGuests')?.value) || 100;
    const menuRate = parseFloat(document.getElementById('banquetMenu')?.value) || 750;
    const hallCharge = guests > 150 ? 25000 : 18000;

    const subtotal = (guests * menuRate) + hallCharge;
    const gst = Math.round(subtotal * 0.18);
    const total = subtotal + gst;

    document.getElementById('banquetSubtotal').textContent = '₹' + subtotal.toLocaleString('en-IN');
    document.getElementById('banquetGst').textContent = '₹' + gst.toLocaleString('en-IN');
    document.getElementById('banquetTotal').textContent = '₹' + total.toLocaleString('en-IN');
}

function sendBanquetWhatsAppQuote() {
    const date = document.getElementById('banquetDate')?.value || 'Upcoming Date';
    const type = document.getElementById('banquetType')?.value || 'Event';
    const guests = document.getElementById('banquetGuests')?.value || '100';
    const total = document.getElementById('banquetTotal')?.textContent || '';

    const msg = `*HOTEL ROSE PALACE — BANQUET HALL INQUIRY*
━━━━━━━━━━━━━━━━━━━━━━
🎉 *Event Type:* ${type.toUpperCase()}
📅 *Proposed Date:* ${date}
👥 *Expected Guests:* ${guests}
💰 *Estimated Budget:* ${total} (incl. 18% GST)
━━━━━━━━━━━━━━━━━━━━━━
Please provide customized catering packages and availability for this date.`;

    const waNumber = '{{ preg_replace("/\D/", "", config("hotel.contact.whatsapp_number", "918799129929")) }}';
    window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`, '_blank');
}

// FAQ Accordion Toggle
function toggleFaq(item) {
    const isActive = item.classList.contains('active');
    document.querySelectorAll('.hrp-faq-item').forEach(el => el.classList.remove('active'));
    if (!isActive) item.classList.add('active');
}

// Initialize Hero default dates
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);

    const checkIn = document.getElementById('heroCheckIn');
    const checkOut = document.getElementById('heroCheckOut');
    if (checkIn && checkOut) {
        checkIn.value = today.toISOString().split('T')[0];
        checkOut.value = tomorrow.toISOString().split('T')[0];
    }

    calculateBanquetQuote();
});
</script>
@endsection
