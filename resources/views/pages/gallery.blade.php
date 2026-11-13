@extends('layouts.app')

@section('title', 'Gallery — Hotel Rose Palace | Visual Journey Through Luxury Surat')
@section('meta_description', 'Explore the visual gallery of Hotel Rose Palace Surat. Luxurious suites, fine dining spaces, modern banquet halls, and elegant architecture on VIP Road, Vesu.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="text-center" style="background: linear-gradient(180deg, rgba(110,44,58,0.45) 0%, rgba(46,31,34,0.85) 100%), url('{{ asset('images/hotel/hero-1.jpg') }}') center/cover no-repeat; padding: 100px 20px 80px; position: relative;">
    <div class="container position-relative" style="z-index: 2;">
        <span style="color: var(--hrp-gold-light); font-family: var(--font-ui); font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 12px;">
            ✦ Visual Chronicle ✦
        </span>
        <h1 style="color: var(--hrp-surface); font-size: 46px; margin-bottom: 16px;">The Rose Palace Gallery</h1>
        <p style="color: var(--hrp-tint); font-size: 18px; max-width: 680px; margin: 0 auto 24px; line-height: 1.6;">
            A glimpse into the architectural splendor, royal suites, pristine dining, and celebration venues that define our property in Surat.
        </p>
        <div class="d-inline-flex align-items-center gap-2" style="background: rgba(247,241,232,0.15); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(247,241,232,0.3); font-size: 13px; color: var(--hrp-surface);">
            <a href="{{ route('home') }}" style="color: var(--hrp-surface);">Home</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; color: var(--hrp-gold);"></i>
            <span>Photo Gallery</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     FILTER TABS TOOLBAR
═══════════════════════════════════════════════════════ --}}
<div style="background: var(--hrp-tint); border-bottom: 1px solid var(--hrp-border); padding: 16px 0; position: sticky; top: 72px; z-index: 100;">
    <div class="container text-center">
        <div class="d-flex justify-content-center flex-wrap gap-2" id="galleryFilters">
            <button class="hrp-menu-tab-btn active" data-filter="all" onclick="filterGallery('all', this)">All Photography</button>
            <button class="hrp-menu-tab-btn" data-filter="rooms" onclick="filterGallery('rooms', this)">Rooms & Suites</button>
            <button class="hrp-menu-tab-btn" data-filter="dining" onclick="filterGallery('dining', this)">Dining & Gastronomy</button>
            <button class="hrp-menu-tab-btn" data-filter="lobby" onclick="filterGallery('lobby', this)">Lobby & Reception</button>
            <button class="hrp-menu-tab-btn" data-filter="spa" onclick="filterGallery('spa', this)">Spa & Wellness</button>
            <button class="hrp-menu-tab-btn" data-filter="exterior" onclick="filterGallery('exterior', this)">Exterior & Views</button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     GALLERY GRID
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 60px 0;">
    <div class="container">
        
        @php
        $galleryCatalog = [
            ['src' => asset('images/hotel/hero-1.jpg'), 'cat' => 'rooms', 'title' => 'Maharaja Grand Suite', 'desc' => 'High-resolution suite view with ambient blue lighting'],
            ['src' => asset('images/hotel/hero-2.jpg'), 'cat' => 'rooms', 'title' => 'Royal Heritage Suite', 'desc' => 'Master bedroom with plush king bedding'],
            ['src' => asset('images/hotel/lobby.jpg'), 'cat' => 'lobby', 'title' => 'Grand Reception & Lounge', 'desc' => 'Welcoming front desk and guest waiting area'],
            ['src' => asset('images/hotel/room-deluxe.jpg'), 'cat' => 'rooms', 'title' => 'Deluxe King Room', 'desc' => 'Spacious room with modern lighting and workstation'],
            ['src' => asset('images/hotel/room-executive.jpg'), 'cat' => 'rooms', 'title' => 'Superior Twin Sanctuary', 'desc' => 'Dual luxury beds for corporate travelers'],
            ['src' => asset('images/hotel/room-suite.jpg'), 'cat' => 'rooms', 'title' => 'Executive Living Salon', 'desc' => 'Dedicated sitting area with premium amenities'],
            ['src' => asset('images/hotel/gallery-1.jpg'), 'cat' => 'rooms', 'title' => 'Executive Work-Desk Suite', 'desc' => 'Ergonomic workspace and fast Wi-Fi'],
            ['src' => asset('images/hotel/gallery-2.jpg'), 'cat' => 'lobby', 'title' => 'Main Reception Salon', 'desc' => 'Grand arrival lobby and check-in desk'],
            ['src' => asset('images/hotel/gallery-3.jpg'), 'cat' => 'rooms', 'title' => 'Deluxe Suite Interior', 'desc' => 'Modern fixtures and ambient ceiling lighting'],
            ['src' => asset('images/hotel/gallery-4.jpg'), 'cat' => 'rooms', 'title' => 'Attached Luxury Bathroom', 'desc' => 'Modern vanity and 24/7 hot water supply'],
            ['src' => asset('images/hotel/gallery-5.jpg'), 'cat' => 'rooms', 'title' => 'Corporate Suite Room', 'desc' => 'Tailored for corporate productivity in Surat'],
            ['src' => asset('images/hotel/gallery-6.jpg'), 'cat' => 'rooms', 'title' => 'Family Suite Bedroom', 'desc' => 'Comfortable setup for families and groups'],
            ['src' => asset('images/hotel/exterior.jpg'), 'cat' => 'exterior', 'title' => 'Main Entrance & Facade', 'desc' => 'Atlanta Business Hub, VIP Road, Vesu'],
        ];
        @endphp

        @php
        $displayImages = [];
        if (isset($galleryImages) && $galleryImages->count() > 0) {
            foreach ($galleryImages as $img) {
                $src = str_starts_with($img->image_url ?? '', 'http') ? $img->image_url : asset(ltrim($img->image_url ?? 'images/' . $img->image_path, '/'));
                $displayImages[] = [
                    'src' => $src,
                    'cat' => $img->category ?? 'rooms',
                    'title' => $img->title ?? 'Hotel Rose Palace',
                    'desc' => $img->alt_text ?? 'Hotel Rose Palace Vesu Surat',
                ];
            }
        } else {
            $displayImages = $galleryCatalog;
        }
        @endphp

        <div class="row g-4" id="galleryContainer">
            @foreach($displayImages as $idx => $item)
            <div class="col-lg-4 col-md-6 gallery-card" data-category="{{ $item['cat'] }}">
                <div class="card p-0 overflow-hidden h-100" style="cursor: pointer;" onclick="openLightbox('{{ $item['src'] }}', '.gallery-photo-img')">
                    <div style="position: relative; height: 260px; overflow: hidden;">
                        <img src="{{ $item['src'] }}" alt="{{ $item['title'] }}" class="gallery-photo-img" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" loading="lazy" data-full="{{ $item['src'] }}">
                        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 40%, rgba(46,31,34,0.85) 100%); display: flex; align-items: flex-end; padding: 20px;">
                            <div>
                                <span class="badge" style="background: var(--hrp-gold); color: #2E1F22; font-size: 10px; text-transform: uppercase; margin-bottom: 4px;">{{ ucfirst($item['cat']) }}</span>
                                <h4 style="color: var(--hrp-surface); font-size: 17px; margin: 0;">{{ $item['title'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     EXPERIENCE IN PERSON CTA
═══════════════════════════════════════════════════════ --}}
<section class="hrp-section-divider text-center" style="background-color: var(--hrp-surface); padding: 70px 0;">
    <div class="container">
        <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 13px; letter-spacing: 2px; text-transform: uppercase;">✦ Experience It In Person ✦</span>
        <h2 style="font-size: 38px; color: var(--hrp-plum); margin: 8px 0 16px;">Step Inside Hotel Rose Palace</h2>
        <p style="color: var(--hrp-mauve); max-width: 600px; margin: 0 auto 28px;">
            Book direct via our website to receive our guaranteed best rate, complimentary early check-in, and 10% off dining.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button type="button" onclick="window.openBookingModal()" class="btn btn-primary btn-lg">
                <i class="fas fa-calendar-check"></i> Book Your Stay
            </button>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello! I viewed your gallery and would like to inquire about booking.') }}" target="_blank" class="btn btn-whatsapp btn-lg">
                <i class="fab fa-whatsapp"></i> Chat on WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection

@section('extra_js')
<script>
function filterGallery(category, btn) {
    document.querySelectorAll('#galleryFilters button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const cards = document.querySelectorAll('.gallery-card');
    cards.forEach(card => {
        if (category === 'all' || card.getAttribute('data-category') === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection
