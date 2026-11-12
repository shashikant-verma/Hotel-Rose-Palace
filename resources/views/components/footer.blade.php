<footer class="bg-navy text-white pt-5">
    <div class="container">
        <div class="row mb-5">
            <!-- About Section -->
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="mb-3">
                    <i class="fas fa-hotel" style="color: #c9a961;"></i> Hotel Rose Palace
                </h5>
                <p style="font-size: 14px; line-height: 1.8; color: #f5f3f0;">
                    Experience luxury hospitality where elegance meets comfort. Your perfect destination in Surat.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div class="col-md-3 mb-4 mb-md-0">
                <h6 class="text-white mb-3">Quick Links</h6>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="{{ route('home') }}" style="color: #c9a961; text-decoration: none; font-size: 14px;">Home</a></li>
                    <li><a href="{{ route('about') }}" style="color: #c9a961; text-decoration: none; font-size: 14px;">About Us</a></li>
                    <li><a href="{{ route('rooms') }}" style="color: #c9a961; text-decoration: none; font-size: 14px;">Rooms & Suites</a></li>
                    <li><a href="{{ route('gallery') }}" style="color: #c9a961; text-decoration: none; font-size: 14px;">Gallery</a></li>
                    <li><a href="{{ route('contact') }}" style="color: #c9a961; text-decoration: none; font-size: 14px;">Contact</a></li>
                </ul>
            </div>
            
            <!-- Contact Information -->
            <div class="col-md-3 mb-4 mb-md-0">
                <h6 class="text-white mb-3">Contact Us</h6>
                <p style="font-size: 14px; margin-bottom: 8px;">
                    <i class="fas fa-map-marker-alt" style="color: #c9a961; width: 20px;"></i>
                    {{ \App\Models\HotelSettings::getValue('hotel_address', 'Surat, Gujarat') }}
                </p>
                <p style="font-size: 14px; margin-bottom: 8px;">
                    <i class="fas fa-phone" style="color: #c9a961; width: 20px;"></i>
                    <a href="tel:{{ config('hotel.contact.phone_1') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.phone_1') }}</a>
                </p>
                <p style="font-size: 14px;">
                    <i class="fas fa-envelope" style="color: #c9a961; width: 20px;"></i>
                    <a href="mailto:{{ config('hotel.contact.email') }}" style="color: #c9a961; text-decoration: none;">{{ config('hotel.contact.email') }}</a>
                </p>
            </div>
            
            <!-- Follow Us -->
            <div class="col-md-3 mb-4 mb-md-0">
                <h6 class="text-white mb-3">Follow Us</h6>
                <p style="font-size: 14px; margin-bottom: 12px;">Stay updated with our latest offers and updates.</p>
                <div style="gap: 12px; display: flex;">
                    <a href="#" style="color: #c9a961; font-size: 20px;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: #c9a961; font-size: 20px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: #c9a961; font-size: 20px;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: #c9a961; font-size: 20px;"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom border-top" style="border-color: rgba(255, 255, 255, 0.1) !important; padding-top: 24px;">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <p style="font-size: 14px; margin: 0;">© 2024 Hotel Rose Palace. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('privacy') }}" style="color: #c9a961; text-decoration: none; font-size: 14px; margin-right: 20px;">Privacy Policy</a>
                    <a href="{{ route('terms') }}" style="color: #c9a961; text-decoration: none; font-size: 14px; margin-right: 20px;">Terms</a>
                    <a href="{{ route('cancellation') }}" style="color: #c9a961; text-decoration: none; font-size: 14px;">Cancellation</a>
                </div>
            </div>
        </div>
    </div>
</footer>
