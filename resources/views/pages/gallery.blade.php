@extends('layouts.app')

@section('title', 'Gallery — Hotel Rose Palace | Visual Journey Through Authentic Comfort')
@section('meta_description', 'Explore the visual photo gallery of Hotel Rose Palace Surat. Real photographs of our Deluxe Family Rooms, Executive Rooms, Reception, and modern amenities.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="text-center" style="background: linear-gradient(180deg, rgba(110,44,58,0.55) 0%, rgba(46,31,34,0.88) 100%), url('{{ asset('images/gallery/exterior-building-view.jpg') }}') center/cover no-repeat; padding: 100px 20px 80px; position: relative;">
    <div class="container position-relative" style="z-index: 2;">
        <span style="color: var(--hrp-gold-light); font-family: var(--font-ui); font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 12px;">
            ✦ Visual Chronicle ✦
        </span>
        <h1 style="color: var(--hrp-surface); font-size: 46px; margin-bottom: 16px;">The Rose Palace Gallery</h1>
        <p style="color: var(--hrp-tint); font-size: 18px; max-width: 680px; margin: 0 auto 24px; line-height: 1.6;">
            A genuine visual showcase of Hotel Rose Palace on VIP Road, Vesu, Surat — exploring our exterior facade, welcoming reception lounge, and comfortable guest rooms.
        </p>
        <div class="d-inline-flex align-items-center gap-2" style="background: rgba(247,241,232,0.15); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(247,241,232,0.3); font-size: 13px; color: var(--hrp-surface);">
            <a href="{{ route('home') }}" style="color: var(--hrp-surface); text-decoration: none;">Home</a>
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
            <button class="hrp-menu-tab-btn active" data-filter="all" onclick="filterGallery('all', this)">All Photos (15)</button>
            <button class="hrp-menu-tab-btn" data-filter="Exterior & Building" onclick="filterGallery('Exterior & Building', this)">Exterior & Building</button>
            <button class="hrp-menu-tab-btn" data-filter="Reception & Lobby" onclick="filterGallery('Reception & Lobby', this)">Reception & Lobby</button>
            <button class="hrp-menu-tab-btn" data-filter="Deluxe Family Rooms" onclick="filterGallery('Deluxe Family Rooms', this)">Deluxe Family Rooms</button>
            <button class="hrp-menu-tab-btn" data-filter="Executive Rooms" onclick="filterGallery('Executive Rooms', this)">Executive Rooms</button>
            <button class="hrp-menu-tab-btn" data-filter="Bathrooms & Amenities" onclick="filterGallery('Bathrooms & Amenities', this)">Bathrooms & Amenities</button>
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
            // Exterior & Building (3 photos)
            [
                'src' => asset('images/gallery/exterior-building-view.jpg'),
                'cat' => 'Exterior & Building',
                'title' => 'Hotel Rose Palace Exterior Building View',
                'desc' => 'Hotel Rose Palace exterior facade and signage at Atlanta Business Hub, VIP Road, Vesu, Surat'
            ],
            [
                'src' => asset('images/gallery/outer-rooms-corridor.jpg'),
                'cat' => 'Exterior & Building',
                'title' => 'Outer Area of All Rooms – Guest Floor Corridor',
                'desc' => 'Outer area and hallway corridor connecting all guest rooms on Floor 1 with polished marble flooring'
            ],
            [
                'src' => asset('images/gallery/entrance-glass-door.jpg'),
                'cat' => 'Exterior & Building',
                'title' => 'Main Entrance Glass Door',
                'desc' => 'Hotel Rose Palace frosted glass entrance door with floral arrangement'
            ],

            // Reception & Lobby (3 photos)
            [
                'src' => asset('images/gallery/front-desk-reception.jpg'),
                'cat' => 'Reception & Lobby',
                'title' => 'Front Desk & Reception Area',
                'desc' => 'Hotel Rose Palace front desk counter with warm illumination and reception lounge'
            ],
            [
                'src' => asset('images/gallery/guest-waiting-lounge.jpg'),
                'cat' => 'Reception & Lobby',
                'title' => 'Guest Waiting Lounge',
                'desc' => 'Comfortable guest waiting lounge with plush seating and marble coffee table'
            ],
            [
                'src' => asset('images/gallery/reception-lobby-lounge.jpg'),
                'cat' => 'Reception & Lobby',
                'title' => 'Grand Reception & Front Desk Lounge',
                'desc' => 'Grand reception desk, plush sofa lounge, and warm illumination at Hotel Rose Palace'
            ],

            // Deluxe Family Rooms (3 photos)
            [
                'src' => asset('images/gallery/deluxe-family-king-bed.jpg'),
                'cat' => 'Deluxe Family Rooms',
                'title' => 'Deluxe Family Room – King Bed',
                'desc' => 'Deluxe Family Room featuring plush king bed, sitting table, and ample wardrobe space'
            ],
            [
                'src' => asset('images/gallery/deluxe-family-room-102.jpg'),
                'cat' => 'Deluxe Family Rooms',
                'title' => 'Deluxe Family Room – Room 102 Layout',
                'desc' => 'Deluxe Family Room 102 layout with king bedding and warm wooden furnishings'
            ],
            [
                'src' => asset('images/gallery/deluxe-family-wardrobe.jpg'),
                'cat' => 'Deluxe Family Rooms',
                'title' => 'Deluxe Family Room – Wardrobe & Dressing Area',
                'desc' => 'Deluxe Family Room dressing mirror and spacious wardrobe unit'
            ],

            // Executive Rooms (5 photos)
            [
                'src' => asset('images/gallery/executive-room-city-view.jpg'),
                'cat' => 'Executive Rooms',
                'title' => 'Executive Room – City View Window',
                'desc' => 'Executive Room featuring city view window, air conditioning, and wall-mounted TV'
            ],
            [
                'src' => asset('images/gallery/executive-room-warm-lighting.jpg'),
                'cat' => 'Executive Rooms',
                'title' => 'Executive Room – Warm Ambient Lighting',
                'desc' => 'Executive Room with recessed cove lighting and contemporary headboard'
            ],
            [
                'src' => asset('images/gallery/executive-room-gold-molding.jpg'),
                'cat' => 'Executive Rooms',
                'title' => 'Executive Room – Gold Trim Feature Wall',
                'desc' => 'Executive Room featuring elegant gold trim molding wall and king bed'
            ],
            [
                'src' => asset('images/gallery/executive-room-king-bed.jpg'),
                'cat' => 'Executive Rooms',
                'title' => 'Executive Room – King Bed & Console',
                'desc' => 'Executive Room with comfortable king bed, TV console, and reading lighting'
            ],
            [
                'src' => asset('images/gallery/executive-room-interior.jpg'),
                'cat' => 'Executive Rooms',
                'title' => 'Executive Room – Interior View',
                'desc' => 'Executive Room interior view with work table, comfortable chair, and soft lighting'
            ],

            // Bathrooms & Amenities (1 photo)
            [
                'src' => asset('images/gallery/attached-modern-washroom.jpg'),
                'cat' => 'Bathrooms & Amenities',
                'title' => 'Attached Modern Washroom',
                'desc' => 'Clean attached washroom with modern ceramic basin, hot/cold shower, and fresh towels'
            ],
        ];
        @endphp

        @php
        $displayImages = [];
        if (isset($galleryImages) && $galleryImages->count() > 0) {
            foreach ($galleryImages as $img) {
                $src = str_starts_with($img->image_url ?? '', 'http') ? $img->image_url : asset(ltrim($img->image_url ?? 'images/' . $img->image_path, '/'));
                $displayImages[] = [
                    'src' => $src,
                    'cat' => $img->category ?? 'Executive Rooms',
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
                <div class="card p-0 overflow-hidden h-100 shadow-sm" style="cursor: pointer; border-radius: 12px; border: 1px solid var(--hrp-border); background: var(--hrp-surface); transition: transform 0.3s ease, box-shadow 0.3s ease;" onclick="openLightbox('{{ $item['src'] }}', '.gallery-photo-img')">
                    <div style="position: relative; height: 260px; overflow: hidden;">
                        <img src="{{ $item['src'] }}" alt="{{ $item['title'] }}" class="gallery-photo-img" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" loading="lazy" data-full="{{ $item['src'] }}">
                        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, transparent 40%, rgba(46,31,34,0.88) 100%); display: flex; align-items: flex-end; padding: 20px;">
                            <div>
                                <span class="badge" style="background: var(--hrp-gold); color: #2E1F22; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">{{ $item['cat'] }}</span>
                                <h4 style="color: var(--hrp-surface); font-size: 17px; font-weight: 600; margin: 0; line-height: 1.3;">{{ $item['title'] }}</h4>
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
            Book direct via our website to receive our guaranteed best rate, complimentary early check-in, and personalized concierge care.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('booking.search.form') }}" class="btn btn-primary btn-lg" style="text-decoration: none;">
                <i class="fas fa-calendar-check"></i> Book Your Stay
            </a>
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
