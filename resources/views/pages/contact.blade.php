@extends('layouts.app')

@section('title', 'Contact Hotel Rose Palace — Get In Touch | Surat, Gujarat')
@section('meta_description', 'Contact Hotel Rose Palace in Surat, Gujarat. Get in touch via phone, WhatsApp, email, or visit us at VIP Road, Vesu. 24/7 assistance for reservations and enquiries.')
@section('meta_keywords', 'contact hotel rose palace, hotel surat contact, hotel enquiry surat, hotel rose palace phone, hotel rose palace whatsapp')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="hrp-contact-hero" id="contact-hero">
    <div class="hrp-contact-hero-overlay"></div>
    <div class="container hrp-contact-hero-container">
        <div class="hrp-page-hero-eyebrow">
            <span class="hrp-eyebrow-line"></span>
            <span>✦ We're Here For You ✦</span>
            <span class="hrp-eyebrow-line"></span>
        </div>
        <h1 class="hrp-contact-hero-title">Get In Touch</h1>
        <p class="hrp-contact-hero-sub">Have a question, need a reservation, or just want to say hello? Our dedicated team is available 24/7 to assist you with warmth and efficiency.</p>
        <nav class="hrp-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="hrp-bc-sep"><i class="fas fa-chevron-right"></i></span>
            <span>Contact Us</span>
        </nav>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     CONTACT QUICK INFO STRIP
═══════════════════════════════════════════════════════ --}}
<div class="hrp-contact-strip-wrap">
    <div class="container">
        <div class="hrp-contact-strip">
            <a href="tel:{{ config('hotel.contact.phone_1') }}" class="hrp-cs-item" id="strip-phone-1">
                <div class="hrp-cs-icon"><i class="fas fa-phone-alt"></i></div>
                <div>
                    <span class="hrp-cs-label">Call Us</span>
                    <span class="hrp-cs-val">{{ config('hotel.contact.phone_1', '+91 70424 24242') }}</span>
                </div>
            </a>
            <div class="hrp-cs-divider"></div>
            <a href="mailto:{{ config('hotel.contact.email') }}" class="hrp-cs-item" id="strip-email">
                <div class="hrp-cs-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <span class="hrp-cs-label">Email Us</span>
                    <span class="hrp-cs-val">{{ config('hotel.contact.email', 'info@hotelrosepalace.com') }}</span>
                </div>
            </a>
            <div class="hrp-cs-divider"></div>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}"
               target="_blank" class="hrp-cs-item hrp-cs-wa" id="strip-whatsapp">
                <div class="hrp-cs-icon hrp-cs-icon--green"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <span class="hrp-cs-label">WhatsApp Us</span>
                    <span class="hrp-cs-val">Chat Instantly</span>
                </div>
            </a>
            <div class="hrp-cs-divider"></div>
            <div class="hrp-cs-item" id="strip-hours">
                <div class="hrp-cs-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <span class="hrp-cs-label">Reception Hours</span>
                    <span class="hrp-cs-val">Open 24/7, All Year</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     CONTACT FORM + INFO
═══════════════════════════════════════════════════════ --}}
<section class="hrp-contact-main" id="contact-form-section">
    <div class="container">
        <div class="row g-5 align-items-start">

            {{-- Left: Contact Info --}}
            <div class="col-lg-5 col-md-12">
                <div class="hrp-contact-info-card">
                    <div class="hrp-section-eyebrow">
                        <span class="hrp-eyebrow-dash"></span>
                        <span>Contact Details</span>
                    </div>
                    <div class="hrp-gold-rule"></div>
                    <h2 class="hrp-ci-heading">We'd Love to<br><span class="hrp-heading-em">Hear From You</span></h2>
                    <p class="hrp-ci-intro">Our concierge team is ready to assist with reservations, event planning, special requests, and all other enquiries.</p>

                    <div class="hrp-ci-details">
                        <div class="hrp-ci-row">
                            <div class="hrp-ci-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <span class="hrp-ci-label">Our Address</span>
                                <span class="hrp-ci-val">{{ config('hotel.location.address', '4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007') }}</span>
                            </div>
                        </div>
                        <div class="hrp-ci-row">
                            <div class="hrp-ci-icon"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <span class="hrp-ci-label">Phone Numbers</span>
                                <a href="tel:{{ config('hotel.contact.phone_1') }}" class="hrp-ci-link">{{ config('hotel.contact.phone_1', '+91 70424 24242') }}</a>
                                <a href="tel:{{ config('hotel.contact.phone_2') }}" class="hrp-ci-link">{{ config('hotel.contact.phone_2', '+91 8071 515 210') }}</a>
                            </div>
                        </div>
                        <div class="hrp-ci-row">
                            <div class="hrp-ci-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <span class="hrp-ci-label">Email Address</span>
                                <a href="mailto:{{ config('hotel.contact.email') }}" class="hrp-ci-link">{{ config('hotel.contact.email', 'info@hotelrosepalace.com') }}</a>
                            </div>
                        </div>
                        <div class="hrp-ci-row">
                            <div class="hrp-ci-icon hrp-ci-icon--green"><i class="fab fa-whatsapp"></i></div>
                            <div>
                                <span class="hrp-ci-label">WhatsApp</span>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '919042424242')) }}"
                                   target="_blank" class="hrp-ci-wa-btn" id="contact-wa-btn">
                                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Hours Box --}}
                    <div class="hrp-hours-box">
                        <h5 class="hrp-hours-title"><i class="fas fa-clock"></i> Hours of Operation</h5>
                        <div class="hrp-hours-row">
                            <span>Reception</span>
                            <span class="hrp-hours-val">24 Hours, 7 Days</span>
                        </div>
                        <div class="hrp-hours-row">
                            <span>Restaurant</span>
                            <span class="hrp-hours-val">7 AM – 11 PM</span>
                        </div>
                        <div class="hrp-hours-row">
                            <span>Spa & Wellness</span>
                            <span class="hrp-hours-val">9 AM – 9 PM</span>
                        </div>
                        <div class="hrp-hours-row">
                            <span>Business Centre</span>
                            <span class="hrp-hours-val">24 Hours</span>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="hrp-ci-social">
                        <span class="hrp-ci-social-label">Follow Us</span>
                        <div class="hrp-ci-social-icons">
                            <a href="#" class="hrp-ci-social-icon" aria-label="Facebook" id="contact-fb">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="hrp-ci-social-icon" aria-label="Instagram" id="contact-ig">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="hrp-ci-social-icon" aria-label="Twitter" id="contact-tw">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Contact Form --}}
            <div class="col-lg-7 col-md-12">
                <div class="hrp-contact-form-card">
                    <div class="hrp-section-eyebrow">
                        <span class="hrp-eyebrow-dash"></span>
                        <span>Send a Message</span>
                    </div>
                    <div class="hrp-gold-rule"></div>
                    <h3 class="hrp-cf-heading">Leave Us a Message</h3>
                    <p class="hrp-cf-sub">Fill in the form below and our team will get back to you within 24 hours. For urgent requests, please contact us on WhatsApp.</p>

                    @if(session('success'))
                    <div class="hrp-alert-success" id="contact-success-alert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="hrp-alert-error" id="contact-error-alert">
                        <i class="fas fa-exclamation-circle"></i>
                        Please correct the errors below and try again.
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" id="contact-main-form" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="hrp-form-group">
                                    <label for="contact-name" class="hrp-label">Full Name <span class="hrp-required">*</span></label>
                                    <div class="hrp-input-wrap">
                                        <i class="fas fa-user hrp-input-icon"></i>
                                        <input type="text" id="contact-name" name="name" class="hrp-input {{ $errors->has('name') ? 'hrp-input-error' : '' }}"
                                               placeholder="Your full name" value="{{ old('name') }}" required>
                                    </div>
                                    @error('name')<span class="hrp-field-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="hrp-form-group">
                                    <label for="contact-email" class="hrp-label">Email Address <span class="hrp-required">*</span></label>
                                    <div class="hrp-input-wrap">
                                        <i class="fas fa-envelope hrp-input-icon"></i>
                                        <input type="email" id="contact-email" name="email" class="hrp-input {{ $errors->has('email') ? 'hrp-input-error' : '' }}"
                                               placeholder="your@email.com" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')<span class="hrp-field-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="hrp-form-group">
                                    <label for="contact-phone" class="hrp-label">Phone Number</label>
                                    <div class="hrp-input-wrap">
                                        <i class="fas fa-phone hrp-input-icon"></i>
                                        <input type="tel" id="contact-phone" name="phone" class="hrp-input"
                                               placeholder="+91 00000 00000" value="{{ old('phone') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="hrp-form-group">
                                    <label for="contact-subject" class="hrp-label">Subject <span class="hrp-required">*</span></label>
                                    <div class="hrp-input-wrap">
                                        <i class="fas fa-tag hrp-input-icon"></i>
                                        <select id="contact-subject" name="subject" class="hrp-input hrp-select {{ $errors->has('subject') ? 'hrp-input-error' : '' }}" required>
                                            <option value="">— Select a subject —</option>
                                            <option value="Room Reservation" {{ old('subject') == 'Room Reservation' ? 'selected' : '' }}>Room Reservation</option>
                                            <option value="Event & Banquet" {{ old('subject') == 'Event & Banquet' ? 'selected' : '' }}>Event & Banquet</option>
                                            <option value="Corporate Stay" {{ old('subject') == 'Corporate Stay' ? 'selected' : '' }}>Corporate Stay</option>
                                            <option value="Spa & Wellness" {{ old('subject') == 'Spa & Wellness' ? 'selected' : '' }}>Spa & Wellness</option>
                                            <option value="Feedback & Reviews" {{ old('subject') == 'Feedback & Reviews' ? 'selected' : '' }}>Feedback & Reviews</option>
                                            <option value="General Enquiry" {{ old('subject') == 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
                                        </select>
                                    </div>
                                    @error('subject')<span class="hrp-field-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="hrp-form-group">
                                    <label for="contact-message" class="hrp-label">Your Message <span class="hrp-required">*</span></label>
                                    <div class="hrp-input-wrap">
                                        <i class="fas fa-comment-alt hrp-input-icon hrp-input-icon--top"></i>
                                        <textarea id="contact-message" name="message" class="hrp-input hrp-textarea {{ $errors->has('message') ? 'hrp-input-error' : '' }}"
                                                  placeholder="Tell us how we can help you..." rows="5" required>{{ old('message') }}</textarea>
                                    </div>
                                    @error('message')<span class="hrp-field-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="hrp-form-actions">
                                    <button type="submit" class="hrp-btn-submit" id="contact-submit-btn">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        <span>Send Message</span>
                                        <div class="hrp-btn-loader" id="contact-btn-loader" style="display:none;">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </button>
                                    <p class="hrp-form-note">
                                        <i class="fas fa-lock"></i>
                                        Your information is safe with us — we never share your data.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     GOOGLE MAP
═══════════════════════════════════════════════════════ --}}
<section class="hrp-contact-map-section" id="hotel-location">
    <div class="container">
        <div class="hrp-section-header text-center">
            <div class="hrp-section-eyebrow justify-content-center">
                <span class="hrp-eyebrow-dash"></span>
                <span>Find Us</span>
                <span class="hrp-eyebrow-dash"></span>
            </div>
            <div class="hrp-gold-rule hrp-gold-rule--center"></div>
            <h2 class="hrp-section-heading">Our Location</h2>
            <p class="hrp-section-sub">Conveniently located in Vesu on VIP Road — easily reachable from Surat Airport, Railway Station, and city centre.</p>
        </div>

        <div class="hrp-map-container">
            <iframe
                title="Hotel Rose Palace on Google Maps"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.139!2d72.792!3d21.146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e0bb55f9c3b%3A0x2b0e21e2a34a4c38!2sAtlanta%20Business%20Hub%2C%20VIP%20Rd%2C%20Vesu%2C%20Surat%2C%20Gujarat%20395007!5e0!3m2!1sen!2sin!4v1699999999999!5m2!1sen!2sin"
                class="hrp-map-iframe"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                id="contact-map-iframe"
            ></iframe>
            <div class="hrp-map-pin-btn">
                <a href="https://goo.gl/maps/EXAMPLE" target="_blank" class="hrp-btn-gold" id="open-maps-btn">
                    <i class="fas fa-directions me-2"></i> Get Directions
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
    --navy: #1A222D; --gold: #C5A059; --gold-lt: #e8c97a;
    --cream: #F8F6F2; --white: #FFFFFF; --dark: #0E1620; --txt: #4A5568;
}

/* ── SHARED ─────────────────────────────────────────────── */
.hrp-section-eyebrow { display: flex; align-items: center; gap: 12px; font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 8px; }
.hrp-eyebrow-dash { flex: 1; max-width: 40px; height: 1.5px; background: var(--gold); border-radius: 2px; }
.hrp-gold-rule { width: 50px; height: 3px; background: linear-gradient(90deg, var(--gold), var(--gold-lt)); border-radius: 2px; margin: 10px 0 20px; }
.hrp-gold-rule--center { margin: 10px auto 24px; }
.hrp-section-heading { font-family: 'Playfair Display', serif; font-size: clamp(28px,4vw,40px); color: var(--navy); font-weight: 700; margin-bottom: 12px; line-height: 1.25; }
.hrp-heading-em { color: var(--gold); font-style: italic; }
.hrp-section-sub { font-size: 15.5px; color: var(--txt); max-width: 620px; margin: 0 auto 48px; line-height: 1.75; }
.hrp-btn-gold { display: inline-flex; align-items: center; background: linear-gradient(135deg, var(--gold), var(--gold-lt)); color: var(--navy); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14.5px; padding: 14px 32px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(197,160,89,0.35); white-space: nowrap; }
.hrp-btn-gold:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(197,160,89,0.5); color: var(--navy); }

/* ── HERO ───────────────────────────────────────────────── */
.hrp-contact-hero {
    position: relative; min-height: 480px;
    background: linear-gradient(165deg, rgba(14,22,32,0.9) 0%, rgba(14,22,32,0.68) 50%, rgba(197,160,89,0.12) 100%),
                url('https://images.unsplash.com/photo-1521783593447-5702b9bfd267?w=1600&q=90') center/cover no-repeat;
    display: flex; align-items: center; overflow: hidden;
}
.hrp-contact-hero-overlay { position: absolute; inset: 0; background: radial-gradient(ellipse at 25% 50%, rgba(197,160,89,0.07) 0%, transparent 65%); }
.hrp-contact-hero-container { position: relative; z-index: 2; padding: 100px 24px 60px; text-align: center; }
.hrp-page-hero-eyebrow { display: inline-flex; align-items: center; gap: 14px; font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3.5px; text-transform: uppercase; color: var(--gold); margin-bottom: 20px; }
.hrp-eyebrow-line { display: block; width: 40px; height: 1px; background: linear-gradient(90deg, transparent, var(--gold)); }
.hrp-eyebrow-line:last-child { background: linear-gradient(90deg, var(--gold), transparent); }
.hrp-contact-hero-title { font-family: 'Playfair Display', serif; font-size: clamp(40px,6vw,70px); font-weight: 700; color: #fff; margin-bottom: 16px; text-shadow: 0 2px 40px rgba(0,0,0,0.3); }
.hrp-contact-hero-sub { font-size: clamp(14px,1.8vw,17px); color: rgba(255,255,255,0.75); max-width: 600px; margin: 0 auto 24px; line-height: 1.8; }
.hrp-breadcrumb { display: inline-flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-size: 12.5px; color: rgba(255,255,255,0.5); }
.hrp-breadcrumb a { color: var(--gold); text-decoration: none; }
.hrp-breadcrumb a:hover { color: #fff; }
.hrp-bc-sep { font-size: 9px; color: rgba(255,255,255,0.3); }

/* ── QUICK STRIP ─────────────────────────────────────────── */
.hrp-contact-strip-wrap { background: var(--white); border-top: 3px solid var(--gold); box-shadow: 0 8px 30px rgba(0,0,0,0.08); position: relative; z-index: 10; }
.hrp-contact-strip { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; padding: 20px; gap: 0; }
.hrp-cs-item { display: flex; align-items: center; gap: 14px; padding: 12px 28px; text-decoration: none; transition: all 0.3s ease; }
.hrp-cs-item:hover { background: rgba(197,160,89,0.05); }
.hrp-cs-icon { width: 44px; height: 44px; border-radius: 12px; background: rgba(197,160,89,0.1); border: 1px solid rgba(197,160,89,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.hrp-cs-icon i { color: var(--gold); font-size: 18px; }
.hrp-cs-icon--green { background: rgba(37,211,102,0.1); border-color: rgba(37,211,102,0.2); }
.hrp-cs-icon--green i { color: #25D366; }
.hrp-cs-label { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #aaa; font-family: 'Poppins', sans-serif; margin-bottom: 2px; }
.hrp-cs-val { display: block; font-size: 13.5px; font-weight: 600; color: var(--navy); font-family: 'Poppins', sans-serif; }
.hrp-cs-wa .hrp-cs-val { color: #25D366; }
.hrp-cs-divider { width: 1px; height: 40px; background: rgba(197,160,89,0.15); margin: 0 8px; }

/* ── CONTACT MAIN SECTION ───────────────────────────────── */
.hrp-contact-main { padding: 80px 0; background: var(--cream); }

/* Info Card */
.hrp-contact-info-card { }
.hrp-ci-heading { font-family: 'Playfair Display', serif; font-size: clamp(24px,2.5vw,32px); color: var(--navy); margin-bottom: 12px; line-height: 1.3; }
.hrp-ci-intro { font-size: 15px; color: var(--txt); line-height: 1.8; margin-bottom: 28px; }
.hrp-ci-details { display: flex; flex-direction: column; gap: 0; margin-bottom: 24px; }
.hrp-ci-row { display: flex; gap: 14px; align-items: flex-start; padding: 16px 0; border-bottom: 1px solid rgba(197,160,89,0.1); }
.hrp-ci-row:last-child { border-bottom: none; }
.hrp-ci-icon { width: 38px; height: 38px; border-radius: 10px; background: rgba(197,160,89,0.1); border: 1px solid rgba(197,160,89,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.hrp-ci-icon i { color: var(--gold); font-size: 14px; }
.hrp-ci-icon--green { background: rgba(37,211,102,0.1); border-color: rgba(37,211,102,0.2); }
.hrp-ci-icon--green i { color: #25D366; }
.hrp-ci-label { display: block; font-size: 10.5px; text-transform: uppercase; letter-spacing: 1px; color: #AAA; font-family: 'Poppins', sans-serif; margin-bottom: 4px; }
.hrp-ci-val { display: block; font-size: 13.5px; color: var(--navy); line-height: 1.6; }
.hrp-ci-link { display: block; font-size: 13.5px; color: var(--navy); text-decoration: none; transition: color 0.25s ease; line-height: 1.65; }
.hrp-ci-link:hover { color: var(--gold); }
.hrp-ci-wa-btn { display: inline-flex; align-items: center; gap: 7px; background: rgba(37,211,102,0.08); border: 1.5px solid rgba(37,211,102,0.3); color: #1a9e4a; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 50px; text-decoration: none; transition: all 0.3s ease; margin-top: 6px; }
.hrp-ci-wa-btn:hover { background: #25D366; color: #fff; border-color: #25D366; }
.hrp-ci-wa-btn i { font-size: 15px; }

/* Hours Box */
.hrp-hours-box { background: var(--white); border: 1.5px solid rgba(197,160,89,0.2); border-radius: 14px; padding: 20px 24px; margin-bottom: 20px; }
.hrp-hours-title { font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 700; color: var(--navy); margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
.hrp-hours-title i { color: var(--gold); }
.hrp-hours-row { display: flex; justify-content: space-between; align-items: center; padding: 7px 0; border-bottom: 1px dashed rgba(197,160,89,0.15); font-size: 13px; color: var(--txt); }
.hrp-hours-row:last-child { border-bottom: none; }
.hrp-hours-val { font-weight: 700; color: var(--navy); font-family: 'Poppins', sans-serif; }

/* Social */
.hrp-ci-social { display: flex; align-items: center; gap: 12px; }
.hrp-ci-social-label { font-size: 12px; color: #aaa; font-family: 'Poppins', sans-serif; text-transform: uppercase; letter-spacing: 1px; }
.hrp-ci-social-icons { display: flex; gap: 8px; }
.hrp-ci-social-icon { width: 36px; height: 36px; border-radius: 50%; border: 1.5px solid rgba(197,160,89,0.3); color: rgba(197,160,89,0.8); font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease; }
.hrp-ci-social-icon:hover { background: var(--gold); border-color: var(--gold); color: var(--navy); transform: translateY(-3px); }

/* Form Card */
.hrp-contact-form-card { background: var(--white); border-radius: 20px; padding: 40px; box-shadow: 0 8px 40px rgba(0,0,0,0.08); border: 1.5px solid rgba(197,160,89,0.1); }
.hrp-cf-heading { font-family: 'Playfair Display', serif; font-size: 24px; color: var(--navy); margin-bottom: 8px; }
.hrp-cf-sub { font-size: 14px; color: var(--txt); line-height: 1.7; margin-bottom: 24px; }
.hrp-alert-success { background: rgba(39,174,96,0.1); border: 1.5px solid rgba(39,174,96,0.3); color: #1a9e4a; border-radius: 10px; padding: 14px 18px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.hrp-alert-error { background: rgba(231,76,60,0.1); border: 1.5px solid rgba(231,76,60,0.3); color: #c0392b; border-radius: 10px; padding: 14px 18px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }

/* Form Fields */
.hrp-form-group { margin-bottom: 0; }
.hrp-label { display: block; font-family: 'Poppins', sans-serif; font-size: 12.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--navy); margin-bottom: 7px; }
.hrp-required { color: var(--gold); }
.hrp-input-wrap { position: relative; }
.hrp-input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(197,160,89,0.5); font-size: 14px; pointer-events: none; }
.hrp-input-icon--top { top: 16px; transform: none; }
.hrp-input {
    width: 100%; padding: 12px 14px 12px 42px;
    border: 1.5px solid #E2D9C8; border-radius: 10px;
    font-family: 'Poppins', sans-serif; font-size: 14px;
    color: var(--navy); background: #FAFAF8;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
    outline: none;
}
.hrp-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(197,160,89,0.12); }
.hrp-input::placeholder { color: #bbb; }
.hrp-input-error { border-color: rgba(231,76,60,0.5) !important; }
.hrp-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23C5A059' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
.hrp-textarea { resize: vertical; min-height: 130px; padding-top: 14px; }
.hrp-field-error { display: block; font-size: 12px; color: #c0392b; margin-top: 4px; font-family: 'Poppins', sans-serif; }
.hrp-form-actions { display: flex; flex-direction: column; gap: 12px; }
.hrp-btn-submit { display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: linear-gradient(135deg, var(--gold), var(--gold-lt)); color: var(--navy); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 15px; padding: 16px 40px; border-radius: 50px; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(197,160,89,0.35); align-self: flex-start; }
.hrp-btn-submit:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(197,160,89,0.5); }
.hrp-form-note { font-size: 12px; color: #aaa; font-family: 'Poppins', sans-serif; display: flex; align-items: center; gap: 7px; margin: 0; }
.hrp-form-note i { color: var(--gold); font-size: 11px; }

/* ── MAP SECTION ────────────────────────────────────────── */
.hrp-contact-map-section { padding: 80px 0 96px; background: var(--white); }
.hrp-map-container { position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 50px rgba(0,0,0,0.12); border: 1.5px solid rgba(197,160,89,0.15); }
.hrp-map-iframe { width: 100%; height: 480px; border: none; display: block; }
.hrp-map-pin-btn { position: absolute; bottom: 20px; left: 20px; }

/* ── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 991px) {
    .hrp-contact-strip { justify-content: flex-start; overflow-x: auto; padding: 16px; }
    .hrp-cs-divider { display: none; }
}
@media (max-width: 767px) {
    .hrp-contact-form-card { padding: 24px; }
    .hrp-map-iframe { height: 320px; }
    section { padding: 64px 0; }
}
</style>
@endsection

@section('extra_js')
<script>
// Form submit with loading state
document.getElementById('contact-main-form')?.addEventListener('submit', function() {
    const btn = document.getElementById('contact-submit-btn');
    const loader = document.getElementById('contact-btn-loader');
    if(btn && loader) {
        btn.querySelector('span').textContent = 'Sending...';
        loader.style.display = 'inline-block';
        btn.disabled = true;
    }
});

// Scroll-reveal animation
(function(){
    if(!('IntersectionObserver' in window)) return;
    const els = document.querySelectorAll('.hrp-contact-info-card,.hrp-contact-form-card,.hrp-cs-item');
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
