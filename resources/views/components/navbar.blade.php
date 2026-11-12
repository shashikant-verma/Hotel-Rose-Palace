<header id="main-header" class="hrp-header">
    <nav class="navbar navbar-expand-lg" id="main-navbar">
        <div class="container hrp-nav-container">

            {{-- Logo / Brand --}}
            <a class="navbar-brand hrp-brand" href="{{ route('home') }}">
                {{-- SVG Luxury Monogram Crest --}}
                <svg class="hrp-crest" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="19" cy="19" r="18" stroke="#C5A059" stroke-width="1.2"/>
                    <path d="M19 6 L22 12 L28 13.5 L23.5 18.5 L24.8 25 L19 22 L13.2 25 L14.5 18.5 L10 13.5 L16 12 Z" fill="none" stroke="#C5A059" stroke-width="1" stroke-linejoin="round"/>
                    <text x="19" y="22.5" text-anchor="middle" font-family="Georgia,serif" font-size="9" font-weight="700" fill="#C5A059" letter-spacing="0.5">RP</text>
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
                    <li class="nav-item ms-lg-3">
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}" target="_blank" class="hrp-btn-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
/* ── HRP Navbar ─────────────────────────────────────────── */
.hrp-header {
    position: sticky;
    top: 0;
    z-index: 1050;
    transition: background 0.35s ease, box-shadow 0.35s ease;
}

#main-navbar {
    background: rgba(20, 24, 36, 0.97);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 1px solid rgba(212, 175, 55, 0.15);
    padding: 0;
    transition: all 0.35s ease;
}

#main-navbar.scrolled {
    box-shadow: 0 4px 30px rgba(0,0,0,0.5);
    background: rgba(20, 24, 36, 0.99);
}

.hrp-nav-container {
    max-width: 1280px;
    padding: 14px 24px;
}

/* Brand */
.hrp-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.hrp-crest {
    flex-shrink: 0;
    filter: drop-shadow(0 0 6px rgba(197,160,89,0.35));
    transition: filter 0.3s ease;
}
.hrp-brand:hover .hrp-crest {
    filter: drop-shadow(0 0 10px rgba(197,160,89,0.6));
}

.hrp-brand-text {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 20px;
    font-weight: 700;
    color: #D4AF37;
    letter-spacing: 0.3px;
    white-space: nowrap;
}

/* Links */
.hrp-nav-links {
    gap: 4px;
    align-items: center;
}

.hrp-link {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #F8F7F5 !important;
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
    background: #D4AF37;
    border-radius: 2px;
    transition: width 0.3s ease;
}
.hrp-link:hover, .hrp-link--active {
    color: #D4AF37 !important;
    background: rgba(212,175,55,0.15) !important;
}
.hrp-link:hover::after, .hrp-link--active::after {
    width: 60%;
}

/* WhatsApp button */
.hrp-btn-whatsapp {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: linear-gradient(135deg, #25D366, #1ab355);
    color: #fff !important;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    padding: 9px 20px;
    border-radius: 50px;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.3s ease;
    box-shadow: 0 2px 12px rgba(37,211,102,0.3);
}
.hrp-btn-whatsapp:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37,211,102,0.4);
}
.hrp-btn-whatsapp i { font-size: 16px; }

/* Mobile toggler */
.hrp-toggler {
    border: 1.5px solid rgba(212,175,55,0.5);
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
    background: #D4AF37;
    border-radius: 2px;
    transition: all 0.3s ease;
}

@media (max-width: 991px) {
    #navbarNav {
        background: rgba(26, 31, 46, 0.98);
        border-radius: 12px;
        margin-top: 10px;
        padding: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        border: 1px solid rgba(212,175,55,0.15);
    }
    .hrp-nav-links { flex-direction: column; gap: 2px; }
    .hrp-link { width: 100%; }
    .hrp-btn-whatsapp { width: 100%; justify-content: center; margin-top: 8px; }
}
</style>

<script>
// Scroll behaviour — add .scrolled shadow
(function(){
    const navbar = document.getElementById('main-navbar');
    if(!navbar) return;
    function onScroll(){
        if(window.scrollY > 60) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>
