<footer class="hrp-footer">

    {{-- Top Gold Divider --}}
    <div class="hrp-footer-divider"></div>

    <div class="container hrp-footer-container">

        {{-- Main Footer Grid --}}
        <div class="row hrp-footer-grid">

            {{-- Col 1: Brand --}}
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                <div class="hrp-footer-brand">
                    <a href="{{ route('home') }}" class="hrp-footer-logo">
                        <svg width="36" height="36" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="19" cy="19" r="18" stroke="#C5A059" stroke-width="1.2"/>
                            <path d="M19 6 L22 12 L28 13.5 L23.5 18.5 L24.8 25 L19 22 L13.2 25 L14.5 18.5 L10 13.5 L16 12 Z" fill="none" stroke="#C5A059" stroke-width="1" stroke-linejoin="round"/>
                            <text x="19" y="22.5" text-anchor="middle" font-family="Georgia,serif" font-size="9" font-weight="700" fill="#C5A059" letter-spacing="0.5">RP</text>
                        </svg>
                        <span class="hrp-footer-brand-name">Hotel Rose Palace</span>
                    </a>
                </div>
                <p class="hrp-footer-tagline">
                    Experience luxury hospitality where elegance meets comfort — your perfect destination in the heart of Surat, Gujarat.
                </p>
                {{-- Social Icons --}}
                <div class="hrp-footer-socials">
                    @php
                        $fb = \App\Models\HotelSettings::getValue('social_facebook','#');
                        $ig = \App\Models\HotelSettings::getValue('social_instagram','#');
                        $tw = \App\Models\HotelSettings::getValue('social_twitter','#');
                        $yt = \App\Models\HotelSettings::getValue('social_youtube','#');
                    @endphp
                    <a href="{{ $fb }}" target="_blank" class="hrp-social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $ig }}" target="_blank" class="hrp-social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $tw }}" target="_blank" class="hrp-social-icon" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="{{ $yt }}" target="_blank" class="hrp-social-icon" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            {{-- Col 2: Quick Links --}}
            <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                <h6 class="hrp-footer-heading">Quick Links</h6>
                <ul class="hrp-footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('rooms') }}">Rooms & Suites</a></li>
                    <li><a href="{{ route('amenities') }}">Amenities</a></li>
                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>

            {{-- Col 3: Policies --}}
            <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
                <h6 class="hrp-footer-heading">Policies</h6>
                <ul class="hrp-footer-links">
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    <li><a href="{{ route('cancellation') }}">Cancellation Policy</a></li>
                </ul>
                <div class="hrp-checkin-info mt-4">
                    <div class="hrp-ci-row">
                        <i class="fas fa-sign-in-alt"></i>
                        <div>
                            <span class="hrp-ci-label">Check-in</span>
                            <span class="hrp-ci-value">2:00 PM</span>
                        </div>
                    </div>
                    <div class="hrp-ci-row">
                        <i class="fas fa-sign-out-alt"></i>
                        <div>
                            <span class="hrp-ci-label">Check-out</span>
                            <span class="hrp-ci-value">11:00 AM</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Col 4: Contact --}}
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                <h6 class="hrp-footer-heading">Get In Touch</h6>
                <div class="hrp-contact-list">
                    <div class="hrp-contact-row">
                        <div class="hrp-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span class="hrp-contact-label">Address</span>
                            <span class="hrp-contact-val">{{ \App\Models\HotelSettings::getValue('hotel_address', '4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007') }}</span>
                        </div>
                    </div>
                    <div class="hrp-contact-row">
                        <div class="hrp-contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <span class="hrp-contact-label">Phone</span>
                            <a href="tel:{{ config('hotel.contact.phone_1') }}" class="hrp-contact-val">{{ config('hotel.contact.phone_1') }}</a>
                            <a href="tel:{{ config('hotel.contact.phone_2') }}" class="hrp-contact-val">{{ config('hotel.contact.phone_2') }}</a>
                        </div>
                    </div>
                    <div class="hrp-contact-row">
                        <div class="hrp-contact-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <span class="hrp-contact-label">Email</span>
                            <a href="mailto:{{ config('hotel.contact.email') }}" class="hrp-contact-val">{{ config('hotel.contact.email') }}</a>
                        </div>
                    </div>
                </div>

                {{-- WhatsApp CTA Button --}}
                <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}" target="_blank" class="hrp-footer-wa-btn">
                    <i class="fab fa-whatsapp"></i> Chat with us on WhatsApp
                </a>

                {{-- Social Icons Row - Instagram & Location --}}
                <div style="display: flex; gap: 16px; margin-top: 16px; align-items: center;">
                    {{-- Instagram Icon --}}
                    <a href="{{ config('hotel.contact.instagram', '#') }}" target="_blank" class="hrp-footer-icon-btn" title="Follow us on Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    
                    {{-- Google Maps Icon --}}
                    <a href="{{ config('hotel.contact.google_maps', '#') }}" target="_blank" class="hrp-footer-icon-btn" title="View on Google Maps">
                        <i class="fas fa-map-location-dot"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Footer Bottom Bar --}}
        <div class="hrp-footer-bottom">
            <p class="hrp-footer-copy">&copy; 2026 Hotel Rose Palace. All rights reserved. Crafted with <i class="fas fa-heart" style="color:#C5A059;font-size:11px;"></i> in Surat.</p>
            <p class="hrp-footer-credit">Powered by Laravel &nbsp;·&nbsp; Designed for Luxury</p>
        </div>
    </div>
</footer>

<style>
/* ── HRP Footer - Luxury Design System ─────────────────────────────────────────── */
.hrp-footer {
    background: #6E2C3A;
    color: rgba(247, 241, 232, 0.85);
    position: relative;
    margin-top: 0;
}

.hrp-footer-divider {
    height: 3px;
    background: linear-gradient(90deg, transparent, #B88A44 30%, #d4a574 60%, #B88A44 80%, transparent);
}

.hrp-footer-container {
    max-width: 1280px;
    padding: 64px 24px 0;
}

.hrp-footer-grid { padding-bottom: 48px; }

/* Brand */
.hrp-footer-logo {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    margin-bottom: 16px;
}
.hrp-footer-brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 700;
    color: #F7F1E8;
}
.hrp-footer-tagline {
    font-size: 13.5px;
    line-height: 1.8;
    color: rgba(247, 241, 232, 0.65);
    margin-bottom: 20px;
}

/* Social icons */
.hrp-footer-socials { display: flex; gap: 10px; flex-wrap: wrap; }
.hrp-social-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid rgba(184, 138, 68, 0.3);
    color: rgba(184, 138, 68, 0.8);
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-social-icon:hover {
    background: #B88A44;
    border-color: #B88A44;
    color: #6E2C3A;
    transform: translateY(-3px);
}

/* Headings */
.hrp-footer-heading {
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #B88A44;
    margin-bottom: 20px;
}

/* Footer links */
.hrp-footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}
.hrp-footer-links li { margin-bottom: 10px; }
.hrp-footer-links a {
    font-size: 13.5px;
    color: rgba(247, 241, 232, 0.7);
    text-decoration: none;
    transition: color 0.25s ease, padding-left 0.25s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}
.hrp-footer-links a::before {
    content: '›';
    color: #B88A44;
    font-size: 16px;
    line-height: 1;
}
.hrp-footer-links a:hover { color: #B88A44; padding-left: 4px; }

/* Check-in info */
.hrp-ci-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 12.5px;
    color: rgba(247, 241, 232, 0.65);
}
.hrp-ci-row i { color: #B88A44; margin-top: 2px; }
.hrp-ci-label { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; opacity: 0.6; }
.hrp-ci-value { display: block; color: rgba(247, 241, 232, 0.9); font-weight: 600; }

/* Contact */
.hrp-contact-list { margin-bottom: 20px; }
.hrp-contact-row {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
    align-items: flex-start;
}
.hrp-contact-icon {
    width: 32px;
    height: 32px;
    background: rgba(184, 138, 68, 0.12);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.hrp-contact-icon i { color: #B88A44; font-size: 13px; }
.hrp-contact-label {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: rgba(247, 241, 232, 0.5);
    margin-bottom: 2px;
}
.hrp-contact-val {
    display: block;
    font-size: 13px;
    color: rgba(247, 241, 232, 0.85);
    text-decoration: none;
    transition: color 0.2s ease;
    line-height: 1.6;
}
.hrp-contact-val:hover { color: #B88A44; }

/* WhatsApp button */
.hrp-footer-wa-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(37,211,102,0.12);
    border: 1px solid rgba(37,211,102,0.4);
    color: #25D366;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-footer-wa-btn:hover {
    background: #25D366;
    color: #fff;
    box-shadow: 0 4px 16px rgba(37,211,102,0.3);
}
.hrp-footer-wa-btn i { font-size: 16px; }

/* Social Icon Buttons (Instagram, Location) */
.hrp-footer-icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(184, 138, 68, 0.15);
    border: 2px solid #B88A44;
    color: #B88A44;
    font-size: 18px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.hrp-footer-icon-btn:hover {
    background: #B88A44;
    color: #6E2C3A;
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(184, 138, 68, 0.3);
}

/* Bottom bar */
.hrp-footer-bottom {
    border-top: 1px solid rgba(247, 241, 232, 0.1);
    padding: 24px 0 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}
.hrp-footer-copy {
    font-size: 12.5px;
    color: rgba(247, 241, 232, 0.5);
    margin: 0;
}
.hrp-footer-credit {
    font-size: 12px;
    color: rgba(184, 138, 68, 0.6);
    margin: 0;
}

@media (max-width: 768px) {
    .hrp-footer-container { padding: 40px 16px 0; }
    .hrp-footer-bottom { flex-direction: column; text-align: center; }
}
</style>
