<header id="main-header" class="hrp-header">
    {{-- Slim Top Offer Strip --}}
    <div class="hrp-top-strip">
        <div class="container hrp-top-strip-inner">
            <span>✦ Book directly on our website & enjoy 10% off on dining + complimentary early check-in. Use code: <strong class="hrp-code-badge">ROSEDIRECT</strong> ✦</span>
        </div>
    </div>

    {{-- Main Navigation Bar --}}
    <nav class="navbar navbar-expand-lg" id="main-navbar">
        <div class="container hrp-nav-container">

            {{-- Logo / Brand with Luxury Crest --}}
            <a class="navbar-brand hrp-brand" href="{{ route('home') }}">
                <svg class="hrp-crest" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="19" cy="19" r="18" stroke="#B88A44" stroke-width="1.3"/>
                    <path d="M19 6 L22 12 L28 13.5 L23.5 18.5 L24.8 25 L19 22 L13.2 25 L14.5 18.5 L10 13.5 L16 12 Z" fill="none" stroke="#B88A44" stroke-width="1" stroke-linejoin="round"/>
                    <text x="19" y="22.5" text-anchor="middle" font-family="'Cormorant Garamond', Georgia, serif" font-size="10" font-weight="700" fill="#B88A44" letter-spacing="0.5">RP</text>
                </svg>
                <span class="hrp-brand-text">Hotel Rose Palace</span>
            </a>

            {{-- Mobile toggler --}}
            <button class="navbar-toggler hrp-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="hrp-toggler-line"></span>
                <span class="hrp-toggler-line"></span>
                <span class="hrp-toggler-line"></span>
            </button>

            {{-- Nav Links --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto hrp-nav-links">
                    <li class="nav-item">
                        <a class="nav-link hrp-link {{ request()->routeIs('home') ? 'hrp-link--active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hrp-link {{ request()->routeIs('about') ? 'hrp-link--active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hrp-link {{ request()->routeIs('rooms') ? 'hrp-link--active' : '' }}" href="{{ route('rooms') }}">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hrp-link {{ request()->routeIs('amenities') ? 'hrp-link--active' : '' }}" href="{{ route('amenities') }}">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hrp-link {{ request()->routeIs('gallery') ? 'hrp-link--active' : '' }}" href="{{ route('gallery') }}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hrp-link {{ request()->routeIs('contact') ? 'hrp-link--active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to enquire about room availability.') }}" target="_blank" class="hrp-btn-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <button type="button" onclick="if(window.openBookingModal) window.openBookingModal();" class="btn btn-primary" style="padding: 10px 20px; border-radius: 50px; font-size: 13.5px; line-height: 1; white-space: nowrap;">
                            <i class="fas fa-calendar-check"></i>
                            <span>Book Stay</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
/* ── HRP Header & Navigation Tokens ────────────────────────────── */
.hrp-header {
    position: sticky;
    top: 0;
    z-index: 1050;
    transition: background 0.35s ease, box-shadow 0.35s ease;
}

#main-navbar {
    background: rgba(247, 241, 232, 0.96);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 1px solid #D8CBB8;
    padding: 10px 0;
    transition: all 0.35s ease;
}

#main-navbar.scrolled {
    box-shadow: 0 4px 18px rgba(46, 31, 34, 0.12);
    background: rgba(247, 241, 232, 0.98);
    padding: 8px 0;
}

.hrp-nav-container {
    max-width: 1260px;
    padding: 0 20px;
}

.hrp-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}

.hrp-crest {
    flex-shrink: 0;
    filter: drop-shadow(0 0 6px rgba(184, 138, 68, 0.3));
    transition: filter 0.3s ease;
}
.hrp-brand:hover .hrp-crest {
    filter: drop-shadow(0 0 10px rgba(184, 138, 68, 0.6));
}

.hrp-brand-text {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 21px;
    font-weight: 700;
    color: #6E2C3A;
    letter-spacing: 0.3px;
    white-space: nowrap;
}

.hrp-nav-links {
    gap: 4px;
    align-items: center;
}

.hrp-link {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #2E1F22 !important;
    padding: 8px 14px !important;
    border-radius: 6px;
    position: relative;
    transition: color 0.25s ease, background 0.25s ease;
    letter-spacing: 0.2px;
}

.hrp-link::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: #B88A44;
    border-radius: 2px;
    transition: width 0.3s ease;
}

.hrp-link:hover, .hrp-link--active {
    color: #6E2C3A !important;
    background: rgba(110, 44, 58, 0.08) !important;
}

.hrp-link:hover::after, .hrp-link--active::after {
    width: 60%;
}

.hrp-toggler {
    border: 1.5px solid #B88A44;
    border-radius: 8px;
    padding: 8px 10px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    background: transparent;
}

.hrp-toggler-line {
    display: block;
    width: 22px;
    height: 2px;
    background: #6E2C3A;
    border-radius: 2px;
    transition: all 0.3s ease;
}

/* WhatsApp Luxury Capsule Button */
.hrp-btn-whatsapp {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    background: linear-gradient(135deg, #25D366 0%, #1ea952 100%) !important;
    color: #FFFFFF !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    line-height: 1 !important;
    padding: 10px 22px !important;
    border-radius: 50px !important;
    border: 1px solid rgba(255, 255, 255, 0.25) !important;
    text-decoration: none !important;
    white-space: nowrap !important;
    box-shadow: 0 4px 16px rgba(37, 211, 102, 0.35) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    cursor: pointer !important;
}

.hrp-btn-whatsapp:hover {
    background: linear-gradient(135deg, #20ba5a 0%, #168a42 100%) !important;
    color: #FFFFFF !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 22px rgba(37, 211, 102, 0.5) !important;
}

.hrp-btn-whatsapp i {
    font-size: 16px !important;
    line-height: 1 !important;
    color: #FFFFFF !important;
}

@media (max-width: 991.98px) {
    #navbarNav {
        background: rgba(247, 241, 232, 0.98);
        border-radius: 12px;
        margin-top: 10px;
        padding: 16px;
        box-shadow: 0 10px 40px rgba(46, 31, 34, 0.12);
        border: 1px solid #D8CBB8;
    }
    .hrp-nav-links { flex-direction: column; gap: 4px; align-items: stretch; }
    .hrp-link { width: 100%; text-align: center; }
    .hrp-btn-whatsapp, .hrp-nav-links .btn { width: 100%; justify-content: center; margin-top: 6px; }
}
</style>

<script>
(function(){
    const navbar = document.getElementById('main-navbar');
    if(!navbar) return;
    function onScroll(){
        if(window.scrollY > 50) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>
