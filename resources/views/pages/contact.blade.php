@extends('layouts.app')

@section('title', 'Contact Hotel Rose Palace — Reservations & Concierge | Surat, Gujarat')
@section('meta_description', 'Contact Hotel Rose Palace in Vesu, Surat. Direct phone reservations, instant WhatsApp chat, airport shuttle booking, and directions to Atlanta Business Hub.')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════ --}}
<section class="text-center" style="background: linear-gradient(180deg, rgba(110,44,58,0.45) 0%, rgba(46,31,34,0.85) 100%), url('{{ asset('images/hotel/hero-hd-1.jpg') }}') center/cover no-repeat; padding: 100px 20px 80px; position: relative;">
    <div class="container position-relative" style="z-index: 2;">
        <span style="color: var(--hrp-gold-light); font-family: var(--font-ui); font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; display: block; margin-bottom: 12px;">
            ✦ 24/7 Dedicated Assistance ✦
        </span>
        <h1 style="color: var(--hrp-surface); font-size: 46px; margin-bottom: 16px;">Contact Our Concierge</h1>
        <p style="color: var(--hrp-tint); font-size: 18px; max-width: 680px; margin: 0 auto 24px; line-height: 1.6;">
            Have an inquiry about room bookings, airport shuttles, banquet celebrations, or corporate corporate stays? We are here to assist around the clock.
        </p>
        <div class="d-inline-flex align-items-center gap-2" style="background: rgba(247,241,232,0.15); backdrop-filter: blur(10px); padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(247,241,232,0.3); font-size: 13px; color: var(--hrp-surface);">
            <a href="{{ route('home') }}" style="color: var(--hrp-surface);">Home</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; color: var(--hrp-gold);"></i>
            <span>Contact Us</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     ONE-TAP QUICK CONTACT CARDS
═══════════════════════════════════════════════════════ --}}
<div style="background: var(--hrp-tint); border-bottom: 1px solid var(--hrp-border); padding: 24px 0;">
    <div class="container">
        <div class="row g-3">
            
            <div class="col-lg-3 col-sm-6">
                <a href="tel:{{ preg_replace('/\s+/', '', config('hotel.contact.phone_1', '+918866771900')) }}" class="card p-3 h-100 text-decoration-none d-flex flex-row align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--hrp-tint); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--hrp-burgundy);">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <span style="font-size: 11px; text-transform: uppercase; color: var(--hrp-mauve); display: block;">Primary Phone</span>
                        <strong style="color: var(--hrp-plum); font-size: 14px;">{{ config('hotel.contact.phone_1', '+91 88667 71900') }}</strong>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6">
                <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}?text={{ urlencode('Hello Hotel Rose Palace! I would like to inquire about reservations.') }}" target="_blank" class="card p-3 h-100 text-decoration-none d-flex flex-row align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(31,138,76,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px; color: #1f8a4c;">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <span style="font-size: 11px; text-transform: uppercase; color: var(--hrp-mauve); display: block;">WhatsApp Desk</span>
                        <strong style="color: #1f8a4c; font-size: 14px;">Chat Instantly ↗</strong>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6">
                <a href="mailto:{{ config('hotel.contact.email', 'Hotelrosepalacesurat@gmail.com') }}" class="card p-3 h-100 text-decoration-none d-flex flex-row align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--hrp-tint); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--hrp-burgundy);">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <span style="font-size: 11px; text-transform: uppercase; color: var(--hrp-mauve); display: block;">Email Concierge</span>
                        <strong style="color: var(--hrp-plum); font-size: 13px; word-break: break-all;">Hotelrosepalacesurat@gmail.com</strong>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 h-100 d-flex flex-row align-items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--hrp-tint); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--hrp-gold);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <span style="font-size: 11px; text-transform: uppercase; color: var(--hrp-mauve); display: block;">Reception Desk</span>
                        <strong style="color: var(--hrp-plum); font-size: 14px;">Open 24/7 All Year</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     FORM & LOCATION SECTION
═══════════════════════════════════════════════════════ --}}
<section style="background-color: var(--hrp-canvas); padding: 70px 0;">
    <div class="container">
        
        @if(session('success'))
            <div class="alert mb-4" style="background: rgba(39,174,96,0.15); border: 1px solid #27ae60; color: #1b6d3a; border-radius: 8px; padding: 16px 20px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-5">
            
            {{-- Contact Information & Location Details --}}
            <div class="col-lg-5 col-md-12">
                <div class="card p-4 h-100">
                    <span style="color: var(--hrp-gold); font-family: var(--font-ui); font-weight: 700; font-size: 12px; letter-spacing: 2px; text-transform: uppercase;">✦ Property Address ✦</span>
                    <h3 style="color: var(--hrp-plum); margin: 6px 0 16px; font-size: 26px;">Hotel Rose Palace</h3>
                    
                    <p style="color: var(--hrp-mauve); line-height: 1.8; margin-bottom: 24px;">
                        Conveniently situated in one of Surat's most modern commercial hubs, our property provides peaceful accommodations within walking distance to high-end dining, shopping, and major transport corridors.
                    </p>

                    <div class="mb-4">
                        <div class="d-flex gap-3 mb-3">
                            <i class="fas fa-map-marked-alt text-gold fs-5 mt-1"></i>
                            <div>
                                <strong style="color: var(--hrp-plum); display: block; font-size: 14px;">Physical Location</strong>
                                <span style="font-size: 13.5px; color: var(--hrp-mauve);">4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007</span>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-3">
                            <i class="fas fa-plane text-gold fs-5 mt-1"></i>
                            <div>
                                <strong style="color: var(--hrp-plum); display: block; font-size: 14px;">Surat Airport Connectivity</strong>
                                <span style="font-size: 13.5px; color: var(--hrp-mauve);">8.5 km • Approximately 12 minutes drive</span>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <i class="fas fa-gem text-gold fs-5 mt-1"></i>
                            <div>
                                <strong style="color: var(--hrp-plum); display: block; font-size: 14px;">Diamond Bourse Connectivity</strong>
                                <span style="font-size: 13.5px; color: var(--hrp-mauve);">11 km • Approximately 15 minutes drive</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded mt-auto" style="background: var(--hrp-tint); border: 1px solid var(--hrp-border);">
                        <span style="font-size: 12px; font-weight: 700; color: var(--hrp-plum); text-transform: uppercase;">Need Immediate Help?</span>
                        <div class="d-flex gap-2 mt-2">
                            <a href="tel:{{ config('hotel.contact.phone_1', '+918866771900') }}" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-phone-alt"></i> Call Now
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', config('hotel.contact.whatsapp_number', '918799129929')) }}" target="_blank" class="btn btn-whatsapp btn-sm">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Contact / Booking Message Form --}}
            <div class="col-lg-7 col-md-12">
                <div class="card p-4 p-md-5" style="border: 1.5px solid var(--hrp-border); box-shadow: var(--shadow-md);">
                    <h3 style="color: var(--hrp-plum); font-size: 26px; margin-bottom: 6px;">Send Us an Inquiry</h3>
                    <p style="color: var(--hrp-mauve); font-size: 14px; margin-bottom: 24px;">Fill out the form below and our reservations desk will respond within 2 hours.</p>

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <label class="hrp-field-label">Your Full Name *</label>
                                <input type="text" name="name" class="hrp-field-input" placeholder="e.g. Rajesh Shah" required value="{{ old('name') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="hrp-field-label">Email Address *</label>
                                <input type="email" name="email" class="hrp-field-input" placeholder="e.g. rajesh@example.com" required value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="hrp-field-label">Phone / WhatsApp Number</label>
                                <input type="tel" name="phone" class="hrp-field-input" placeholder="e.g. +91 98765 43210" value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="hrp-field-label">Subject / Purpose *</label>
                                <select name="subject" class="hrp-field-input" style="cursor: pointer;">
                                    <option value="Room Reservation">Room & Suite Reservation</option>
                                    <option value="Banquet & Event Inquiry">Banquet / Conference Venue Inquiry</option>
                                    <option value="Airport Shuttle Request">Airport Taxi / Shuttle Request</option>
                                    <option value="General Question">General Hotel Question</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="hrp-field-label">Message / Special Requirements *</label>
                                <textarea name="message" class="hrp-field-input" rows="4" placeholder="Please detail your travel dates, guest count, or specific requests..." required>{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="d-flex align-items-center gap-2" style="font-size: 13.5px; color: var(--hrp-plum); cursor: pointer;">
                                    <input type="checkbox" id="shuttleToggle" name="airport_shuttle" value="1" style="accent-color: var(--hrp-burgundy);">
                                    <span>I would like to request airport pickup/drop-off service (+₹600)</span>
                                </label>
                            </div>

                            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2 pt-2">
                                <span style="font-size: 12px; color: var(--hrp-mauve);">
                                    <i class="fas fa-lock text-gold me-1"></i> Your details are strictly confidential.
                                </span>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Send Inquiry Message
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>

        {{-- Google Maps Embed Frame --}}
        <div class="rounded overflow-hidden mt-5" style="border: 1px solid var(--hrp-border); box-shadow: var(--shadow-md); height: 420px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.139!2d72.79!3d21.146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e0bb55f9c3b%3A0x2b0e21e2a34a4c38!2sAtlanta%20Business%20Hub%20VIP%20Rd%20Vesu%20Surat%20Gujarat!5e0!3m2!1sen!2sin!4v1234567890" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Hotel Rose Palace Location"></iframe>
        </div>

    </div>
</section>

@endsection
