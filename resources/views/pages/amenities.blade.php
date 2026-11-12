@extends('layouts.app')

@section('title', 'World-Class Amenities — Hotel Rose Palace | Premium Facilities Surat')
@section('meta_description', 'Discover Hotel Rose Palace\'s world-class amenities — free Wi-Fi, fine dining, spa & wellness, fitness centre, 24/7 concierge, and much more in Surat, Gujarat.')
@section('meta_keywords', 'hotel amenities surat, hotel rose palace facilities, luxury hotel features, spa hotel surat, hotel parking surat')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="hrp-am-hero" id="amenities-hero">
    <div class="hrp-am-hero-overlay"></div>
    <div class="hrp-am-particles">
        <span></span><span></span><span></span>
    </div>
    <div class="container hrp-am-hero-container">
        <div class="hrp-page-hero-eyebrow">
            <span class="hrp-eyebrow-line"></span>
            <span>✦ Premium Facilities ✦</span>
            <span class="hrp-eyebrow-line"></span>
        </div>
        <h1 class="hrp-am-hero-title">World-Class Amenities</h1>
        <p class="hrp-am-hero-sub">Every detail thoughtfully designed for your comfort, convenience, and delight — because you deserve nothing but the best.</p>
        <nav class="hrp-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="hrp-bc-sep"><i class="fas fa-chevron-right"></i></span>
            <span>Amenities</span>
        </nav>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     AMENITIES HIGHLIGHTS (Icon Strips)
═══════════════════════════════════════════════════════ --}}
<div class="hrp-am-highlights-wrap">
    <div class="container">
        <div class="hrp-am-highlights">
            <div class="hrp-am-hl-item">
                <i class="fas fa-wifi"></i>
                <span>Free Wi-Fi</span>
            </div>
            <div class="hrp-am-hl-divider"></div>
            <div class="hrp-am-hl-item">
                <i class="fas fa-parking"></i>
                <span>Free Parking</span>
            </div>
            <div class="hrp-am-hl-divider"></div>
            <div class="hrp-am-hl-item">
                <i class="fas fa-concierge-bell"></i>
                <span>24/7 Concierge</span>
            </div>
            <div class="hrp-am-hl-divider"></div>
            <div class="hrp-am-hl-item">
                <i class="fas fa-spa"></i>
                <span>Spa & Wellness</span>
            </div>
            <div class="hrp-am-hl-divider"></div>
            <div class="hrp-am-hl-item">
                <i class="fas fa-utensils"></i>
                <span>Fine Dining</span>
            </div>
            <div class="hrp-am-hl-divider"></div>
            <div class="hrp-am-hl-item">
                <i class="fas fa-car"></i>
                <span>Airport Transfer</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     MAIN AMENITIES GRID
═══════════════════════════════════════════════════════ --}}
<section class="hrp-am-section" id="amenities-main">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Everything You Need</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Facilities & Services</h2>
            <p class="hrp-section-sub">From daily essentials to luxury extras — every amenity at Hotel Rose Palace is crafted to elevate your experience.</p>
        </div>

        @php
        $defaultAmenities = [
            [
                'icon' => 'fas fa-wifi',
                'name' => 'High-Speed Wi-Fi',
                'desc' => 'Complimentary ultra-fast internet with dedicated bandwidth throughout the hotel — including rooms, lobby, and dining areas.',
                'cat' => 'Connectivity',
                'detail' => '500 Mbps+ speed'
            ],
            [
                'icon' => 'fas fa-parking',
                'name' => 'Free Secure Parking',
                'desc' => 'Spacious, well-lit, CCTV-monitored parking for all guests. Valet service available on request.',
                'cat' => 'Transport',
                'detail' => 'CCTV monitored'
            ],
            [
                'icon' => 'fas fa-concierge-bell',
                'name' => '24/7 Concierge',
                'desc' => 'Round-the-clock personalised concierge service to assist with recommendations, reservations, and any special requests.',
                'cat' => 'Service',
                'detail' => 'Always available'
            ],
            [
                'icon' => 'fas fa-utensils',
                'name' => 'Multi-Cuisine Restaurant',
                'desc' => 'Savour authentic flavours from around the world at our award-winning restaurant with curated menus and sommelier service.',
                'cat' => 'Dining',
                'detail' => 'Open 7 AM – 11 PM'
            ],
            [
                'icon' => 'fas fa-spa',
                'name' => 'Spa & Wellness',
                'desc' => 'Rejuvenate body and mind with our signature treatments, aromatherapy, deep tissue massages, and wellness rituals.',
                'cat' => 'Wellness',
                'detail' => 'By appointment'
            ],
            [
                'icon' => 'fas fa-dumbbell',
                'name' => 'Fitness Centre',
                'desc' => 'State-of-the-art gymnasium with modern cardio and strength equipment, plus dedicated yoga and meditation studio.',
                'cat' => 'Wellness',
                'detail' => 'Open 6 AM – 10 PM'
            ],
            [
                'icon' => 'fas fa-tshirt',
                'name' => 'Laundry & Dry Cleaning',
                'desc' => 'Professional premium laundry and dry cleaning services with same-day express options available for all garments.',
                'cat' => 'Service',
                'detail' => 'Express available'
            ],
            [
                'icon' => 'fas fa-car',
                'name' => 'Airport Transfer',
                'desc' => 'Comfortable, reliable door-to-door airport and railway station transfers in premium vehicles, available 24 hours.',
                'cat' => 'Transport',
                'detail' => 'Pre-booking required'
            ],
            [
                'icon' => 'fas fa-shield-alt',
                'name' => '24/7 Security',
                'desc' => 'Round-the-clock CCTV surveillance, trained security personnel, and electronic access control for complete peace of mind.',
                'cat' => 'Safety',
                'detail' => 'Full CCTV coverage'
            ],
            [
                'icon' => 'fas fa-room-service',
                'name' => 'In-Room Dining',
                'desc' => 'Extensive in-room dining menu available from 6 AM to midnight. Hot, freshly prepared meals delivered to your door.',
                'cat' => 'Dining',
                'detail' => '6 AM – 12 AM'
            ],
            [
                'icon' => 'fas fa-briefcase',
                'name' => 'Business Centre',
                'desc' => 'Fully equipped business centre with printing, copying, computer workstations, and meeting room access.',
                'cat' => 'Business',
                'detail' => 'Open 24 hours'
            ],
            [
                'icon' => 'fas fa-glass-cheers',
                'name' => 'Banquet & Events',
                'desc' => 'Elegantly appointed banquet halls for weddings, corporate events, and social gatherings with professional event planning.',
                'cat' => 'Events',
                'detail' => 'Up to 500 guests'
            ],
        ];

        $amenityData = isset($amenities) && is_object($amenities)
            ? $amenities->flatMap(fn($group) => $group)->map(fn($a) => [
                'icon' => $a->icon_class ?? 'fas fa-star',
                'name' => $a->name,
                'desc' => $a->description ?? 'Premium facility available for all hotel guests.',
                'cat' => $a->category ?? 'Service',
                'detail' => null,
              ])->toArray()
            : $defaultAmenities;

        // Group by category
        $grouped = collect($amenityData)->groupBy('cat');
        @endphp

        {{-- Ungrouped Full Grid --}}
        <div class="row g-4" id="amenities-grid">
            @foreach($amenityData as $i => $am)
            <div class="col-lg-4 col-md-6" id="amenity-card-{{ $i }}">
                <div class="hrp-am-card">
                    <div class="hrp-am-card-top">
                        <div class="hrp-am-icon-wrap">
                            <i class="{{ $am['icon'] }}"></i>
                        </div>
                        <span class="hrp-am-cat-tag">{{ $am['cat'] }}</span>
                    </div>
                    <h4 class="hrp-am-name">{{ $am['name'] }}</h4>
                    <p class="hrp-am-desc">{{ $am['desc'] }}</p>
                    @if(!empty($am['detail']))
                    <div class="hrp-am-detail">
                        <i class="fas fa-clock"></i> {{ $am['detail'] }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     EXPERIENCE STRIP (Dark)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-am-experience-section">
    <div class="container">
        <div class="hrp-am-exp-grid">
            <div class="hrp-am-exp-content">
                <div class="hrp-section-eyebrow" style="color:#C5A059;">
                    <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
                    <span>Elevated Living</span>
                </div>
                <div class="hrp-gold-rule"></div>
                <h2 class="hrp-section-heading" style="color:#fff;">More Than Just a Stay</h2>
                <p class="hrp-am-exp-para">At Hotel Rose Palace, every amenity is curated to elevate your experience beyond the ordinary. From the moment you arrive until your departure, our team is dedicated to anticipating your every need.</p>
                <p class="hrp-am-exp-para">Whether you're here for business or leisure, our facilities ensure you're always at your best — refreshed, connected, and inspired.</p>
                <div class="hrp-am-exp-stats">
                    <div class="hrp-am-stat">
                        <span class="hrp-am-stat-num">50+</span>
                        <span class="hrp-am-stat-lbl">Luxury Rooms</span>
                    </div>
                    <div class="hrp-am-stat">
                        <span class="hrp-am-stat-num">12+</span>
                        <span class="hrp-am-stat-lbl">Premium Facilities</span>
                    </div>
                    <div class="hrp-am-stat">
                        <span class="hrp-am-stat-num">24/7</span>
                        <span class="hrp-am-stat-lbl">Guest Support</span>
                    </div>
                </div>
                <a href="{{ route('rooms') }}" class="hrp-btn-gold mt-4" id="amenities-explore-rooms">
                    <i class="fas fa-bed me-2"></i> Explore Rooms
                </a>
            </div>
            <div class="hrp-am-exp-imgs">
                <div class="hrp-am-exp-img-main">
                    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=700&q=85" alt="Spa & Wellness" loading="lazy">
                </div>
                <div class="hrp-am-exp-img-sm">
                    <img src="https://images.unsplash.com/photo-1521783593447-5702b9bfd267?w=400&q=80" alt="Executive Lounge" loading="lazy">
                </div>
                <div class="hrp-am-exp-badge">
                    <i class="fas fa-star"></i>
                    <div>
                        <span class="hrp-badge-n">4.8★</span>
                        <span class="hrp-badge-t">Rated by Guests</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     ENQUIRY CTA
═══════════════════════════════════════════════════════ --}}
<section class="hrp-am-cta-section">
    <div class="container">
        <div class="hrp-am-cta-inner text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Get In Touch</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Ready to Experience Luxury?</h2>
            <p class="hrp-section-sub">Have questions about our facilities or want to make a reservation? Our team is here to help 24/7.</p>
            <div class="hrp-am-cta-btns">
                <a href="{{ route('contact') }}" class="hrp-btn-gold" id="amenities-contact-btn">
                    <i class="fas fa-paper-plane me-2"></i> Contact Us
                </a>
                <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}?text={{ urlencode('Hello! I would like to know more about the amenities and facilities at Hotel Rose Palace.') }}"
                   target="_blank" class="hrp-am-wa-btn" id="amenities-wa-btn">
                    <i class="fab fa-whatsapp"></i> WhatsApp Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

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

/* ── Shared ─────────────────────────────────────────────── */
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
    flex: 1; max-width: 40px; height: 1.5px;
    background: var(--gold); border-radius: 2px;
}
.hrp-gold-rule {
    width: 50px; height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--gold-lt));
    border-radius: 2px; margin: 10px 0 20px;
}
.hrp-gold-rule--center { margin: 10px auto 24px; }
.hrp-section-heading {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px,4vw,40px);
    color: var(--navy); font-weight: 700;
    margin-bottom: 12px; line-height: 1.25;
}
.hrp-section-sub {
    font-size: 15.5px; color: var(--txt);
    max-width: 620px; margin: 0 auto 48px; line-height: 1.75;
}
.hrp-section-header { margin-bottom: 0; }
.hrp-btn-gold {
    display: inline-flex; align-items: center;
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    color: var(--navy); font-family: 'Poppins', sans-serif;
    font-weight: 700; font-size: 14.5px;
    padding: 14px 32px; border-radius: 50px;
    text-decoration: none; transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(197,160,89,0.35);
    white-space: nowrap;
}
.hrp-btn-gold:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(197,160,89,0.5); color: var(--navy); }

/* ── HERO ───────────────────────────────────────────────── */
.hrp-am-hero {
    position: relative;
    min-height: 480px;
    background: linear-gradient(165deg, rgba(14,22,32,0.9) 0%, rgba(14,22,32,0.7) 50%, rgba(197,160,89,0.12) 100%),
                url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1600&q=90') center/cover no-repeat;
    display: flex; align-items: center; overflow: hidden;
}
.hrp-am-hero-overlay {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 20% 50%, rgba(197,160,89,0.07) 0%, transparent 65%);
}
.hrp-am-particles { position: absolute; inset: 0; pointer-events: none; }
.hrp-am-particles span {
    position: absolute; display: block; border-radius: 50%;
    background: rgba(197,160,89,0.3);
    animation: hrpFloat 8s ease-in-out infinite;
}
.hrp-am-particles span:nth-child(1){width:5px;height:5px;top:25%;left:20%;animation-delay:0s;}
.hrp-am-particles span:nth-child(2){width:3px;height:3px;top:60%;left:75%;animation-delay:3s;}
.hrp-am-particles span:nth-child(3){width:7px;height:7px;top:70%;left:40%;animation-delay:5s;}
@keyframes hrpFloat { 0%,100%{transform:translateY(0);opacity:0.4;} 50%{transform:translateY(-18px);opacity:0.9;} }
.hrp-am-hero-container {
    position: relative; z-index: 2;
    padding: 100px 24px 60px; text-align: center;
}
.hrp-page-hero-eyebrow {
    display: inline-flex; align-items: center; gap: 14px;
    font-family: 'Poppins', sans-serif; font-size: 11px;
    font-weight: 700; letter-spacing: 3.5px; text-transform: uppercase;
    color: var(--gold); margin-bottom: 20px;
}
.hrp-eyebrow-line {
    display: block; width: 40px; height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold));
}
.hrp-eyebrow-line:last-child { background: linear-gradient(90deg, var(--gold), transparent); }
.hrp-am-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(40px, 6vw, 70px); font-weight: 700;
    color: #fff; margin-bottom: 16px; line-height: 1.1;
    text-shadow: 0 2px 40px rgba(0,0,0,0.3);
}
.hrp-am-hero-sub {
    font-size: clamp(14px,1.8vw,17px); color: rgba(255,255,255,0.75);
    max-width: 600px; margin: 0 auto 24px; line-height: 1.8;
}
.hrp-breadcrumb {
    display: inline-flex; align-items: center; gap: 10px;
    font-family: 'Poppins', sans-serif; font-size: 12.5px;
    color: rgba(255,255,255,0.5);
}
.hrp-breadcrumb a { color: var(--gold); text-decoration: none; transition: color 0.2s ease; }
.hrp-breadcrumb a:hover { color: #fff; }
.hrp-bc-sep { font-size: 9px; color: rgba(255,255,255,0.3); }

/* ── HIGHLIGHTS STRIP ───────────────────────────────────── */
.hrp-am-highlights-wrap {
    background: var(--white);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    border-top: 3px solid var(--gold);
    position: relative; z-index: 10;
}
.hrp-am-highlights {
    display: flex; align-items: center;
    justify-content: center; flex-wrap: wrap;
    padding: 20px 0;
}
.hrp-am-hl-item {
    display: flex; align-items: center;
    gap: 10px; padding: 10px 28px;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px; font-weight: 600; color: var(--navy);
    white-space: nowrap;
}
.hrp-am-hl-item i { color: var(--gold); font-size: 18px; }
.hrp-am-hl-divider { width: 1px; height: 32px; background: rgba(197,160,89,0.2); }

/* ── AMENITIES GRID ─────────────────────────────────────── */
.hrp-am-section { padding: 96px 0; background: var(--cream); }
.hrp-am-card {
    background: var(--white);
    border-radius: var(--r-md);
    padding: 28px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1.5px solid transparent;
    transition: all 0.35s ease;
    height: 100%;
}
.hrp-am-card:hover {
    border-color: rgba(197,160,89,0.3);
    transform: translateY(-6px);
    box-shadow: 0 16px 50px rgba(0,0,0,0.1);
}
.hrp-am-card-top {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 16px;
}
.hrp-am-icon-wrap {
    width: 56px; height: 56px; border-radius: 14px;
    background: linear-gradient(135deg, rgba(197,160,89,0.12), rgba(197,160,89,0.06));
    border: 1px solid rgba(197,160,89,0.2);
    display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease; flex-shrink: 0;
}
.hrp-am-card:hover .hrp-am-icon-wrap {
    background: linear-gradient(135deg, rgba(197,160,89,0.2), rgba(197,160,89,0.1));
    box-shadow: 0 0 20px rgba(197,160,89,0.3);
}
.hrp-am-icon-wrap i { color: var(--gold); font-size: 22px; }
.hrp-am-cat-tag {
    font-family: 'Poppins', sans-serif; font-size: 10px;
    font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    color: var(--gold); background: rgba(197,160,89,0.1);
    border: 1px solid rgba(197,160,89,0.2);
    padding: 4px 10px; border-radius: 50px;
}
.hrp-am-name {
    font-family: 'Playfair Display', serif; font-size: 20px;
    color: var(--navy); margin-bottom: 10px; font-weight: 700;
}
.hrp-am-desc { font-size: 14px; color: var(--txt); line-height: 1.7; margin-bottom: 14px; }
.hrp-am-detail {
    display: inline-flex; align-items: center; gap: 7px;
    font-family: 'Poppins', sans-serif; font-size: 12px;
    color: #888; background: var(--cream);
    padding: 5px 12px; border-radius: 50px;
}
.hrp-am-detail i { color: var(--gold); font-size: 10px; }

/* ── EXPERIENCE SECTION ─────────────────────────────────── */
.hrp-am-experience-section {
    padding: 96px 0;
    background: linear-gradient(160deg, #0E1620 0%, #1A222D 60%, #0E1620 100%);
    position: relative; overflow: hidden;
}
.hrp-am-experience-section::before {
    content: '';
    position: absolute; top: -100px; right: -100px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(197,160,89,0.06) 0%, transparent 70%);
}
.hrp-am-exp-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}
.hrp-am-exp-para {
    font-size: 15px; color: rgba(255,255,255,0.65);
    line-height: 1.85; margin-bottom: 16px;
}
.hrp-am-exp-stats {
    display: flex; gap: 32px; flex-wrap: wrap;
    padding: 24px; background: rgba(255,255,255,0.04);
    border-radius: var(--r-md); border: 1px solid rgba(197,160,89,0.15);
    margin-top: 24px;
}
.hrp-am-stat { display: flex; flex-direction: column; }
.hrp-am-stat-num {
    font-family: 'Playfair Display', serif; font-size: 28px;
    font-weight: 700; color: var(--gold); line-height: 1;
    margin-bottom: 4px;
}
.hrp-am-stat-lbl {
    font-size: 11px; color: rgba(255,255,255,0.5);
    font-family: 'Poppins', sans-serif;
    letter-spacing: 0.8px; text-transform: uppercase;
}
.hrp-am-exp-imgs {
    position: relative;
    padding-bottom: 32px; padding-left: 32px;
}
.hrp-am-exp-img-main {
    position: relative; z-index: 1;
    border-radius: var(--r-md); overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}
.hrp-am-exp-img-main img {
    width: 100%; height: 440px; object-fit: cover;
    display: block;
}
.hrp-am-exp-img-sm {
    position: absolute; bottom: 0; left: 0; z-index: 2;
    width: 48%; border-radius: var(--r-md); overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    border: 3px solid rgba(197,160,89,0.2);
}
.hrp-am-exp-img-sm img { width: 100%; height: 200px; object-fit: cover; display: block; }
.hrp-am-exp-badge {
    position: absolute; bottom: 16px; right: 0; z-index: 3;
    background: var(--white); border-radius: 12px;
    padding: 12px 18px;
    display: flex; align-items: center; gap: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    border-left: 4px solid var(--gold);
}
.hrp-am-exp-badge i { color: var(--gold); font-size: 22px; }
.hrp-badge-n { display: block; font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: var(--navy); line-height: 1; }
.hrp-badge-t { display: block; font-size: 11px; color: #888; font-family: 'Poppins', sans-serif; }

/* ── CTA SECTION ────────────────────────────────────────── */
.hrp-am-cta-section { padding: 96px 0; background: var(--white); }
.hrp-am-cta-inner { }
.hrp-am-cta-btns {
    display: flex; gap: 16px;
    flex-wrap: wrap; justify-content: center;
}
.hrp-am-wa-btn {
    display: inline-flex; align-items: center; gap: 8px;
    border: 1.5px solid rgba(37,211,102,0.5);
    color: #1a9e4a; font-family: 'Poppins', sans-serif;
    font-size: 14px; font-weight: 600;
    padding: 13px 28px; border-radius: 50px;
    text-decoration: none; transition: all 0.3s ease;
}
.hrp-am-wa-btn i { font-size: 18px; }
.hrp-am-wa-btn:hover { background: #25D366; color: #fff; border-color: #25D366; }

/* ── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 991px) {
    .hrp-am-exp-grid { grid-template-columns: 1fr; gap: 48px; }
    .hrp-am-exp-imgs { display: none; }
    .hrp-am-highlights { justify-content: flex-start; overflow-x: auto; padding: 20px 16px; }
}
@media (max-width: 767px) {
    .hrp-am-hl-divider { display: none; }
    .hrp-am-hl-item { min-width: 50%; justify-content: center; }
    .hrp-am-cta-btns { flex-direction: column; align-items: stretch; }
    section { padding: 64px 0; }
}
</style>
@endsection

@section('extra_js')
<script>
// Scroll-reveal animation
(function(){
    if(!('IntersectionObserver' in window)) return;
    const els = document.querySelectorAll('.hrp-am-card, .hrp-am-hl-item');
    const io = new IntersectionObserver(entries => {
        entries.forEach((e, i) => {
            if(e.isIntersecting) {
                setTimeout(() => e.target.classList.add('hrp-revealed'), i * 80);
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    els.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        io.observe(el);
    });
    document.head.insertAdjacentHTML('beforeend', '<style>.hrp-revealed{opacity:1!important;transform:none!important;}</style>');
})();
</script>
@endsection
