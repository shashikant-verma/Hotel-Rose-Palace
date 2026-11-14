<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Rose Palace — Luxury Hotel in Surat, Gujarat')</title>
    <meta name="description" content="@yield('meta_description', 'Experience premier luxury hospitality at Hotel Rose Palace, Surat. Featuring royal suites, corporate banquet halls, and 24/7 personalized service on VIP Road, Vesu.')">
    <meta name="keywords" content="@yield('meta_keywords', 'hotel rose palace surat, luxury hotel surat, best hotel in vesu surat, hotel near surat airport, diamond bourse hotel, rooms booking surat')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph & Social Cards --}}
    <meta property="og:type" content="hotel">
    <meta property="og:site_name" content="Hotel Rose Palace">
    <meta property="og:title" content="@yield('title', 'Hotel Rose Palace — Where Elegance Meets Comfort')">
    <meta property="og:description" content="@yield('meta_description', 'Premier luxury stay in Surat, Gujarat. World-class suites, banquet halls, and bespoke hospitality.')">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Hotel Rose Palace Surat')">
    <meta name="twitter:description" content="@yield('meta_description', 'Experience luxury hospitality in the heart of Surat.')">

    {{-- Google Fonts: Luxury Design System --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Vite CSS --}}
    @vite('resources/css/app.css')

    {{-- Extra CSS from child views --}}
    @yield('extra_css')
</head>
<body>
    {{-- Navigation --}}
    @include('components.navbar')

    {{-- Main Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- Real Interactive Booking & Price Calculator Modal (Global) --}}
    @include('components.booking-modal')

    {{-- Sticky Mobile Action Dock (For screens < 768px) --}}
    <div class="hrp-mobile-dock" id="mobileActionDock">
        <a href="tel:{{ preg_replace('/\s+/', '', config('hotel.contact.phone_1', '+918866771900')) }}" class="hrp-mdock-btn" aria-label="Call Reception">
            <i class="fas fa-phone-alt"></i>
            <span>Call</span>
        </a>
        <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to enquire about room availability.') }}" target="_blank" class="hrp-mdock-btn wa" aria-label="WhatsApp Enquiry">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <a href="{{ config('hotel.contact.google_maps', 'https://maps.google.com') }}" target="_blank" rel="noopener noreferrer" class="hrp-mdock-btn" aria-label="Get Directions">
            <i class="fas fa-location-arrow"></i>
            <span>Directions</span>
        </a>
        <a href="{{ route('booking.search.form') }}" class="hrp-mdock-book" style="text-decoration: none;">
            <i class="fas fa-calendar-check"></i>
            <span>Book Now</span>
        </a>
    </div>

    {{-- Floating WhatsApp Button (Desktop & Tablet) --}}
    <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to enquire about room availability.') }}" target="_blank" class="hrp-floating-whatsapp" aria-label="Chat on WhatsApp" title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    {{-- Fullscreen Lightbox Modal for Photo Gallery & Room Detail --}}
    <div id="hrpGlobalLightbox" class="hrp-lightbox" onclick="if(event.target === this) closeLightbox();">
        <button class="hrp-lightbox-close" onclick="closeLightbox()" aria-label="Close lightbox">&times;</button>
        <button class="hrp-lightbox-prev" onclick="prevLightboxImage()" aria-label="Previous image"><i class="fas fa-chevron-left"></i></button>
        <img id="hrpLightboxImage" src="" class="hrp-lightbox-img" alt="Hotel Rose Palace view">
        <button class="hrp-lightbox-next" onclick="nextLightboxImage()" aria-label="Next image"><i class="fas fa-chevron-right"></i></button>
    </div>

    {{-- Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Vite JS --}}
    @vite('resources/js/app.js')

    {{-- Global Lightbox Logic --}}
    <script>
    window.lightboxImages = [];
    window.currentLightboxIdx = 0;

    function openLightbox(imgSrc, groupSelector) {
        lightboxImages = [];
        const items = document.querySelectorAll(groupSelector || '.hrp-lightbox-trigger');
        items.forEach((item, idx) => {
            const src = item.getAttribute('data-full') || item.getAttribute('src');
            lightboxImages.push(src);
            if (src === imgSrc) currentLightboxIdx = idx;
        });

        if (lightboxImages.length === 0) {
            lightboxImages.push(imgSrc);
            currentLightboxIdx = 0;
        }

        updateLightboxView();
        document.getElementById('hrpGlobalLightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lb = document.getElementById('hrpGlobalLightbox');
        if (lb) lb.classList.remove('active');
        document.body.style.overflow = '';
    }

    function nextLightboxImage() {
        if (lightboxImages.length === 0) return;
        currentLightboxIdx = (currentLightboxIdx + 1) % lightboxImages.length;
        updateLightboxView();
    }

    function prevLightboxImage() {
        if (lightboxImages.length === 0) return;
        currentLightboxIdx = (currentLightboxIdx - 1 + lightboxImages.length) % lightboxImages.length;
        updateLightboxView();
    }

    function updateLightboxView() {
        const img = document.getElementById('hrpLightboxImage');
        if (img && lightboxImages[currentLightboxIdx]) {
            img.src = lightboxImages[currentLightboxIdx];
        }
    }

    document.addEventListener('keydown', function(e) {
        const lb = document.getElementById('hrpGlobalLightbox');
        if (!lb || !lb.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') nextLightboxImage();
        if (e.key === 'ArrowLeft') prevLightboxImage();
    });
    </script>

    {{-- Extra JS from child views --}}
    @yield('extra_js')
</body>
</html>
