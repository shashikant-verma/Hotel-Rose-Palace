@extends('layouts.app')

@section('title', 'Gallery — Hotel Rose Palace | Visual Journey Through Luxury')
@section('meta_description', 'Explore the stunning gallery of Hotel Rose Palace, Surat. View our luxurious rooms, fine dining, spa, lobby, and more through our visual journey.')
@section('meta_keywords', 'hotel rose palace gallery, surat hotel photos, luxury hotel images, hotel rooms gallery')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="hrp-page-hero" id="gallery-hero">
    <div class="hrp-page-hero-overlay"></div>
    <div class="container hrp-page-hero-container">
        <div class="hrp-page-hero-eyebrow">
            <span class="hrp-eyebrow-line"></span>
            <span>✦ Visual Journey ✦</span>
            <span class="hrp-eyebrow-line"></span>
        </div>
        <h1 class="hrp-page-hero-title">Our Gallery</h1>
        <p class="hrp-page-hero-sub">A curated visual journey through the exquisite spaces, culinary artistry, and premium experiences that define Hotel Rose Palace.</p>
        <nav class="hrp-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="hrp-bc-sep"><i class="fas fa-chevron-right"></i></span>
            <span>Gallery</span>
        </nav>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     GALLERY FILTER TABS
═══════════════════════════════════════════════════════ --}}
<section class="hrp-gallery-section" id="gallery-main">
    <div class="container">

        {{-- Filter Tabs --}}
        <div class="hrp-gallery-filters" id="gallery-filters">
            <button class="hrp-filter-btn active" data-filter="all" id="filter-all">
                <i class="fas fa-th"></i> All
            </button>
            <button class="hrp-filter-btn" data-filter="rooms" id="filter-rooms">
                <i class="fas fa-bed"></i> Rooms & Suites
            </button>
            <button class="hrp-filter-btn" data-filter="dining" id="filter-dining">
                <i class="fas fa-utensils"></i> Dining
            </button>
            <button class="hrp-filter-btn" data-filter="lobby" id="filter-lobby">
                <i class="fas fa-hotel"></i> Lobby & Common
            </button>
            <button class="hrp-filter-btn" data-filter="spa" id="filter-spa">
                <i class="fas fa-spa"></i> Spa & Wellness
            </button>
            <button class="hrp-filter-btn" data-filter="exterior" id="filter-exterior">
                <i class="fas fa-building"></i> Exterior & Views
            </button>
        </div>

        @php
        $fallbackGallery = [
            ['url' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80', 'title' => 'Deluxe Suite', 'cat' => 'rooms', 'size' => 'large'],
            ['url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80', 'title' => 'Fine Dining Restaurant', 'cat' => 'dining', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80', 'title' => 'Grand Lobby', 'cat' => 'lobby', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80', 'title' => 'Royal Palace Suite', 'cat' => 'rooms', 'size' => 'large'],
            ['url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80', 'title' => 'Spa & Wellness Centre', 'cat' => 'spa', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1512918728672-f9d96f4fff8c?w=800&q=80', 'title' => 'City View Room', 'cat' => 'rooms', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'title' => 'Hotel Exterior', 'cat' => 'exterior', 'size' => 'large'],
            ['url' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'title' => 'Breakfast Buffet', 'cat' => 'dining', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1521783593447-5702b9bfd267?w=800&q=80', 'title' => 'Executive Lounge', 'cat' => 'lobby', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=800&q=80', 'title' => 'Spa Treatment Room', 'cat' => 'spa', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80', 'title' => 'Pool View', 'cat' => 'exterior', 'size' => 'medium'],
            ['url' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=800&q=80', 'title' => 'Banquet Hall', 'cat' => 'lobby', 'size' => 'large'],
        ];
        $galleryItems = isset($galleryImages) && $galleryImages->count() > 0
            ? $galleryImages->map(fn($g) => [
                'url' => \Storage::url($g->image_path),
                'title' => $g->title ?? 'Gallery',
                'cat' => strtolower($g->category ?? 'lobby'),
                'size' => 'medium'
              ])->toArray()
            : $fallbackGallery;
        @endphp

        {{-- Gallery Masonry Grid --}}
        <div class="hrp-gallery-grid" id="gallery-grid">
            @foreach($galleryItems as $i => $img)
            <div class="hrp-gallery-item hrp-gi-{{ $img['size'] }}" data-category="{{ $img['cat'] }}" data-index="{{ $i }}"
                 onclick="openGalleryLightbox({{ $i }})"
                 id="gallery-img-{{ $i }}">
                <img src="{{ $img['url'] }}" alt="{{ $img['title'] }}" class="hrp-gi-img" loading="lazy">
                <div class="hrp-gi-overlay">
                    <div class="hrp-gi-info">
                        <span class="hrp-gi-cat">{{ ucfirst($img['cat']) }}</span>
                        <h4 class="hrp-gi-title">{{ $img['title'] }}</h4>
                    </div>
                    <div class="hrp-gi-expand"><i class="fas fa-expand-alt"></i></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- No Results State --}}
        <div class="hrp-no-results" id="no-results" style="display:none;">
            <i class="fas fa-images"></i>
            <p>No images found in this category.</p>
        </div>

        @if(isset($galleryImages) && $galleryImages->hasPages())
        <div class="text-center mt-5">
            {{ $galleryImages->links() }}
        </div>
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     LIGHTBOX
═══════════════════════════════════════════════════════ --}}
<div class="hrp-lightbox" id="gallery-lightbox">
    <div class="hrp-lb-backdrop" onclick="closeLightbox()"></div>
    <div class="hrp-lb-container">
        <button class="hrp-lb-close" onclick="closeLightbox()" id="lb-close-btn"><i class="fas fa-times"></i></button>
        <button class="hrp-lb-nav hrp-lb-prev" onclick="prevImage()" id="lb-prev-btn"><i class="fas fa-chevron-left"></i></button>
        <button class="hrp-lb-nav hrp-lb-next" onclick="nextImage()" id="lb-next-btn"><i class="fas fa-chevron-right"></i></button>
        <div class="hrp-lb-img-wrap">
            <img src="" alt="" class="hrp-lb-img" id="lb-main-img">
        </div>
        <div class="hrp-lb-footer">
            <div class="hrp-lb-caption">
                <span class="hrp-lb-cat" id="lb-cat"></span>
                <h4 class="hrp-lb-title" id="lb-title"></h4>
            </div>
            <span class="hrp-lb-counter" id="lb-counter">1 / 12</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     BOOK A STAY CTA
═══════════════════════════════════════════════════════ --}}
<section class="hrp-gallery-cta-section">
    <div class="container">
        <div class="hrp-gallery-cta-card">
            <div class="hrp-cta-deco"></div>
            <div class="hrp-cta-text">
                <div class="hrp-section-eyebrow justify-content-center" style="color:#C5A059;">
                    <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
                    <span>Stay With Us</span>
                    <span class="hrp-eyebrow-dash" style="background:#C5A059;"></span>
                </div>
                <h2 class="hrp-cta-heading">Love What You See?</h2>
                <p class="hrp-cta-sub">Experience these stunning spaces in person. Book your stay at Hotel Rose Palace and create memories that last a lifetime.</p>
            </div>
            <div class="hrp-cta-buttons">
                <a href="{{ route('rooms') }}" class="hrp-btn-gold" id="gallery-cta-rooms">
                    <i class="fas fa-bed me-2"></i> Explore Rooms
                </a>
                <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}?text={{ urlencode('Hello! I saw your beautiful gallery and would love to book a stay at Hotel Rose Palace.') }}"
                   target="_blank" class="hrp-cta-wa-btn" id="gallery-cta-wa">
                    <i class="fab fa-whatsapp"></i> Book via WhatsApp
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
}

/* ── PAGE HERO ──────────────────────────────────────────── */
.hrp-page-hero {
    position: relative;
    min-height: 480px;
    background: linear-gradient(165deg, rgba(14,22,32,0.88) 0%, rgba(14,22,32,0.7) 50%, rgba(197,160,89,0.12) 100%),
                url('https://images.unsplash.com/photo-1512918728672-f9d96f4fff8c?w=1600&q=90') center/cover no-repeat;
    display: flex;
    align-items: center;
    overflow: hidden;
}
.hrp-page-hero-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(197,160,89,0.07) 0%, transparent 65%);
}
.hrp-page-hero-container {
    position: relative;
    z-index: 2;
    padding: 100px 24px 60px;
    text-align: center;
}
.hrp-page-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 20px;
}
.hrp-eyebrow-line {
    display: block;
    width: 40px;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold));
}
.hrp-eyebrow-line:last-child { background: linear-gradient(90deg, var(--gold), transparent); }
.hrp-page-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(40px, 6vw, 70px);
    font-weight: 700;
    color: #fff;
    margin-bottom: 16px;
    line-height: 1.1;
    text-shadow: 0 2px 40px rgba(0,0,0,0.3);
}
.hrp-page-hero-sub {
    font-size: clamp(14px, 1.8vw, 17px);
    color: rgba(255,255,255,0.75);
    max-width: 600px;
    margin: 0 auto 24px;
    line-height: 1.8;
}
.hrp-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 12.5px;
    color: rgba(255,255,255,0.5);
}
.hrp-breadcrumb a { color: var(--gold); text-decoration: none; transition: color 0.2s ease; }
.hrp-breadcrumb a:hover { color: #fff; }
.hrp-bc-sep { font-size: 9px; color: rgba(255,255,255,0.3); }

/* ── GALLERY SECTION ────────────────────────────────────── */
.hrp-gallery-section {
    padding: 80px 0 96px;
    background: var(--white);
}

/* Filter Tabs */
.hrp-gallery-filters {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 48px;
}
.hrp-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: transparent;
    border: 1.5px solid #E2D9C8;
    color: var(--txt);
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.hrp-filter-btn i { font-size: 12px; color: var(--gold); }
.hrp-filter-btn:hover,
.hrp-filter-btn.active {
    background: var(--navy);
    border-color: var(--navy);
    color: var(--gold);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(26,34,45,0.2);
}
.hrp-filter-btn.active i { color: var(--gold); }

/* Gallery Grid */
.hrp-gallery-grid {
    columns: 4 280px;
    column-gap: 16px;
}
.hrp-gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    cursor: pointer;
    break-inside: avoid;
    margin-bottom: 16px;
    display: block;
    transition: all 0.4s ease;
}
.hrp-gallery-item.hrp-gi-large { height: 380px; }
.hrp-gallery-item.hrp-gi-medium { height: 260px; }
.hrp-gallery-item.hiding {
    opacity: 0;
    transform: scale(0.9);
    pointer-events: none;
}
.hrp-gi-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
    display: block;
}
.hrp-gallery-item:hover .hrp-gi-img { transform: scale(1.08); }
.hrp-gi-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(14,22,32,0.9) 0%, rgba(14,22,32,0.3) 50%, transparent 100%);
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.35s ease;
}
.hrp-gallery-item:hover .hrp-gi-overlay { opacity: 1; }
.hrp-gi-info {}
.hrp-gi-cat {
    display: inline-block;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 4px;
}
.hrp-gi-title {
    font-family: 'Playfair Display', serif;
    font-size: 15px;
    color: #fff;
    margin: 0;
    font-weight: 600;
}
.hrp-gi-expand {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(197,160,89,0.2);
    border: 1.5px solid rgba(197,160,89,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold);
    font-size: 14px;
    flex-shrink: 0;
    transition: all 0.25s ease;
}
.hrp-gallery-item:hover .hrp-gi-expand {
    background: var(--gold);
    color: var(--navy);
}

/* No results */
.hrp-no-results {
    text-align: center;
    padding: 80px 0;
    color: #aaa;
}
.hrp-no-results i { font-size: 48px; margin-bottom: 16px; color: #ddd; }
.hrp-no-results p { font-size: 16px; }

/* ── LIGHTBOX ────────────────────────────────────────────── */
.hrp-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.hrp-lightbox.active { display: flex; }
.hrp-lb-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.96);
}
.hrp-lb-container {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 92vw;
    max-height: 92vh;
    gap: 16px;
}
.hrp-lb-close {
    position: fixed;
    top: 24px;
    right: 24px;
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.25);
    color: #fff;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.25s ease;
    z-index: 2;
}
.hrp-lb-close:hover { background: rgba(197,160,89,0.3); border-color: var(--gold); color: var(--gold); }
.hrp-lb-nav {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.25);
    color: #fff;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.25s ease;
    z-index: 2;
}
.hrp-lb-prev { left: 20px; }
.hrp-lb-next { right: 20px; }
.hrp-lb-nav:hover { background: rgba(197,160,89,0.25); border-color: var(--gold); color: var(--gold); }
.hrp-lb-img-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    max-height: 76vh;
}
.hrp-lb-img {
    max-width: 88vw;
    max-height: 76vh;
    border-radius: 8px;
    box-shadow: 0 20px 80px rgba(0,0,0,0.5);
    object-fit: contain;
}
.hrp-lb-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 0 8px;
}
.hrp-lb-cat {
    display: block;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 2px;
}
.hrp-lb-title {
    font-family: 'Playfair Display', serif;
    font-size: 17px;
    color: #fff;
    margin: 0;
}
.hrp-lb-counter {
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    color: rgba(255,255,255,0.5);
    white-space: nowrap;
}

/* ── CTA SECTION ────────────────────────────────────────── */
.hrp-gallery-cta-section {
    padding: 0 0 96px;
    background: var(--white);
}
.hrp-gallery-cta-card {
    background: linear-gradient(135deg, #0E1620 0%, #1A222D 50%, #0E1620 100%);
    border-radius: 24px;
    padding: 64px 48px;
    text-align: center;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 24px;
}
.hrp-cta-deco {
    position: absolute;
    top: -60px;
    right: -60px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(197,160,89,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.hrp-cta-heading {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 4vw, 42px);
    color: #fff;
    margin-bottom: 12px;
}
.hrp-cta-sub {
    font-size: 15.5px;
    color: rgba(255,255,255,0.65);
    max-width: 540px;
    line-height: 1.8;
    margin: 0;
}
.hrp-cta-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    justify-content: center;
}
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
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(197,160,89,0.35);
    white-space: nowrap;
}
.hrp-btn-gold:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(197,160,89,0.5); color: var(--navy); }
.hrp-cta-wa-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1.5px solid rgba(37,211,102,0.5);
    color: #25D366;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    padding: 13px 28px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}
.hrp-cta-wa-btn i { font-size: 18px; }
.hrp-cta-wa-btn:hover { background: #25D366; color: #fff; border-color: #25D366; }

/* ── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 991px) {
    .hrp-gallery-grid { columns: 3 220px; }
}
@media (max-width: 767px) {
    .hrp-gallery-grid { columns: 2 160px; column-gap: 10px; }
    .hrp-gallery-item.hrp-gi-large { height: 240px; }
    .hrp-gallery-item.hrp-gi-medium { height: 180px; }
    .hrp-gallery-cta-card { padding: 40px 24px; }
    .hrp-cta-buttons { flex-direction: column; align-items: stretch; }
    .hrp-lb-nav { width: 40px; height: 40px; font-size: 14px; }
    .hrp-lb-prev { left: 8px; }
    .hrp-lb-next { right: 8px; }
}
@media (max-width: 480px) {
    .hrp-gallery-grid { columns: 1; }
    .hrp-gallery-item.hrp-gi-large,
    .hrp-gallery-item.hrp-gi-medium { height: 240px; }
}
</style>
@endsection

@section('extra_js')
<script>
// Gallery data array for lightbox
const galleryData = [
    @foreach($galleryItems as $i => $img)
    { url: "{{ $img['url'] }}", title: "{{ addslashes($img['title']) }}", cat: "{{ $img['cat'] }}" }{{ !$loop->last ? ',' : '' }}
    @endforeach
];

let currentIndex = 0;
let visibleItems = [...galleryData.keys()];

// Filter functionality
document.querySelectorAll('.hrp-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.hrp-filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        filterGallery(filter);
    });
});

function filterGallery(category) {
    const items = document.querySelectorAll('.hrp-gallery-item');
    visibleItems = [];
    let visibleCount = 0;
    items.forEach((item, i) => {
        const itemCat = item.dataset.category;
        if (category === 'all' || itemCat === category) {
            item.classList.remove('hiding');
            item.style.display = 'block';
            visibleItems.push(i);
            visibleCount++;
        } else {
            item.classList.add('hiding');
            setTimeout(() => { if(item.classList.contains('hiding')) item.style.display = 'none'; }, 400);
        }
    });
    document.getElementById('no-results').style.display = visibleCount === 0 ? 'block' : 'none';
}

// Lightbox
function openGalleryLightbox(index) {
    currentIndex = visibleItems.indexOf(index);
    if(currentIndex === -1) currentIndex = 0;
    updateLightbox();
    document.getElementById('gallery-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function updateLightbox() {
    const realIndex = visibleItems[currentIndex] ?? currentIndex;
    const item = galleryData[realIndex];
    if(!item) return;
    const img = document.getElementById('lb-main-img');
    img.style.opacity = '0';
    img.src = item.url;
    img.alt = item.title;
    img.onload = () => { img.style.opacity = '1'; };
    document.getElementById('lb-title').textContent = item.title;
    document.getElementById('lb-cat').textContent = item.cat.charAt(0).toUpperCase() + item.cat.slice(1);
    document.getElementById('lb-counter').textContent = `${currentIndex + 1} / ${visibleItems.length}`;
}

function closeLightbox() {
    document.getElementById('gallery-lightbox').classList.remove('active');
    document.body.style.overflow = '';
}

function prevImage() {
    currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
    updateLightbox();
}

function nextImage() {
    currentIndex = (currentIndex + 1) % visibleItems.length;
    updateLightbox();
}

// Keyboard navigation
document.addEventListener('keydown', e => {
    if (!document.getElementById('gallery-lightbox').classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === 'ArrowRight') nextImage();
});

// Smooth reveal on scroll
(function(){
    if(!('IntersectionObserver' in window)) return;
    const items = document.querySelectorAll('.hrp-gallery-item');
    const io = new IntersectionObserver(entries => {
        entries.forEach((e, i) => {
            if(e.isIntersecting) {
                setTimeout(() => e.target.classList.add('hrp-revealed'), i * 60);
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    items.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        io.observe(el);
    });
    document.head.insertAdjacentHTML('beforeend', '<style>.hrp-revealed{opacity:1!important;transform:none!important;}</style>');
})();
</script>
@endsection
