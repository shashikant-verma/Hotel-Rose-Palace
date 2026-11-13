@extends('layouts.app')

@section('title', 'About Hotel Rose Palace — Our Story, Heritage & Values | Surat')
@section('meta_description', 'Discover the story behind Hotel Rose Palace, Surat. Learn about our commitment to luxury hospitality, our values, and our vision to redefine premium stays on VIP Road, Vesu.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="text-center" style="background: linear-gradient(180deg, rgba(110,44,58,0.45) 0%, rgba(46,31,34,0.85) 100%), url('{{ asset('images/hotel/hero-hd-1.jpg') }}') center/cover no-repeat; padding: 100px 20px 80px; position: relative;">
    <div class="container position-relative" style="z-index: 2;">
        <span style="color: var(--hrp-gold-light); font-family: var(--font-ui); font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 12px;">
            ✦ The Rose Palace Legacy ✦
        </span>
        <h1 style="color: var(--hrp-surface); font-size: 46px; margin-bottom: 16px;">Our Story & Heritage</h1>
        <p style="color: var(--hrp-tint); font-size: 18px; max-width: 680px; margin: 0 auto 24px; line-height: 1.6;">
            A sanctuary of gracious Indian hospitality nestled in the heart of Vesu, Surat — where every guest is honored as royalty.
        </p>
        <div class="d-inline-flex align-items-center gap-2" style="background: rgba(247,241,232,0.15); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(247,241,232,0.3); font-size: 13px; color: var(--hrp-surface);">
            <a href="{{ route('home') }}" style="color: var(--hrp-surface);">Home</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; color: var(--hrp-gold);"></i>
            <span>About Us</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     OUR BEGINNINGS & ARCHITECTURE
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 80px 0 60px;">
    <div class="container">
        <div class="row align-items-center g-5">
            
            {{-- Arch Image --}}
            <div class="col-lg-5 col-md-12">
                <div class="hrp-arch-frame" style="height: 480px;">
                    <img src="{{ asset('images/hotel/lobby.jpg') }}" onerror="this.onerror=null;this.src='{{ asset('images/hotel/hotel-rose-palace-entrance-door.jpg') }}';" alt="Hotel Rose Palace Entrance & Reception" loading="lazy">
                    <div class="hrp-crest-badge">
                        <span class="year">Est.</span>
                        <span class="label">Surat, Gujarat</span>
                    </div>
                </div>
            </div>

            {{-- Narrative Story --}}
            <div class="col-lg-7 col-md-12">
                <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">
                    ✦ Rooted in Purity & Elegance ✦
                </span>
                <h2 style="font-size: 38px; color: var(--hrp-plum); margin-bottom: 20px;">
                    Redefining Premium Hospitality in <span class="serif-italic" style="color: var(--hrp-burgundy);">Vesu, Surat</span>
                </h2>
                <p style="font-size: 15.5px; line-height: 1.85; color: var(--hrp-mauve); margin-bottom: 16px;">
                    Hotel Rose Palace was established with a singular devotion: to combine the quiet dignity of royal architecture with the vibrant warmth of Gujarat's finest hospitality. Located on VIP Road in Vesu, our hotel serves as an oasis amidst Surat's dynamic economic boom.
                </p>
                <p style="font-size: 15.5px; line-height: 1.85; color: var(--hrp-mauve); margin-bottom: 24px;">
                    Our commitment is reflected in every detail — from our 100% Pure Vegetarian and Jain culinary standards to our acoustically insulated suites and 24-hour concierge assistance. Whether you arrive for diamond trade conventions, family weddings, or leisure retreats, we guarantee an unforgettable sojourn.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="card p-3 h-100">
                            <i class="fas fa-hand-holding-heart text-gold fs-4 mb-2"></i>
                            <h5 style="color: var(--hrp-plum); font-size: 16px; margin-bottom: 4px;">Atithi Devo Bhava</h5>
                            <p style="font-size: 13px; color: var(--hrp-mauve); margin: 0;">We treat every traveler not as a customer, but as an honored guest in our home.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card p-3 h-100">
                            <i class="fas fa-seedling text-gold fs-4 mb-2"></i>
                            <h5 style="color: var(--hrp-plum); font-size: 16px; margin-bottom: 4px;">Culinary Sanctity</h5>
                            <p style="font-size: 13px; color: var(--hrp-mauve); margin: 0;">Strictly vegetarian kitchen with fresh farm ingredients and Jain care.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     HERITAGE MILESTONES TIMELINE
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider" style="background-color: var(--hrp-surface); padding: 70px 0;">
    <div class="container">
        
        <div class="text-center mb-5">
            <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">✦ Our Journey ✦</span>
            <h2 style="font-size: 38px; color: var(--hrp-plum);">Milestones of Distinction</h2>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-md-4 col-sm-6">
                <div class="card p-4 h-100 text-center">
                    <div class="d-inline-block px-3 py-1 rounded mb-3" style="background: var(--hrp-tint); color: var(--hrp-burgundy); font-weight: 700; font-size: 14px;">
                        Phase I • Vision & Foundation
                    </div>
                    <h4 style="color: var(--hrp-plum); font-size: 20px; margin-bottom: 12px;">Strategic Flagship at Atlanta Hub</h4>
                    <p style="color: var(--hrp-mauve); font-size: 14px; line-height: 1.7; margin: 0;">
                        Selected the premier commercial corridor on VIP Road, Vesu to offer business travelers immediate access to the airport and textile markets.
                    </p>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card p-4 h-100 text-center">
                    <div class="d-inline-block px-3 py-1 rounded mb-3" style="background: var(--hrp-tint); color: var(--hrp-burgundy); font-weight: 700; font-size: 14px;">
                        Phase II • Expansion & Suites
                    </div>
                    <h4 style="color: var(--hrp-plum); font-size: 20px; margin-bottom: 12px;">Royal Suites & Banquet Halls</h4>
                    <p style="color: var(--hrp-mauve); font-size: 14px; line-height: 1.7; margin: 0;">
                        Expanded our inventory to 35+ executive rooms and inaugurated our celebratory multi-purpose banquet venue for Surat gatherings.
                    </p>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card p-4 h-100 text-center">
                    <div class="d-inline-block px-3 py-1 rounded mb-3" style="background: var(--hrp-tint); color: var(--hrp-burgundy); font-weight: 700; font-size: 14px;">
                        Phase III • Digital & Modernization
                    </div>
                    <h4 style="color: var(--hrp-plum); font-size: 20px; margin-bottom: 12px;">Direct Booking & Concierge Portal</h4>
                    <p style="color: var(--hrp-mauve); font-size: 14px; line-height: 1.7; margin: 0;">
                        Seamless online reservations, dynamic price estimation, and direct WhatsApp concierge assistance for travelers across India and abroad.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     GENERAL MANAGER'S WELCOME NOTE
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider" style="background-color: var(--hrp-canvas); padding: 70px 0;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-9 col-md-11">
                <div class="card p-5" style="border: 1.5px solid var(--hrp-gold); box-shadow: var(--shadow-lg);">
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <i class="fas fa-quote-left text-gold fs-1"></i>
                        <div>
                            <span style="font-size: 12px; font-weight: 700; color: var(--hrp-gold); text-transform: uppercase; letter-spacing: 1px;">From the General Manager's Desk</span>
                            <h3 style="color: var(--hrp-plum); margin: 0; font-size: 24px;">"Your Sanctuary in the Silk & Diamond City"</h3>
                        </div>
                    </div>

                    <p style="font-size: 16px; line-height: 1.85; color: var(--hrp-mauve); font-style: italic; margin-bottom: 24px;">
                        "Welcome to Hotel Rose Palace. Our mission has always been simple: to provide a sanctuary where warmth is genuine, luxury is unobtrusive, and comfort feels like home. Whether you are concluding diamond agreements or celebrating family milestones, our team stands ready around the clock to exceed your expectations."
                    </p>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pt-3" style="border-top: 1px solid var(--hrp-border);">
                        <div>
                            <strong style="color: var(--hrp-plum); font-size: 17px; display: block;">Management & Hospitality Team</strong>
                            <span style="font-size: 13px; color: var(--hrp-mauve);">Hotel Rose Palace • VIP Road, Vesu, Surat</span>
                        </div>
                        <button type="button" onclick="window.openBookingModal()" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Your Stay Today
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
