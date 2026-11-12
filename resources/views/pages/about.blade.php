@extends('layouts.app')

@section('title', 'About Hotel Rose Palace — Our Story, Mission & Values | Surat')
@section('meta_description', 'Discover the story behind Hotel Rose Palace, Surat. Learn about our commitment to luxury hospitality, our values, and our vision to redefine premium stays in Gujarat.')
@section('meta_keywords', 'about hotel rose palace, hotel story surat, luxury hotel mission, hotel rose palace history')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="hrp-about-hero" id="about-hero">
    <div class="hrp-about-hero-overlay"></div>
    <div class="hrp-ab-particles">
        <span></span><span></span><span></span><span></span>
    </div>
    <div class="container hrp-about-hero-container">
        <div class="hrp-page-hero-eyebrow">
            <span class="hrp-eyebrow-line"></span>
            <span>✦ Our Legacy ✦</span>
            <span class="hrp-eyebrow-line"></span>
        </div>
        <h1 class="hrp-about-hero-title">About Hotel<br><em class="hrp-ab-em">Rose Palace</em></h1>
        <p class="hrp-about-hero-sub">A sanctuary of elegance nestled in the heart of Surat — where every moment is crafted to create memories that last a lifetime.</p>
        <nav class="hrp-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="hrp-bc-sep"><i class="fas fa-chevron-right"></i></span>
            <span>About Us</span>
        </nav>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     OUR STORY
═══════════════════════════════════════════════════════ --}}
<section class="hrp-about-story" id="our-story">
    <div class="container">
        <div class="row align-items-center g-5">
            {{-- Image --}}
            <div class="col-lg-5 col-md-12">
                <div class="hrp-about-img-frame">
                    <div class="hrp-ab-img-deco"></div>
                    <img
                        src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=700&q=85"
                        alt="Hotel Rose Palace Lobby"
                        class="hrp-about-main-img"
                        loading="lazy"
                    >
                    <div class="hrp-ab-year-badge">
                        <span class="hrp-ab-yr-num">Est.</span>
                        <span class="hrp-ab-yr-txt">Surat, Gujarat</span>
                    </div>
                </div>
            </div>

            {{-- Text --}}
            <div class="col-lg-7 col-md-12">
                <div class="hrp-about-text">
                    <div class="hrp-section-eyebrow">
                        <span class="hrp-eyebrow-dash"></span>
                        <span>Our Beginning</span>
                    </div>
                    <div class="hrp-gold-rule"></div>
                    <h2 class="hrp-section-heading">A Story of Passion<br><span class="hrp-heading-em">& Hospitality</span></h2>

                    <p class="hrp-about-para">Hotel Rose Palace was founded with a singular vision — to redefine luxury hospitality in Surat. From our very first guest, we have remained steadfastly committed to excellence, warmth, and creating experiences that resonate long after checkout.</p>

                    <p class="hrp-about-para">Our name, "Rose Palace," is not merely symbolic — it embodies the elegance of a rose and the grandeur of a palace. Every room, every meal, every interaction with our team reflects this belief: that hospitality is an art, and our guests deserve nothing short of a masterpiece.</p>

                    <p class="hrp-about-para">Situated at the heart of Vesu on VIP Road, Hotel Rose Palace is ideally positioned to serve both corporate travelers and leisure guests seeking premium comfort in Surat's most vibrant locale.</p>

                    <div class="hrp-about-pillars">
                        <div class="hrp-about-pillar">
                            <i class="fas fa-award"></i>
                            <div>
                                <strong>Award-Winning Service</strong>
                                <span>Recognised for excellence in hospitality</span>
                            </div>
                        </div>
                        <div class="hrp-about-pillar">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Prime Location</strong>
                                <span>VIP Road, Vesu — heart of Surat</span>
                            </div>
                        </div>
                        <div class="hrp-about-pillar">
                            <i class="fas fa-star"></i>
                            <div>
                                <strong>4.8★ Guest Rating</strong>
                                <span>Consistently top-rated by our guests</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     STATS SECTION
═══════════════════════════════════════════════════════ --}}
<section class="hrp-about-stats-section">
    <div class="container">
        <div class="hrp-about-stats-grid">
            <div class="hrp-ab-stat-card" id="stat-rooms">
                <div class="hrp-ab-stat-icon"><i class="fas fa-bed"></i></div>
                <div class="hrp-ab-stat-num" data-count="50">50</div>
                <div class="hrp-ab-stat-plus">+</div>
                <div class="hrp-ab-stat-label">Luxury Rooms & Suites</div>
            </div>
            <div class="hrp-ab-stat-card" id="stat-rating">
                <div class="hrp-ab-stat-icon"><i class="fas fa-star"></i></div>
                <div class="hrp-ab-stat-num">4.8</div>
                <div class="hrp-ab-stat-plus">★</div>
                <div class="hrp-ab-stat-label">Average Guest Rating</div>
            </div>
            <div class="hrp-ab-stat-card" id="stat-guests">
                <div class="hrp-ab-stat-icon"><i class="fas fa-users"></i></div>
                <div class="hrp-ab-stat-num" data-count="10000">10K</div>
                <div class="hrp-ab-stat-plus">+</div>
                <div class="hrp-ab-stat-label">Happy Guests Served</div>
            </div>
            <div class="hrp-ab-stat-card" id="stat-service">
                <div class="hrp-ab-stat-icon"><i class="fas fa-concierge-bell"></i></div>
                <div class="hrp-ab-stat-num">24</div>
                <div class="hrp-ab-stat-plus">/7</div>
                <div class="hrp-ab-stat-label">Concierge & Dining</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     MISSION & VISION (Dark)
═══════════════════════════════════════════════════════ --}}
<section class="hrp-about-mission-section" id="mission">
    <div class="container">
        <div class="row align-items-center g-5">
            {{-- Text --}}
            <div class="col-lg-6">
                <div class="hrp-section-eyebrow" style="color:#C5A059;">
                    <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
                    <span>Our Purpose</span>
                </div>
                <div class="hrp-gold-rule"></div>
                <h2 class="hrp-section-heading" style="color:#fff;">Mission &<br><span class="hrp-heading-em">Vision</span></h2>

                <p class="hrp-mission-para">Our mission is to provide exceptional hospitality that transforms every stay into an unforgettable experience. We believe in creating moments where guests feel genuinely valued, completely comfortable, and perfectly cared for.</p>

                <div class="hrp-mission-cards">
                    <div class="hrp-mission-card" id="mission-card-1">
                        <div class="hrp-mc-icon"><i class="fas fa-bullseye"></i></div>
                        <div>
                            <h5 class="hrp-mc-title">Our Mission</h5>
                            <p class="hrp-mc-text">To exceed guest expectations at every touchpoint through personalized service, premium facilities, and genuine Gujarati warmth.</p>
                        </div>
                    </div>
                    <div class="hrp-mission-card" id="mission-card-2">
                        <div class="hrp-mc-icon"><i class="fas fa-eye"></i></div>
                        <div>
                            <h5 class="hrp-mc-title">Our Vision</h5>
                            <p class="hrp-mc-text">To be the most trusted and preferred luxury hotel in Surat — a beacon of elegance, comfort, and heartfelt hospitality.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Image Grid --}}
            <div class="col-lg-6">
                <div class="hrp-mission-imgs">
                    <div class="hrp-mi-top">
                        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600&q=80" alt="Premium Lobby" loading="lazy">
                    </div>
                    <div class="hrp-mi-bottom">
                        <div class="hrp-mi-b1">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&q=80" alt="Luxury Room" loading="lazy">
                        </div>
                        <div class="hrp-mi-b2">
                            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=400&q=80" alt="Fine Dining" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     CORE VALUES
═══════════════════════════════════════════════════════ --}}
<section class="hrp-about-values-section hrp-bg-cream" id="values">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>What We Stand For</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Our Core Values</h2>
            <p class="hrp-section-sub">These aren't just words — they are the guiding principles behind every decision, every interaction, and every experience at Hotel Rose Palace.</p>
        </div>

        <div class="row g-4">
            @php
            $values = [
                ['icon' => 'fas fa-heart', 'color' => '#C5A059', 'title' => 'Warm Hospitality', 'desc' => 'We treat every guest like family, ensuring their comfort, joy, and satisfaction is at the core of everything we do.'],
                ['icon' => 'fas fa-crown', 'color' => '#9B59B6', 'title' => 'Excellence', 'desc' => 'We pursue excellence in every detail — from room design and culinary art to service delivery and guest care.'],
                ['icon' => 'fas fa-handshake', 'color' => '#1A7A5E', 'title' => 'Integrity', 'desc' => 'We operate with absolute honesty and transparency, building trust with our guests, partners, and community.'],
                ['icon' => 'fas fa-leaf', 'color' => '#27AE60', 'title' => 'Sustainability', 'desc' => 'We care deeply for the environment and community we serve, integrating sustainable practices in our daily operations.'],
                ['icon' => 'fas fa-lightbulb', 'color' => '#F39C12', 'title' => 'Innovation', 'desc' => 'We continuously innovate and evolve our offerings to stay ahead of guest expectations and industry trends.'],
                ['icon' => 'fas fa-users', 'color' => '#3498DB', 'title' => 'Community', 'desc' => 'We are proud members of the Surat community, fostering local employment and supporting regional growth.'],
            ];
            @endphp

            @foreach($values as $i => $val)
            <div class="col-lg-4 col-md-6">
                <div class="hrp-value-card" id="value-card-{{ $i }}">
                    <div class="hrp-val-icon-wrap" style="background: {{ $val['color'] }}1A; border-color: {{ $val['color'] }}33;">
                        <i class="{{ $val['icon'] }}" style="color: {{ $val['color'] }};"></i>
                    </div>
                    <h4 class="hrp-val-title">{{ $val['title'] }}</h4>
                    <p class="hrp-val-desc">{{ $val['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     TEAM / COMMITMENT SECTION
═══════════════════════════════════════════════════════ --}}
<section class="hrp-about-team-section" id="team">
    <div class="container">
        <div class="hrp-about-team-inner">
            <div class="hrp-team-content text-center">
                <div class="hrp-section-eyebrow justify-content-center">
                    <span class="hrp-eyebrow-dash"></span>
                    <span>Our Promise</span>
                    <span class="hrp-eyebrow-dash"></span>
                </div>
                <div class="hrp-gold-rule hrp-gold-rule--center"></div>
                <h2 class="hrp-section-heading">Our Commitment to You</h2>
                <p class="hrp-about-commit-para">Every member of our team at Hotel Rose Palace is trained not just to meet expectations, but to exceed them. We understand that your time is precious, and your stay with us is a gift you give yourself — we promise to make it extraordinary.</p>
                <p class="hrp-about-commit-para">From the moment you step through our doors, our dedicated team will ensure your every need is anticipated and fulfilled with warmth, efficiency, and genuine care.</p>

                <div class="hrp-about-cta-row">
                    <a href="{{ route('rooms') }}" class="hrp-btn-gold" id="about-explore-rooms">
                        <i class="fas fa-bed me-2"></i> Explore Our Rooms
                    </a>
                    <a href="{{ route('contact') }}" class="hrp-btn-outline-navy" id="about-contact-btn">
                        <i class="fas fa-paper-plane me-2"></i> Get In Touch
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}?text={{ urlencode('Hello! I would like to know more about Hotel Rose Palace.') }}"
                       target="_blank" class="hrp-about-wa-btn" id="about-wa-btn">
                        <i class="fab fa-whatsapp"></i> WhatsApp Us
                    </a>
                </div>
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
.hrp-heading-em { color: var(--gold); font-style: italic; }
.hrp-section-sub { font-size: 15.5px; color: var(--txt); max-width: 620px; margin: 0 auto 48px; line-height: 1.75; }
.hrp-section-header { margin-bottom: 0; }
.hrp-btn-gold { display: inline-flex; align-items: center; background: linear-gradient(135deg, var(--gold), var(--gold-lt)); color: var(--navy); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14.5px; padding: 14px 32px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(197,160,89,0.35); white-space: nowrap; }
.hrp-btn-gold:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(197,160,89,0.5); color: var(--navy); }
.hrp-btn-outline-navy { display: inline-flex; align-items: center; background: transparent; border: 2px solid var(--navy); color: var(--navy); font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 14.5px; padding: 13px 32px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; }
.hrp-btn-outline-navy:hover { background: var(--navy); color: var(--gold); transform: translateY(-2px); }

/* ── HERO ───────────────────────────────────────────────── */
.hrp-about-hero {
    position: relative; min-height: 480px;
    background: linear-gradient(165deg, rgba(14,22,32,0.88) 0%, rgba(14,22,32,0.68) 50%, rgba(197,160,89,0.12) 100%),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&q=90') center/cover no-repeat;
    display: flex; align-items: center; overflow: hidden;
}
.hrp-about-hero-overlay { position: absolute; inset: 0; background: radial-gradient(ellipse at 25% 50%, rgba(197,160,89,0.07) 0%, transparent 65%); }
.hrp-ab-particles { position: absolute; inset: 0; pointer-events: none; }
.hrp-ab-particles span { position: absolute; display: block; border-radius: 50%; background: rgba(197,160,89,0.3); animation: hrpFloat 8s ease-in-out infinite; }
.hrp-ab-particles span:nth-child(1){width:5px;height:5px;top:20%;left:15%;animation-delay:0s;}
.hrp-ab-particles span:nth-child(2){width:3px;height:3px;top:65%;left:80%;animation-delay:2.5s;}
.hrp-ab-particles span:nth-child(3){width:7px;height:7px;top:75%;left:35%;animation-delay:5s;}
.hrp-ab-particles span:nth-child(4){width:4px;height:4px;top:40%;left:60%;animation-delay:1s;}
@keyframes hrpFloat { 0%,100%{transform:translateY(0);opacity:0.4;} 50%{transform:translateY(-18px);opacity:0.9;} }
.hrp-about-hero-container { position: relative; z-index: 2; padding: 100px 24px 60px; text-align: center; }
.hrp-page-hero-eyebrow { display: inline-flex; align-items: center; gap: 14px; font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3.5px; text-transform: uppercase; color: var(--gold); margin-bottom: 20px; }
.hrp-eyebrow-line { display: block; width: 40px; height: 1px; background: linear-gradient(90deg, transparent, var(--gold)); }
.hrp-eyebrow-line:last-child { background: linear-gradient(90deg, var(--gold), transparent); }
.hrp-about-hero-title { font-family: 'Playfair Display', serif; font-size: clamp(40px,6vw,70px); font-weight: 700; color: #fff; margin-bottom: 16px; line-height: 1.1; text-shadow: 0 2px 40px rgba(0,0,0,0.3); }
.hrp-ab-em { font-style: italic; color: var(--gold); display: block; }
.hrp-about-hero-sub { font-size: clamp(14px,1.8vw,17px); color: rgba(255,255,255,0.75); max-width: 600px; margin: 0 auto 24px; line-height: 1.8; }
.hrp-breadcrumb { display: inline-flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-size: 12.5px; color: rgba(255,255,255,0.5); }
.hrp-breadcrumb a { color: var(--gold); text-decoration: none; transition: color 0.2s ease; }
.hrp-breadcrumb a:hover { color: #fff; }
.hrp-bc-sep { font-size: 9px; color: rgba(255,255,255,0.3); }

/* ── OUR STORY ──────────────────────────────────────────── */
.hrp-about-story { padding: 96px 0; background: var(--white); }
.hrp-about-img-frame { position: relative; padding-bottom: 32px; padding-right: 32px; }
.hrp-ab-img-deco { position: absolute; bottom: 0; right: 0; width: 85%; height: 85%; border: 3px solid var(--gold); border-radius: 16px; opacity: 0.35; z-index: 0; }
.hrp-about-main-img { position: relative; z-index: 1; width: 100%; height: 480px; object-fit: cover; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
.hrp-ab-year-badge { position: absolute; bottom: 48px; right: 48px; z-index: 2; background: var(--white); border-radius: 12px; padding: 12px 20px; display: flex; flex-direction: column; gap: 2px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); border-left: 4px solid var(--gold); }
.hrp-ab-yr-num { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: var(--navy); line-height: 1; }
.hrp-ab-yr-txt { font-size: 11px; color: #888; font-family: 'Poppins', sans-serif; }
.hrp-about-para { font-size: 15.5px; line-height: 1.85; color: var(--txt); margin-bottom: 16px; }
.hrp-about-pillars { display: flex; flex-direction: column; gap: 14px; margin-top: 28px; padding: 24px; background: var(--cream); border-radius: 16px; border-left: 4px solid var(--gold); }
.hrp-about-pillar { display: flex; align-items: center; gap: 14px; }
.hrp-about-pillar i { color: var(--gold); font-size: 18px; width: 20px; text-align: center; flex-shrink: 0; }
.hrp-about-pillar strong { display: block; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 700; color: var(--navy); }
.hrp-about-pillar span { font-size: 12.5px; color: #888; }

/* ── STATS SECTION ──────────────────────────────────────── */
.hrp-about-stats-section {
    padding: 48px 0;
    background: linear-gradient(135deg, #0E1620 0%, #1A222D 100%);
    border-top: 1px solid rgba(197,160,89,0.15);
    border-bottom: 1px solid rgba(197,160,89,0.15);
}
.hrp-about-stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 0; }
.hrp-ab-stat-card { text-align: center; padding: 32px 20px; border-right: 1px solid rgba(197,160,89,0.12); }
.hrp-ab-stat-card:last-child { border-right: none; }
.hrp-ab-stat-icon { margin-bottom: 12px; font-size: 28px; color: rgba(197,160,89,0.3); }
.hrp-ab-stat-num { font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 700; color: var(--gold); line-height: 1; display: inline; }
.hrp-ab-stat-plus { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--gold); display: inline; }
.hrp-ab-stat-label { display: block; font-size: 11.5px; color: rgba(255,255,255,0.5); font-family: 'Poppins', sans-serif; letter-spacing: 1px; text-transform: uppercase; margin-top: 8px; }

/* ── MISSION SECTION ────────────────────────────────────── */
.hrp-about-mission-section { padding: 96px 0; background: linear-gradient(160deg, #0E1620 0%, #1A222D 60%, #0E1620 100%); position: relative; overflow: hidden; }
.hrp-about-mission-section::before { content: ''; position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(197,160,89,0.06) 0%, transparent 70%); pointer-events: none; }
.hrp-mission-para { font-size: 15px; color: rgba(255,255,255,0.65); line-height: 1.85; margin-bottom: 20px; }
.hrp-mission-cards { display: flex; flex-direction: column; gap: 16px; margin-top: 24px; }
.hrp-mission-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(197,160,89,0.15); border-radius: 14px; padding: 20px; display: flex; gap: 16px; align-items: flex-start; transition: all 0.3s ease; }
.hrp-mission-card:hover { background: rgba(255,255,255,0.08); border-color: rgba(197,160,89,0.3); }
.hrp-mc-icon { width: 44px; height: 44px; border-radius: 10px; background: rgba(197,160,89,0.12); border: 1px solid rgba(197,160,89,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.hrp-mc-icon i { color: var(--gold); font-size: 18px; }
.hrp-mc-title { font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 6px; }
.hrp-mc-text { font-size: 13.5px; color: rgba(255,255,255,0.55); line-height: 1.65; margin: 0; }

/* Mission image grid */
.hrp-mission-imgs { display: flex; flex-direction: column; gap: 12px; }
.hrp-mi-top { border-radius: 14px; overflow: hidden; }
.hrp-mi-top img { width: 100%; height: 240px; object-fit: cover; display: block; }
.hrp-mi-bottom { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.hrp-mi-b1, .hrp-mi-b2 { border-radius: 14px; overflow: hidden; }
.hrp-mi-b1 img, .hrp-mi-b2 img { width: 100%; height: 160px; object-fit: cover; display: block; }

/* ── VALUES SECTION ─────────────────────────────────────── */
.hrp-about-values-section { padding: 96px 0; }
.hrp-value-card { background: var(--white); border-radius: 16px; padding: 32px 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1.5px solid transparent; transition: all 0.35s ease; height: 100%; }
.hrp-value-card:hover { border-color: rgba(197,160,89,0.3); transform: translateY(-6px); box-shadow: 0 16px 50px rgba(0,0,0,0.1); }
.hrp-val-icon-wrap { width: 60px; height: 60px; border-radius: 15px; border: 1.5px solid; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; transition: all 0.3s ease; }
.hrp-value-card:hover .hrp-val-icon-wrap { box-shadow: 0 0 20px currentColor; }
.hrp-val-icon-wrap i { font-size: 24px; }
.hrp-val-title { font-family: 'Playfair Display', serif; font-size: 20px; color: var(--navy); margin-bottom: 10px; font-weight: 700; }
.hrp-val-desc { font-size: 14px; color: var(--txt); line-height: 1.7; margin: 0; }

/* ── TEAM/COMMIT SECTION ────────────────────────────────── */
.hrp-about-team-section { padding: 96px 0; background: var(--white); }
.hrp-about-team-inner { }
.hrp-about-commit-para { font-size: 15.5px; color: var(--txt); line-height: 1.85; max-width: 680px; margin: 0 auto 16px; }
.hrp-about-cta-row { display: flex; gap: 16px; flex-wrap: wrap; justify-content: center; margin-top: 36px; }
.hrp-about-wa-btn { display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid rgba(37,211,102,0.5); color: #1a9e4a; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; padding: 13px 28px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; }
.hrp-about-wa-btn i { font-size: 18px; }
.hrp-about-wa-btn:hover { background: #25D366; color: #fff; border-color: #25D366; }

/* ── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 991px) {
    .hrp-about-stats-grid { grid-template-columns: repeat(2,1fr); }
    .hrp-ab-stat-card:nth-child(2) { border-right: none; }
    .hrp-ab-stat-card:nth-child(3) { border-right: none; border-top: 1px solid rgba(197,160,89,0.12); }
    .hrp-ab-stat-card:nth-child(4) { border-top: 1px solid rgba(197,160,89,0.12); }
}
@media (max-width: 767px) {
    .hrp-about-main-img { height: 300px; }
    .hrp-about-img-frame { padding-bottom: 20px; padding-right: 20px; }
    .hrp-ab-year-badge { bottom: 32px; right: 32px; }
    .hrp-about-stats-grid { grid-template-columns: 1fr 1fr; }
    .hrp-about-cta-row { flex-direction: column; align-items: stretch; text-align: center; }
    section { padding: 64px 0; }
}
</style>
@endsection

@section('extra_js')
<script>
// Scroll-reveal animation
(function(){
    if(!('IntersectionObserver' in window)) return;
    const els = document.querySelectorAll('.hrp-value-card,.hrp-ab-stat-card,.hrp-mission-card,.hrp-about-pillar');
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
