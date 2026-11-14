@extends('layouts.app')

@section('title', 'World-Class Amenities — Hotel Rose Palace | Premium Facilities Surat')
@section('meta_description', 'Discover Hotel Rose Palace amenities: high-speed Wi-Fi, 24/7 front desk, free valet parking, and luxury facilities on VIP Road, Vesu, Surat.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="text-center" style="background: linear-gradient(180deg, rgba(110,44,58,0.45) 0%, rgba(46,31,34,0.85) 100%), url('{{ asset('images/hotel/hero-hd-3.jpg') }}') center/cover no-repeat; padding: 100px 20px 80px; position: relative;">
    <div class="container position-relative" style="z-index: 2;">
        <span style="color: var(--hrp-gold-light); font-family: var(--font-ui); font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 12px;">
            ✦ Bespoke Hospitality Comforts ✦
        </span>
        <h1 style="color: var(--hrp-surface); font-size: 46px; margin-bottom: 16px;">World-Class Amenities</h1>
        <p style="color: var(--hrp-tint); font-size: 18px; max-width: 680px; margin: 0 auto 24px; line-height: 1.6;">
            Every detail thoughtfully curated for corporate efficiency, peaceful relaxation, and genuine Indian hospitality in Surat.
        </p>
        <div class="d-inline-flex align-items-center gap-2" style="background: rgba(247,241,232,0.15); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(247,241,232,0.3); font-size: 13px; color: var(--hrp-surface);">
            <a href="{{ route('home') }}" style="color: var(--hrp-surface);">Home</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; color: var(--hrp-gold);"></i>
            <span>Amenities</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     HIGHLIGHTS RIBBON
═══════════════════════════════════════════════════════ --}}
<div style="background: var(--hrp-tint); border-bottom: 1px solid var(--hrp-border); padding: 20px 0;">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center flex-wrap gap-4 text-center">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-wifi text-gold fs-5"></i>
                <span style="font-size: 13.5px; font-weight: 700; color: var(--hrp-plum);">500 Mbps Wi-Fi</span>
            </div>
            <span class="d-none d-md-inline" style="color: var(--hrp-border);">|</span>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-parking text-gold fs-5"></i>
                <span style="font-size: 13.5px; font-weight: 700; color: var(--hrp-plum);">Free Valet Parking</span>
            </div>
            <span class="d-none d-md-inline" style="color: var(--hrp-border);">|</span>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-concierge-bell text-gold fs-5"></i>
                <span style="font-size: 13.5px; font-weight: 700; color: var(--hrp-plum);">24/7 Front Desk</span>
            </div>
            <span class="d-none d-md-inline" style="color: var(--hrp-border);">|</span>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-mug-hot text-gold fs-5"></i>
                <span style="font-size: 13.5px; font-weight: 700; color: var(--hrp-plum);">24/7 Room Assistance</span>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     MAIN AMENITIES CATALOG GRID
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 70px 0;">
    <div class="container">
        
        <div class="text-center mb-5">
            <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 8px;">✦ Complete Care ✦</span>
            <h2 style="font-size: 38px; color: var(--hrp-plum);">Facilities Designed for Excellence</h2>
            <p style="max-width: 650px; margin: 0 auto; color: var(--hrp-mauve);">Experience thoughtful modern amenities crafted to ensure every hour of your stay is restful and productive.</p>
        </div>

        @php
        $amenityCards = [
            [
                'icon' => 'fas fa-wifi',
                'cat' => 'Business',
                'title' => 'Ultra-Fast Dedicated Wi-Fi',
                'desc' => 'Seamless 500 Mbps coverage across all rooms, executive suites, and guest lounges. Perfect for video conferencing and streaming.',
                'timing' => '24/7 Unlimited'
            ],
            [
                'icon' => 'fas fa-parking',
                'cat' => 'Convenience',
                'title' => 'Secure Multi-Level Valet Parking',
                'desc' => 'Complimentary parking at Atlanta Business Hub with 24/7 security personnel and CCTV camera surveillance.',
                'timing' => 'Complimentary for All Guests'
            ],
            [
                'icon' => 'fas fa-concierge-bell',
                'cat' => 'Service',
                'title' => '24/7 Front Desk & Concierge',
                'desc' => 'Round-the-clock reception to assist with late check-ins, local Surat transit, luggage storage, and special requests.',
                'timing' => '24 Hours / 365 Days'
            ],
            [
                'icon' => 'fas fa-mug-hot',
                'cat' => 'Hospitality',
                'title' => 'In-Room Tea & Coffee Refreshments',
                'desc' => 'Electric kettle with assorted tea and coffee amenities in every room, plus warm assistance around the clock.',
                'timing' => '24/7 Available in All Rooms'
            ],

            [
                'icon' => 'fas fa-shield-virus',
                'cat' => 'Safety',
                'title' => 'Daily Housekeeping & Sanitization',
                'desc' => 'Meticulous linen sanitization, room turnaround, touchpoint disinfection, and premium eco-friendly toiletries.',
                'timing' => 'Daily 9:00 AM – 5:00 PM'
            ],
            [
                'icon' => 'fas fa-concierge-bell',
                'cat' => 'Hospitality',
                'title' => 'Daily Room Turndown Service',
                'desc' => 'Evening pillow service, personalized greeting card placement, and premium evening refreshment delivery.',
                'timing' => 'Daily Morning & Evening Turn-down'
            ],
            [
                'icon' => 'fas fa-tv',
                'cat' => 'Entertainment',
                'title' => '55" 4K Smart Entertainment',
                'desc' => 'Wall-mounted smart screens with YouTube, OTT streaming casting, and high-definition multi-language satellite channels.',
                'timing' => 'In Every Room & Suite'
            ],
            [
                'icon' => 'fas fa-snowflake',
                'cat' => 'Comfort',
                'title' => 'Whisper-Quiet Climate Control',
                'desc' => 'Independent inverter air conditioning units with individual digital temperature controls for custom comfort.',
                'timing' => 'Individual Room Control'
            ],
            [
                'icon' => 'fas fa-glass-cheers',
                'cat' => 'Events',
                'title' => 'Multi-Purpose Banquet Hall',
                'desc' => 'Modern acoustics, state-of-the-art projection, and capacity for up to 350 guests for weddings and corporate seminars.',
                'timing' => 'Prior Reservation Required'
            ],
        ];
        @endphp

        <div class="row g-4">
            @foreach($amenityCards as $item)
            <div class="col-lg-4 col-md-6">
                <div class="card p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: var(--hrp-tint); display: flex; align-items: center; justify-content: center; font-size: 22px; color: var(--hrp-burgundy); border: 1px solid var(--hrp-border);">
                            <i class="{{ $item['icon'] }}"></i>
                        </div>
                        <span class="badge" style="background: rgba(184,138,68,0.15); color: #B88A44; border: 1px solid rgba(184,138,68,0.3); font-size: 11px; text-transform: uppercase;">
                            {{ $item['cat'] }}
                        </span>
                    </div>

                    <h4 style="font-size: 19px; color: var(--hrp-plum); margin-bottom: 8px;">{{ $item['title'] }}</h4>
                    <p style="font-size: 14px; color: var(--hrp-mauve); line-height: 1.7; margin-bottom: 16px; flex-grow: 1;">
                        {{ $item['desc'] }}
                    </p>

                    <div class="pt-3 d-flex align-items-center justify-content-between" style="border-top: 1px solid var(--hrp-border); font-size: 12px; color: var(--hrp-mauve);">
                        <span><i class="fas fa-clock text-gold me-1"></i> {{ $item['timing'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     CONCIERGE ASSISTANCE CTA
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider text-center" style="background-color: var(--hrp-surface); padding: 70px 0;">
    <div class="container">
        <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase;">✦ Dedicated Concierge ✦</span>
        <h2 style="font-size: 38px; color: var(--hrp-plum); margin: 8px 0 16px;">Have Special Requirements?</h2>
        <p style="color: var(--hrp-mauve); max-width: 600px; margin: 0 auto 28px;">
            From floral room surprises to customized Jain feasts, our guest relations team is ready to assist with your special requests.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('booking.search.form') }}" class="btn btn-primary btn-lg" style="text-decoration: none;">
                <i class="fas fa-calendar-check"></i> Book Your Stay
            </a>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello! I have a special request for my stay at Hotel Rose Palace.') }}" target="_blank" class="btn btn-whatsapp btn-lg">
                <i class="fab fa-whatsapp"></i> Chat with Concierge
            </a>
        </div>
    </div>
</section>

@endsection
