# Hotel Rose Palace - Project Development Roadmap

**Project Name:** Hotel Rose Palace  
**Location:** 4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007  
**Technology Stack:** Laravel 12, MySQL, Blade Templates, Bootstrap 5/Tailwind CSS  
**Start Date:** November 12, 2026  
**Project Status:** Planning Phase

---

## PROJECT OVERVIEW

Hotel Rose Palace is a premium hospitality website project for a 4-star hotel in Surat, Gujarat. The project consists of two main components:

1. **Customer-Facing Website** - Beautiful, responsive hotel website with **Direct Online Room Booking System**
2. **Admin Dashboard** - Secure backend for managing rooms, bookings, payments, and hotel settings

### Key Business Features
- **Direct Online Booking** - Customers can search, book, and pay for rooms directly through the website
- **OTP-Based Verification** - Mobile number verification without mandatory password or account registration
- **Real-Time Availability** - Category-wise and date-wise room availability checking
- **Integrated Payment** - 100% full payment through Razorpay with automatic booking confirmation
- **Customer Self-Service** - Customers can view, manage, and cancel bookings using OTP verification
- **Automated Refunds** - 24-hour cancellation policy with automatic refund calculation
- **Dynamic Room Management** - Room categories, physical rooms, and pricing configurable via admin
- **Secure Inventory** - Prevents overbooking with database transactions and row-level locking
- **Configurable Settings** - All hotel information managed via admin panel

---

## PROJECT OBJECTIVES

1. Create a professional, premium hotel website reflecting Hotel Rose Palace's brand
2. Implement **Direct Online Room Booking** with real-time availability
3. Enable customers to book without mandatory registration or passwords
4. Provide **OTP-based customer verification** for secure, passwordless booking management
5. Integrate **Razorpay full payment** with automatic booking confirmation
6. Implement **category-wise room inventory** with overbooking prevention
7. Enable customer self-service for booking management and cancellations
8. Build a comprehensive admin dashboard for booking and payment management
9. Establish a scalable, maintainable Laravel architecture
10. Ensure responsive design across all devices
11. Implement comprehensive security measures (OTP, payment verification, IDOR protection)
12. Enable easy future maintenance and updates

---

## DEVELOPMENT ROADMAP

```
┌─────────────────────────────────────────────────────────────┐
│          HOTEL ROSE PALACE DEVELOPMENT PHASES               │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  Phase 1 ─→ Phase 2 ─→ Phase 3 ─→ Phase 4 ─→ Phase 5       │
│      ↓          ↓          ↓          ↓          ↓           │
│  Setup     Frontend      Database   Admin      Rooms         │
│                ↓          ↓          ↓          ↓           │
│             Phase 6 ─→ Phase 7 ─→ Phase 8 (A-F) ─→          │
│            Room Browse Settings Direct Booking               │
│                ↓          ↓          ↓                       │
│                      Phase 9 ─→ Phase 10                     │
│                     Testing    Production                    │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

**Note:** Phase 8 is divided into 6 sub-phases (8A through 8F) to implement the complete Direct Online Booking System.

---

## PHASE-WISE IMPLEMENTATION PLAN

### PHASE 1: PROJECT SETUP AND REQUIREMENT ANALYSIS
**Duration:** 1-2 days  
**Status:** ✅ COMPLETED

#### Objective
- Initialize Laravel 12 project
- Set up development environment
- Configure database connection
- Create project directory structure
- Set up Git version control
- Install required dependencies

#### Tasks
- [x] Create Laravel 12 project using Composer
- [x] Configure `.env` file with database credentials
- [x] Set up MySQL database connection
- [x] Install Node.js dependencies (npm)
- [x] Configure Vite for frontend assets
- [x] Initialize Git repository
- [x] Create project folder structure following Laravel conventions
- [x] Document environment setup requirements

#### Files to Create/Modify
- ✅ `composer.json` - PHP dependencies (updated)
- ✅ `package.json` - Node.js dependencies (installed)
- ✅ `.env` - Environment configuration (MySQL configured)
- ✅ `.env.example` - Environment template
- ✅ `.gitignore` - Git exclusions (created)
- ✅ `README.md` - Project setup instructions (created)
- ✅ `config/hotel.php` - Custom hotel configuration
- ✅ All database migrations (10 tables created)
- ✅ All Eloquent models (9 models created)
- ✅ Database seeders (initial data seeded)

#### Dependencies
- None (First phase)

#### Expected Results
- ✅ Clean Laravel 12 project installed
- ✅ Database configured and connected
- ✅ Development environment ready
- ✅ Git repository initialized
- ✅ All 10 database tables created with proper relationships
- ✅ All 9 Eloquent models created with relationships
- ✅ Initial admin users, amenities, and settings seeded
- ✅ Can run `php artisan serve`

#### Testing Checklist
- [x] Laravel welcome page loads at `http://localhost:8000`
- [x] Database connection successful
- [x] `php artisan migrate` ran successfully
- [x] npm dependencies installed
- [x] Git tracking initialized
- [x] Database tables created (verified with tinker)
- [x] Models and relationships working
- [x] Seeders populated data

#### Definition of Done
- ✅ Laravel 12 project fully initialized
- ✅ All dependencies installed
- ✅ Database ready with proper schema
- ✅ Development server runs successfully
- ✅ Git repo initialized and committed
- ✅ All documentation files created and approved
- ✅ Ready for Phase 2 (Frontend UI Development)

---

### PHASE 2: PREMIUM FRONTEND UI DEVELOPMENT
**Duration:** 3-4 days  
**Status:** ✅ COMPLETED

#### Objective
- Build responsive customer-facing website pages
- Implement premium design system
- Create reusable Blade components
- Build static HTML structure

#### Tasks
- [x] Create Base Layout (Blade template with header/footer)
- [x] Build Navigation/Header component
- [x] Build Footer component
- [x] Create Home Page
- [x] Create About Us Page
- [x] Create Rooms & Suites Page (with static room cards)
- [x] Create Room Details Page template
- [x] Create Gallery Page
- [x] Create Amenities Page
- [x] Create Contact Us Page
- [x] Create Legal Pages (Privacy, Terms, Cancellation Policy)
- [x] Implement CSS styling (Bootstrap 5 + Custom CSS)
- [x] Set up responsive design breakpoints
- [x] Create reusable UI components (buttons, cards, forms, modals)

#### Files to Create/Modify
- ✅ `routes/web.php` - Web routes (all 13 routes created)
- ✅ `app/Http/Controllers/PageController.php` - Page controller with 10 methods
- ✅ `resources/views/layouts/app.blade.php` - Base layout with Bootstrap integration
- ✅ `resources/views/components/navbar.blade.php` - Navigation component
- ✅ `resources/views/components/footer.blade.php` - Footer component
- ✅ `resources/views/pages/home.blade.php` - Homepage
- ✅ `resources/views/pages/about.blade.php` - About page
- ✅ `resources/views/pages/rooms.blade.php` - Rooms listing
- ✅ `resources/views/pages/room-detail.blade.php` - Room details
- ✅ `resources/views/pages/gallery.blade.php` - Gallery page
- ✅ `resources/views/pages/amenities.blade.php` - Amenities page
- ✅ `resources/views/pages/contact.blade.php` - Contact page
- ✅ `resources/views/pages/privacy.blade.php` - Privacy policy
- ✅ `resources/views/pages/terms.blade.php` - Terms & conditions
- ✅ `resources/views/pages/cancellation.blade.php` - Cancellation policy
- ✅ `resources/css/app.css` - Complete CSS with responsive design
- `resources/css/app.css` - Custom styling
- `resources/js/app.js` - JavaScript

#### Dependencies
- Phase 1 (Laravel project initialized)

#### Expected Results
- ✅ All customer pages built with responsive design
- ✅ Consistent premium visual identity
- ✅ Mobile, tablet, and desktop layouts working
- ✅ Smooth navigation between pages
- ✅ Professional appearance

#### Testing Checklist
- [ ] All pages load without errors
- [ ] Responsive design works on mobile (375px), tablet (768px), desktop (1920px)
- [ ] Navigation works on all pages
- [ ] Footer displays correctly
- [ ] Images load properly
- [ ] Forms render correctly
- [ ] No console errors

#### Definition of Done
- All pages created and styled
- Responsive design verified
- Components reusable and consistent
- No CSS conflicts
- Ready for backend integration

---

### PHASE 3: DATABASE DESIGN AND BACKEND ARCHITECTURE
**Duration:** 2-3 days  
**Status:** ⏳ PENDING

#### Objective
- Design comprehensive database schema
- Create all necessary tables and relationships
- Establish Eloquent models
- Define business logic structure

#### Tasks
- [ ] Design database schema (ER diagram)
- [ ] Create `users` table migration (admin users)
- [ ] Create `room_types` table migration
- [ ] Create `rooms` table migration
- [ ] Create `room_images` table migration
- [ ] Create `amenities` table migration
- [ ] Create `amenity_room_type` pivot table
- [ ] Create `enquiries` table migration
- [ ] Create `gallery` table migration
- [ ] Create `hotel_settings` table migration
- [ ] Create Eloquent models for each table
- [ ] Define model relationships
- [ ] Create database seeders for initial data
- [ ] Add indexes for performance optimization

#### Files to Create/Modify
- `database/migrations/` - All migration files
- `app/Models/User.php` - User model
- `app/Models/RoomType.php` - Room type model
- `app/Models/Room.php` - Room model
- `app/Models/RoomImage.php` - Room image model
- `app/Models/Amenity.php` - Amenity model
- `app/Models/Enquiry.php` - Enquiry model
- `app/Models/Gallery.php` - Gallery model
- `app/Models/HotelSettings.php` - Settings model
- `database/seeders/` - Database seeders

#### Dependencies
- Phase 1 (Laravel project initialized)

#### Expected Results
- ✅ All database tables created
- ✅ Proper foreign key relationships
- ✅ Models defined with relationships
- ✅ Database seeded with initial data
- ✅ No migration errors

#### Testing Checklist
- [ ] All migrations run successfully
- [ ] All tables created in database
- [ ] Foreign keys work correctly
- [ ] Model relationships work
- [ ] Seeders populate data
- [ ] No constraint violations

#### Definition of Done
- Database schema complete
- All migrations working
- Models and relationships defined
- Ready for API/controller development

---

### PHASE 4: AUTHENTICATION AND ADMIN DASHBOARD
**Duration:** 2-3 days  
**Status:** ✅ COMPLETED

#### Objective
- Implement admin authentication
- Create secure admin panel
- Build dashboard with key metrics
- Establish admin middleware and authorization

#### Tasks
- [x] Create admin login page
- [x] Implement admin authentication (Laravel Auth)
- [x] Create admin dashboard page
- [x] Build admin navigation/sidebar
- [x] Create admin layout template
- [x] Implement authentication middleware
- [x] Set up session management
- [x] Create login/logout routes
- [x] Add password hashing and security
- [x] Create admin profile page
- [x] Implement "Remember Me" functionality
- [x] Add admin user creation seeder

#### Files to Create/Modify
- ✅ `app/Http/Controllers/Admin/AuthController.php`
- ✅ `app/Http/Controllers/Admin/DashboardController.php`
- ✅ `app/Http/Middleware/AdminAuthenticate.php`
- ✅ `routes/web.php` - Admin routes (11 routes)
- ✅ `resources/views/admin/layouts/app.blade.php`
- ✅ `resources/views/admin/auth/login.blade.php`
- ✅ `resources/views/admin/dashboard.blade.php`
- ✅ `resources/views/admin/profile/show.blade.php`
- ✅ `resources/views/admin/enquiries/` - Placeholder pages
- ✅ `resources/views/admin/rooms/` - Placeholder pages
- ✅ `resources/views/admin/room-types/` - Placeholder pages
- ✅ `resources/views/admin/settings/` - Placeholder pages
- ✅ `bootstrap/app.php` - Middleware registration

#### Dependencies
- Phase 1 (Laravel project)
- Phase 3 (Database schema with users table)

#### Expected Results
- ✅ Secure admin login page
- ✅ Session-based authentication working
- ✅ Admin dashboard accessible only to logged-in users
- ✅ Logout functionality working
- ✅ Professional admin interface

#### Testing Checklist
- [x] Login with correct credentials works
- [x] Login with wrong credentials fails
- [x] Admin pages protected from public access
- [x] Logout clears session
- [x] Remember Me functionality works
- [x] Dashboard displays statistics

#### Definition of Done
- ✅ Admin authentication complete
- ✅ Admin dashboard functional
- ✅ All admin routes protected
- ✅ Ready for admin features

---

### PHASE 5: ROOM AND CATEGORY MANAGEMENT
**Duration:** 2-3 days  
**Status:** ✅ COMPLETED

#### Objective
- Implement room category management
- Create room inventory system
- Build room image upload functionality
- Enable admin control over room information

#### Tasks
- [x] Create RoomTypeController
- [x] Create RoomController
- [x] Build room type CRUD pages (Create, Read, Update, Delete)
- [x] Build room management pages
- [x] Implement room image upload
- [x] Create image storage configuration
- [x] Add room image deletion
- [x] Build admin room listing page
- [x] Create room form validation
- [x] Implement file upload validation
- [x] Create image thumbnail generation
- [x] Add room availability status toggle

#### Files to Create/Modify
- ✅ `app/Http/Controllers/Admin/RoomTypeController.php`
- ✅ `app/Http/Controllers/Admin/RoomController.php`
- ✅ `resources/views/admin/room-types/` - Room type pages (3 views)
- ✅ `resources/views/admin/rooms/` - Room management pages (3 views)
- ✅ `routes/web.php` - Added 17 routes
- ✅ `app/Models/RoomType.php` - Updated fillable fields
- ✅ Storage symlink configured

#### Dependencies
- Phase 3 (Database schema)
- Phase 4 (Admin authentication)

#### Expected Results
- ✅ Room types manageable via admin
- ✅ Rooms with images uploadable
- ✅ Inventory tracking working
- ✅ Images stored securely
- ✅ Room information displayable on frontend

#### Testing Checklist
- [x] Add room type works
- [x] Edit room type works
- [x] Delete room type works
- [x] Add room works
- [x] Upload room images works
- [x] Images display correctly
- [x] Room inventory updates work
- [x] Form validation works

#### Definition of Done
- ✅ Full room management system working
- ✅ Images uploaded and stored
- ✅ Room data accessible from database
- ✅ Ready for frontend room display

---

### PHASE 6: ROOM BROWSING AND BASIC FRONTEND
**Duration:** 2-3 days  
**Status:** ✅ COMPLETED

#### Objective
- Implement customer-facing room browsing pages
- Display room categories and details
- Create room detail pages
- Build gallery and amenities pages

#### Tasks
- [x] Create room listing page
- [x] Build room detail page
- [x] Implement room image gallery
- [x] Display room amenities
- [x] Create pricing display
- [x] Build responsive layouts

#### Files Created/Modified
- ✅ `resources/views/pages/rooms.blade.php`
- ✅ `resources/views/pages/room-detail.blade.php`
- ✅ `app/Http/Controllers/PageController.php`
- ✅ `routes/web.php` - Room browsing routes

#### Dependencies
- Phase 2 (Frontend pages) ✅
- Phase 3 (Database with room tables) ✅
- Phase 5 (Room management) ✅

#### Expected Results
- ✅ Customers can browse room categories
- ✅ Room details and images display correctly
- ✅ Pricing information visible
- ✅ Amenities listed
- ✅ Responsive design working

#### Definition of Done
- ✅ Room browsing pages functional
- ✅ Room details accessible
- ✅ Ready for booking system integration

---

### PHASE 7: WEBSITE SETTINGS AND ADMIN MANAGEMENT
**Duration:** 2 days  
**Status:** ✅ COMPLETED

#### Objective
- Implement website settings/configuration panel
- Enable dynamic hotel information updates
- Build gallery and amenities management

#### Tasks
- [x] Create HotelSettingsController
- [x] Build website settings page
- [x] Implement hotel contact information editor
- [x] Build amenities management
- [x] Implement gallery management (upload/delete)
- [x] Create settings validation

#### Files Created/Modified
- ✅ `app/Http/Controllers/Admin/SettingsController.php`
- ✅ `app/Http/Controllers/Admin/GalleryController.php`
- ✅ `app/Http/Controllers/Admin/AmenityController.php`
- ✅ `resources/views/admin/settings/` - Settings pages
- ✅ `resources/views/admin/gallery/` - Gallery pages
- ✅ `app/Services/SettingsService.php`

#### Dependencies
- Phase 4 (Admin authentication) ✅

#### Expected Results
- ✅ Settings dynamically configurable
- ✅ Hotel contact information updatable
- ✅ Gallery management working
- ✅ Amenities manageable

#### Definition of Done
- ✅ Website settings fully configurable
- ✅ All dynamic content manageable
- ✅ Ready for booking system

---

### PHASE 8: DIRECT ONLINE BOOKING SYSTEM
**Duration:** 10-12 days (6 sub-phases)  
**Status:** ⏳ PENDING (DOCUMENTATION COMPLETE - AWAITING IMPLEMENTATION APPROVAL)

#### Overview
Complete replacement of enquiry-based workflow with **Direct Online Room Booking System**. Customers can search available rooms, book directly, verify mobile via OTP, pay through Razorpay, and manage bookings without mandatory registration.

#### Business Requirements
- **Direct Online Booking** - No manual admin approval for normal bookings
- **OTP Verification** - Mobile number verification without passwords
- **Real-Time Availability** - Category-wise and date-wise checking
- **100% Full Payment** - Integrated Razorpay checkout
- **Automatic Confirmation** - Instant booking confirmation after payment
- **Customer Self-Service** - Manage bookings via OTP verification
- **24-Hour Refund Policy** - Customer-initiated cancellations
- **Overbooking Prevention** - Database transactions with row-level locking

---

### PHASE 8A: ROOM AVAILABILITY & CATEGORY INVENTORY
**Duration:** 2 days  
**Status:** ⏳ PENDING

#### Objective
- Implement category-wise room inventory architecture
- Build real-time availability calculation
- Prevent overbooking with database transactions
- Handle concurrent booking requests safely

#### Tasks
- [ ] Design category-wise inventory architecture
- [ ] Create database tables:
  - [ ] Update `bookings` table schema
  - [ ] Create `room_allocations` table
  - [ ] Create `temporary_reservations` table
- [ ] Build availability calculation service
- [ ] Implement date-range availability queries
- [ ] Create physical room allocation logic
- [ ] Implement database transaction strategy
- [ ] Add row-level locking (FOR UPDATE)
- [ ] Build concurrent booking prevention
- [ ] Create availability API endpoint
- [ ] Implement fresh availability checks in transactions
- [ ] Add overbooking prevention tests

#### Files to Create
- `database/migrations/YYYY_MM_DD_create_bookings_table.php`
- `database/migrations/YYYY_MM_DD_create_room_allocations_table.php`
- `database/migrations/YYYY_MM_DD_create_temporary_reservations_table.php`
- `app/Models/Booking.php`
- `app/Models/RoomAllocation.php`
- `app/Models/TemporaryReservation.php`
- `app/Services/RoomAvailabilityService.php`
- `app/Services/RoomAllocationService.php`
- `app/Http/Controllers/AvailabilityController.php`

#### Database Schema to Implement

**`bookings` Table:**
```sql
- id (primary key)
- booking_reference (unique)
- customer_name
- customer_mobile (indexed)
- customer_email
- room_type_id (foreign key)
- check_in_date (indexed)
- check_out_date (indexed)
- num_adults
- num_children
- room_quantity
- base_amount (server-calculated)
- tax_amount (server-calculated)
- total_amount (server-calculated)
- razorpay_order_id (unique)
- razorpay_payment_id (unique)
- booking_status (enum: confirmed, cancelled, checked_in, checked_out)
- payment_status (enum: paid, refunded, partially_refunded)
- cancelled_at
- cancellation_reason
- created_at, updated_at, deleted_at
```

**`room_allocations` Table:**
```sql
- id (primary key)
- booking_id (foreign key)
- room_id (foreign key to physical rooms)
- check_in_date (indexed)
- check_out_date (indexed)
- allocation_status (enum: temporary, confirmed, released)
- allocated_at
- released_at
- created_at, updated_at
```

**`temporary_reservations` Table:**
```sql
- id (primary key)
- reservation_token (unique)
- customer_mobile (indexed)
- room_type_id (foreign key)
- room_quantity
- check_in_date
- check_out_date
- total_amount
- razorpay_order_id
- expires_at (indexed)
- status (enum: active, expired, converted, released)
- created_at, updated_at
```

#### Availability Calculation Logic
- Query available rooms per category
- Exclude overlapping bookings (check-out date exclusive)
- Exclude temporary reservations (not expired)
- Check room allocation conflicts
- Return available quantity per category
- Include pricing information

#### Concurrency Strategy
```php
DB::transaction(function () {
    // Lock room_types row
    $roomType = RoomType::where('id', $categoryId)
        ->lockForUpdate()
        ->first();
    
    // Fresh availability check inside transaction
    $available = $this->checkAvailability($categoryId, $dates);
    
    if ($available >= $requested) {
        // Allocate rooms
        $this->allocateRooms($booking);
    } else {
        throw new InsufficientAvailabilityException();
    }
});
```

#### Dependencies
- Phase 3 (Database) ✅
- Phase 5 (Room management) ✅

#### Expected Results
- ✅ Real-time category-wise availability
- ✅ Date-range availability queries working
- ✅ Overbooking prevented via transactions
- ✅ Concurrent requests handled safely
- ✅ Physical room allocation working

#### Testing Checklist
- [ ] Single booking creates allocation
- [ ] Overlapping bookings prevented
- [ ] Concurrent booking requests handled
- [ ] Expired reservations released
- [ ] Availability reflects temporary reservations
- [ ] Transaction rollback on errors
- [ ] Deadlock scenarios handled

#### Definition of Done
- Availability calculation accurate
- Overbooking prevention verified
- Concurrent booking tests passing
- Ready for OTP integration

---

### PHASE 8B: OTP-BASED CUSTOMER VERIFICATION
**Duration:** 2 days  
**Status:** ⏳ PENDING

#### Objective
- Implement OTP-based mobile verification
- No mandatory password or permanent account
- Secure customer identity without signup
- Enable booking management via OTP

#### Tasks
- [ ] Choose and configure SMS provider (pending client decision)
- [ ] Create database table:
  - [ ] Create `otp_verifications` table
- [ ] Build OTP generation service
- [ ] Implement OTP hashing (bcrypt)
- [ ] Create SMS sending service
- [ ] Build OTP verification service
- [ ] Implement OTP expiry logic
- [ ] Add attempt limiting (max 3-5 attempts)
- [ ] Create resend throttling
- [ ] Implement rate limiting per mobile
- [ ] Build OTP validation endpoint
- [ ] Create OTP resend endpoint
- [ ] Add security logging
- [ ] Implement single-use OTP validation
- [ ] Build session management after verification

#### Files to Create
- `database/migrations/YYYY_MM_DD_create_otp_verifications_table.php`
- `app/Models/OtpVerification.php`
- `app/Services/OtpService.php`
- `app/Services/SmsService.php` (interface for SMS providers)
- `app/Services/Sms/TwilioSmsService.php` (example implementation)
- `app/Http/Controllers/OtpController.php`
- `app/Http/Requests/SendOtpRequest.php`
- `app/Http/Requests/VerifyOtpRequest.php`
- `config/sms.php`

#### Database Schema to Implement

**`otp_verifications` Table:**
```sql
- id (primary key)
- mobile_number (indexed)
- otp_hash (bcrypt)
- purpose (enum: booking, manage_bookings)
- expires_at (indexed)
- verified (boolean, default false)
- attempt_count (default 0)
- last_attempt_at
- created_at, updated_at
```

#### OTP Security Requirements
- Generate 6-digit OTP on backend
- Hash with bcrypt before storing
- Never log or expose OTP in responses
- Configurable expiry (default: 5 minutes)
- Max 3-5 verification attempts
- Rate limit: 3 OTPs per mobile per 15 minutes
- Single-use: invalidate after successful verification
- Auto-expire after time limit

#### OTP Service Implementation
```php
public function generateOtp(string $mobile, string $purpose): void
{
    // Rate limit check
    $this->checkRateLimit($mobile);
    
    // Generate 6-digit OTP
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    
    // Hash OTP
    $hash = Hash::make($otp);
    
    // Store in database
    OtpVerification::create([
        'mobile_number' => $mobile,
        'otp_hash' => $hash,
        'purpose' => $purpose,
        'expires_at' => now()->addMinutes(config('otp.expiry', 5)),
    ]);
    
    // Send SMS
    $this->smsService->send($mobile, "Your OTP is: {$otp}");
}
```

#### Configuration (Pending Client Approval)
```env
SMS_PROVIDER=twilio  # Or msg91, textlocal, etc.
SMS_API_KEY=xxxxx
SMS_API_SECRET=xxxxx
OTP_EXPIRY_MINUTES=5
OTP_RESEND_LIMIT=3
OTP_RESEND_WINDOW_MINUTES=15
OTP_MAX_ATTEMPTS=5
```

#### Dependencies
- SMS provider account (pending client decision)

#### Expected Results
- ✅ OTP generated securely
- ✅ SMS sent to customer mobile
- ✅ OTP verified correctly
- ✅ Attempt limiting working
- ✅ Rate limiting functional
- ✅ Resend throttling active
- ✅ Sessions created after verification

#### Testing Checklist
- [ ] OTP generation creates valid code
- [ ] SMS sent successfully
- [ ] Correct OTP verification succeeds
- [ ] Incorrect OTP verification fails
- [ ] Expired OTP rejected
- [ ] Attempt limit enforced
- [ ] Rate limit prevents spam
- [ ] Resend respects throttling
- [ ] Single-use validation works

#### Definition of Done
- OTP generation and verification working
- SMS integration functional
- Security measures implemented
- Rate limiting active
- Ready for booking integration

---

### PHASE 8C: DIRECT BOOKING FLOW
**Duration:** 2-3 days  
**Status:** ⏳ PENDING

#### Objective
- Build customer-facing booking form
- Implement temporary room reservation
- Calculate pricing server-side
- Create Razorpay order
- Integrate payment checkout

#### Tasks
- [ ] Build room search interface
- [ ] Create availability search endpoint
- [ ] Build booking form UI
- [ ] Implement booking form validation
- [ ] Create temporary reservation logic
- [ ] Build pricing calculation service (server-side)
- [ ] Implement tax calculation
- [ ] Create booking controller
- [ ] Build Razorpay order creation
- [ ] Integrate Razorpay Checkout
- [ ] Implement reservation expiry handling
- [ ] Create payment timeout handling
- [ ] Build booking summary display
- [ ] Add loading and error states

#### Files to Create
- `app/Http/Controllers/BookingController.php`
- `app/Services/PricingService.php`
- `app/Services/TemporaryReservationService.php`
- `app/Services/RazorpayService.php`
- `app/Http/Requests/CreateBookingRequest.php`
- `resources/views/booking/search.blade.php`
- `resources/views/booking/form.blade.php`
- `resources/views/booking/summary.blade.php`
- `resources/js/booking.js`
- `resources/js/razorpay-checkout.js`
- `config/razorpay.php`

#### Booking Workflow
1. Customer searches rooms (dates, guests, category)
2. System displays available categories with prices
3. Customer selects category and quantity
4. Customer enters personal details
5. Customer verifies mobile via OTP
6. System calculates total amount (server-side)
7. System creates temporary reservation
8. System creates Razorpay order
9. Customer proceeds to Razorpay Checkout
10. Payment screen displays

#### Temporary Reservation Logic
```php
public function createTemporaryReservation($data): TemporaryReservation
{
    return DB::transaction(function () use ($data) {
        // Check fresh availability
        $available = $this->checkAvailability($data);
        
        if (!$available) {
            throw new InsufficientAvailabilityException();
        }
        
        // Create temporary reservation
        $reservation = TemporaryReservation::create([
            'reservation_token' => Str::uuid(),
            'customer_mobile' => $data['mobile'],
            'room_type_id' => $data['room_type_id'],
            'room_quantity' => $data['quantity'],
            'check_in_date' => $data['check_in'],
            'check_out_date' => $data['check_out'],
            'total_amount' => $this->calculateAmount($data),
            'expires_at' => now()->addMinutes(config('booking.reservation_timeout', 15)),
            'status' => 'active',
        ]);
        
        // Allocate specific rooms temporarily
        $this->allocateTemporaryRooms($reservation);
        
        return $reservation;
    });
}
```

#### Server-Side Pricing
```php
public function calculateBookingAmount($data): array
{
    $roomType = RoomType::findOrFail($data['room_type_id']);
    
    // Calculate nights
    $checkIn = Carbon::parse($data['check_in']);
    $checkOut = Carbon::parse($data['check_out']);
    $nights = $checkOut->diffInDays($checkIn);
    
    // Calculate base amount
    $baseRate = $roomType->base_price;
    $quantity = $data['quantity'];
    $baseAmount = $baseRate * $nights * $quantity;
    
    // Calculate tax (configurable)
    $taxPercent = config('pricing.gst_percent', 12);
    $taxAmount = ($baseAmount * $taxPercent) / 100;
    
    // Total
    $totalAmount = $baseAmount + $taxAmount;
    
    return [
        'base_amount' => round($baseAmount, 2),
        'tax_amount' => round($taxAmount, 2),
        'total_amount' => round($totalAmount, 2),
        'nights' => $nights,
        'rate_per_night' => $baseRate,
    ];
}
```

#### Razorpay Order Creation
```php
public function createRazorpayOrder($reservation): array
{
    $order = $this->razorpay->order->create([
        'amount' => $reservation->total_amount * 100, // Paise
        'currency' => 'INR',
        'receipt' => 'res_' . $reservation->id,
        'notes' => [
            'reservation_id' => $reservation->id,
            'customer_mobile' => $reservation->customer_mobile,
        ]
    ]);
    
    // Update reservation with order ID
    $reservation->update([
        'razorpay_order_id' => $order['id']
    ]);
    
    return $order;
}
```

#### Configuration (Pending Client Approval)
```env
RAZORPAY_KEY_ID=rzp_test_xxxxx
RAZORPAY_KEY_SECRET=xxxxx
RAZORPAY_WEBHOOK_SECRET=whsec_xxxxx
BOOKING_RESERVATION_TIMEOUT_MINUTES=15
PRICING_GST_PERCENT=12
PRICING_SERVICE_FEE_PERCENT=0
```

#### Dependencies
- Phase 8A (Availability) ✅
- Phase 8B (OTP) ✅
- Razorpay account setup

#### Expected Results
- ✅ Room search working
- ✅ Booking form functional
- ✅ OTP verification integrated
- ✅ Temporary reservations created
- ✅ Server-side pricing accurate
- ✅ Razorpay order created
- ✅ Checkout modal displays

#### Testing Checklist
- [ ] Search returns available rooms
- [ ] Booking form validation works
- [ ] OTP verification required
- [ ] Temporary reservation created
- [ ] Pricing calculated correctly
- [ ] Tax calculation accurate
- [ ] Razorpay order created
- [ ] Expired reservations handled

#### Definition of Done
- Complete booking flow working
- Temporary reservations functional
- Pricing accurate
- Razorpay integration ready
- Ready for payment verification

---

### PHASE 8D: PAYMENT VERIFICATION & CONFIRMATION
**Duration:** 2 days  
**Status:** ⏳ PENDING

#### Objective
- Verify Razorpay payment signatures
- Handle webhook events
- Confirm bookings automatically
- Finalize room allocations
- Send booking confirmations

#### Tasks
- [ ] Build payment signature verification
- [ ] Implement payment callback handling
- [ ] Create webhook endpoint
- [ ] Build webhook signature verification
- [ ] Implement idempotent webhook processing
- [ ] Create booking confirmation logic
- [ ] Convert temporary to confirmed allocations
- [ ] Release expired reservations
- [ ] Create payment record
- [ ] Build booking confirmation page
- [ ] Implement confirmation email (optional)
- [ ] Add failure handling
- [ ] Create payment status tracking

#### Files to Create
- `app/Http/Controllers/PaymentController.php`
- `app/Http/Controllers/WebhookController.php`
- `app/Services/PaymentVerificationService.php`
- `app/Services/BookingConfirmationService.php`
- `app/Models/Payment.php`
- `database/migrations/YYYY_MM_DD_create_payments_table.php`
- `database/migrations/YYYY_MM_DD_create_webhook_events_table.php`
- `resources/views/booking/confirmation.blade.php`
- `resources/views/booking/payment-failed.blade.php`

#### Payment Signature Verification
```php
public function verifyPaymentSignature($orderId, $paymentId, $signature): bool
{
    $secret = config('razorpay.key_secret');
    $payload = $orderId . '|' . $paymentId;
    $expectedSignature = hash_hmac('sha256', $payload, $secret);
    
    return hash_equals($expectedSignature, $signature);
}
```

#### Booking Confirmation Logic
```php
public function confirmBooking($reservation, $payment): Booking
{
    return DB::transaction(function () use ($reservation, $payment) {
        // Create confirmed booking
        $booking = Booking::create([
            'booking_reference' => $this->generateReference(),
            'customer_name' => $reservation->customer_name,
            'customer_mobile' => $reservation->customer_mobile,
            'customer_email' => $reservation->customer_email,
            'room_type_id' => $reservation->room_type_id,
            'check_in_date' => $reservation->check_in_date,
            'check_out_date' => $reservation->check_out_date,
            'num_adults' => $reservation->num_adults,
            'num_children' => $reservation->num_children,
            'room_quantity' => $reservation->room_quantity,
            'total_amount' => $reservation->total_amount,
            'razorpay_order_id' => $payment->razorpay_order_id,
            'razorpay_payment_id' => $payment->razorpay_payment_id,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);
        
        // Convert temporary allocations to confirmed
        $this->confirmRoomAllocations($reservation, $booking);
        
        // Mark reservation as converted
        $reservation->update(['status' => 'converted']);
        
        return $booking;
    });
}
```

#### Webhook Idempotency
```php
public function handleWebhook(Request $request): Response
{
    // Verify signature
    if (!$this->verifyWebhookSignature($request)) {
        return response()->json(['error' => 'Invalid signature'], 400);
    }
    
    $payload = $request->all();
    $eventId = $payload['id'];
    
    // Check for duplicate
    if (WebhookEvent::where('razorpay_event_id', $eventId)->exists()) {
        return response()->json(['message' => 'Event already processed'], 200);
    }
    
    // Process webhook
    DB::transaction(function () use ($payload, $eventId) {
        WebhookEvent::create([
            'razorpay_event_id' => $eventId,
            'event_type' => $payload['event'],
            'payload' => json_encode($payload),
            'processed_at' => now(),
        ]);
        
        $this->processWebhookEvent($payload);
    });
    
    return response()->json(['message' => 'Success'], 200);
}
```

#### Dependencies
- Phase 8C (Booking flow) ✅
- Razorpay webhook configuration

#### Expected Results
- ✅ Payment signatures verified
- ✅ Webhooks processed correctly
- ✅ Bookings confirmed automatically
- ✅ Room allocations finalized
- ✅ Confirmation displayed
- ✅ Duplicate payments prevented

#### Testing Checklist
- [ ] Signature verification works
- [ ] Payment callback handled
- [ ] Webhook signature verified
- [ ] Duplicate webhooks ignored
- [ ] Booking confirmed correctly
- [ ] Room allocations updated
- [ ] Confirmation page displays
- [ ] Payment failures handled

#### Definition of Done
- Payment verification complete
- Booking confirmation automatic
- Webhook processing working
- Ready for customer management

---

### PHASE 8E: CUSTOMER BOOKING MANAGEMENT
**Duration:** 2 days  
**Status:** ⏳ PENDING

#### Objective
- Build "My Bookings" feature
- Enable OTP-based booking access
- Display booking history
- Show booking details
- Enable cancellation requests
- Protect against unauthorized access

#### Tasks
- [ ] Build "My Bookings" interface
- [ ] Create OTP-based booking access
- [ ] Implement session management
- [ ] Build booking list display
- [ ] Create booking details page
- [ ] Implement authorization checks
- [ ] Add IDOR protection
- [ ] Build booking search by mobile
- [ ] Create payment status display
- [ ] Build refund status display
- [ ] Implement session expiry
- [ ] Add logout functionality

#### Files to Create
- `app/Http/Controllers/CustomerBookingController.php`
- `app/Http/Middleware/VerifyCustomerSession.php`
- `app/Services/CustomerAuthService.php`
- `resources/views/customer/login.blade.php`
- `resources/views/customer/bookings/index.blade.php`
- `resources/views/customer/bookings/show.blade.php`
- `routes/customer.php` (included in web.php)

#### OTP-Based Booking Access
```php
public function requestAccess(Request $request)
{
    $mobile = $request->input('mobile');
    
    // Generate and send OTP
    $this->otpService->generateOtp($mobile, 'manage_bookings');
    
    return view('customer.verify-otp', ['mobile' => $mobile]);
}

public function verifyAndAccess(Request $request)
{
    $mobile = $request->input('mobile');
    $otp = $request->input('otp');
    
    // Verify OTP
    if (!$this->otpService->verifyOtp($mobile, $otp, 'manage_bookings')) {
        return back()->withErrors(['otp' => 'Invalid or expired OTP']);
    }
    
    // Create secure session
    session([
        'customer_mobile' => $mobile,
        'customer_verified_at' => now(),
    ]);
    
    return redirect()->route('customer.bookings.index');
}
```

#### Authorization Protection
```php
public function show($bookingReference)
{
    $mobile = session('customer_mobile');
    
    // Verify session
    if (!$mobile || session('customer_verified_at')->lt(now()->subHours(2))) {
        return redirect()->route('customer.login');
    }
    
    // Find booking with authorization
    $booking = Booking::where('booking_reference', $bookingReference)
        ->where('customer_mobile', $mobile)
        ->firstOrFail();
    
    return view('customer.bookings.show', compact('booking'));
}
```

#### Dependencies
- Phase 8B (OTP) ✅
- Phase 8D (Bookings created) ✅

#### Expected Results
- ✅ "My Bookings" accessible via OTP
- ✅ Booking list displays correctly
- ✅ Booking details protected
- ✅ Authorization working
- ✅ IDOR prevented
- ✅ Session management functional

#### Testing Checklist
- [ ] OTP access works
- [ ] Booking list filtered by mobile
- [ ] Booking details display correctly
- [ ] Unauthorized access prevented
- [ ] Session expiry enforced
- [ ] IDOR attempts blocked
- [ ] Payment status visible
- [ ] Refund status visible

#### Definition of Done
- Customer booking management complete
- Authorization secure
- IDOR protection verified
- Ready for cancellation feature

---

### PHASE 8F: CANCELLATION & REFUND SYSTEM
**Duration:** 2 days  
**Status:** ⏳ PENDING

#### Objective
- Enable customer-initiated cancellations
- Calculate refunds automatically (24-hour policy)
- Process refunds via Razorpay API
- Track refund status
- Prevent duplicate refunds

#### Tasks
- [ ] Build cancellation interface
- [ ] Implement 24-hour refund calculation
- [ ] Create refund service
- [ ] Integrate Razorpay Refund API
- [ ] Build refund status tracking
- [ ] Implement original-payment refunds only
- [ ] Add duplicate refund prevention
- [ ] Create refund webhook handling
- [ ] Build refund status display
- [ ] Implement Asia/Kolkata timezone
- [ ] Add cancellation authorization
- [ ] Create admin refund management

#### Files to Create
- `app/Http/Controllers/CancellationController.php`
- `app/Services/RefundCalculationService.php`
- `app/Services/RefundProcessingService.php`
- `app/Models/Refund.php`
- `database/migrations/YYYY_MM_DD_create_refunds_table.php`
- `resources/views/customer/bookings/cancel.blade.php`
- `resources/views/customer/bookings/refund-status.blade.php`

#### 24-Hour Refund Policy
```php
public function calculateRefund(Booking $booking): array
{
    $timezone = 'Asia/Kolkata';
    $now = now()->setTimezone($timezone);
    
    // Check-in time (configurable, default 12:00 PM)
    $checkInTime = Carbon::parse($booking->check_in_date)
        ->setTimezone($timezone)
        ->setTime(config('hotel.checkin_hour', 12), 0, 0);
    
    $hoursBeforeCheckIn = $checkInTime->diffInHours($now, false);
    
    if ($hoursBeforeCheckIn >= 24) {
        // 100% refund
        return [
            'refund_percent' => 100,
            'refund_amount' => $booking->total_amount,
            'policy' => 'full_refund',
        ];
    } elseif ($hoursBeforeCheckIn >= 0) {
        // 50% refund
        return [
            'refund_percent' => 50,
            'refund_amount' => $booking->total_amount * 0.50,
            'policy' => 'partial_refund',
        ];
    } else {
        // No refund (after check-in)
        return [
            'refund_percent' => 0,
            'refund_amount' => 0,
            'policy' => 'no_refund',
        ];
    }
}
```

#### Original-Payment Refund
```php
public function processRefund(Booking $booking, array $refundData): Refund
{
    return DB::transaction(function () use ($booking, $refundData) {
        // Retrieve original payment from database
        $payment = Payment::where('booking_id', $booking->id)
            ->where('status', 'captured')
            ->firstOrFail();
        
        // Create refund via Razorpay API
        $razorpayRefund = $this->razorpay->payment->fetch($payment->razorpay_payment_id)
            ->refund([
                'amount' => $refundData['refund_amount'] * 100,
                'notes' => [
                    'booking_reference' => $booking->booking_reference,
                    'refund_policy' => $refundData['policy'],
                ],
            ]);
        
        // Create refund record
        $refund = Refund::create([
            'booking_id' => $booking->id,
            'payment_id' => $payment->id,
            'razorpay_refund_id' => $razorpayRefund['id'],
            'refund_amount' => $refundData['refund_amount'],
            'refund_percent' => $refundData['refund_percent'],
            'policy_applied' => $refundData['policy'],
            'status' => 'processing',
        ]);
        
        // Update booking
        $booking->update([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
        
        return $refund;
    });
}
```

#### Configuration (Pending Client Approval)
```env
HOTEL_CHECKIN_TIME=12:00
TIMEZONE=Asia/Kolkata
REFUND_POLICY_24H_PERCENT=100
REFUND_POLICY_LESS_24H_PERCENT=50
```

#### Dependencies
- Phase 8D (Payments) ✅
- Phase 8E (Customer management) ✅

#### Expected Results
- ✅ Customer can request cancellation
- ✅ Refund calculated automatically
- ✅ 24-hour policy enforced
- ✅ Refund processed via Razorpay
- ✅ Original payment refunded
- ✅ Status tracked correctly
- ✅ Duplicate refunds prevented

#### Testing Checklist
- [ ] Cancellation request works
- [ ] Refund calculation accurate
- [ ] 100% refund for ≥24h
- [ ] 50% refund for <24h
- [ ] 0% refund after check-in
- [ ] Razorpay refund created
- [ ] Original payment refunded
- [ ] Duplicate refunds blocked
- [ ] Status updates correct
- [ ] Authorization enforced

#### Definition of Done
- Cancellation system complete
- Refund calculation accurate
- Razorpay integration working
- Status tracking functional
- Phase 8 complete

---

### PHASE 8 SUMMARY

**Total Duration:** 10-12 days  
**Sub-Phases:** 6 (8A through 8F)  
**Status:** ⏳ DOCUMENTATION COMPLETE - AWAITING IMPLEMENTATION APPROVAL

**What Phase 8 Delivers:**
- ✅ Direct online room booking (no manual approval)
- ✅ OTP-based customer verification (no passwords)
- ✅ Real-time room availability
- ✅ Category-wise inventory management
- ✅ Overbooking prevention
- ✅ 100% online payment via Razorpay
- ✅ Automatic booking confirmation
- ✅ Customer self-service booking management
- ✅ 24-hour cancellation policy
- ✅ Automatic refund processing
- ✅ Complete security architecture

**Key Changes from Previous Phase 8:**
- ❌ REMOVED: WhatsApp payment link workflow
- ❌ REMOVED: Manual admin approval for every booking
- ❌ REMOVED: Enquiry-to-booking conversion
- ✅ ADDED: Direct online booking
- ✅ ADDED: OTP verification
- ✅ ADDED: Automatic confirmation
- ✅ ADDED: Customer booking management
- ✅ ADDED: Category-wise inventory

---

### PHASE 9: TESTING, SECURITY AND OPTIMIZATION
**Duration:** 2-3 days  
**Status:** ⏳ PENDING

#### Objective
- Comprehensive security testing (including OTP, booking, and payment security)
- Performance optimization
- Bug fixing and quality assurance
- Accessibility compliance
- Direct booking flow testing and validation

#### Tasks
- [ ] Test OTP generation and verification end-to-end
- [ ] Test SMS provider integration
- [ ] Verify OTP security (hashing, expiry, rate limiting)
- [ ] Test room availability calculation accuracy
- [ ] Verify overbooking prevention (concurrent bookings)
- [ ] Test temporary reservation lifecycle
- [ ] Test Razorpay payment integration end-to-end
- [ ] Verify payment signature validation
- [ ] Test webhook processing and retry logic
- [ ] Validate refund calculations and processing
- [ ] Test customer booking management (OTP access)
- [ ] Verify IDOR protection
- [ ] Implement CSRF protection verification
- [ ] Add rate limiting validation
- [ ] Test input sanitization
- [ ] Verify SQL injection prevention
- [ ] Validate file upload security
- [ ] Test error handling and logging
- [ ] Performance testing (including booking and payment pages)
- [ ] Load testing for webhooks
- [ ] Browser compatibility testing
- [ ] Mobile responsiveness verification
- [ ] Accessibility testing (WCAG compliance)
- [ ] Security headers validation
- [ ] Create unit tests for booking logic
- [ ] Create unit tests for OTP logic
- [ ] Create integration tests for payment workflows

#### Files to Create/Modify
- `config/security.php` - Security configuration
- `tests/Feature/BookingTest.php` - Booking flow tests
- `tests/Feature/OtpTest.php` - OTP verification tests
- `tests/Feature/AvailabilityTest.php` - Availability tests
- `tests/Feature/PaymentTest.php` - Payment flow tests
- `tests/Feature/RefundTest.php` - Refund workflow tests
- `tests/Unit/RazorpayServiceTest.php` - Payment service tests
- `tests/Unit/OtpServiceTest.php` - OTP service tests
- `tests/Unit/AvailabilityServiceTest.php` - Availability tests
- `.htaccess` or `web.config` - Security headers

#### Dependencies
- Phase 8 (Direct booking system complete)

#### Expected Results
- ✅ All booking flows tested and verified
- ✅ OTP system secure and functional
- ✅ Room availability accurate
- ✅ Overbooking prevention working
- ✅ Payment flows verified
- ✅ No known security vulnerabilities
- ✅ All forms protected
- ✅ Error handling comprehensive
- ✅ Performance optimized
- ✅ Accessible to users with disabilities

#### Testing Checklist
- [ ] All PHPUnit tests pass
- [ ] OTP generation and verification tested
- [ ] SMS sending works (test mode)
- [ ] Rate limiting prevents OTP spam
- [ ] Availability calculation accurate
- [ ] Concurrent booking tests pass
- [ ] Temporary reservations expire correctly
- [ ] Payment signature verification tested
- [ ] Webhook processing validated
- [ ] Refund calculations verified
- [ ] Customer booking access secure
- [ ] IDOR protection works
- [ ] No SQL injection vulnerabilities
- [ ] All forms CSRF protected
- [ ] File uploads validated
- [ ] Error pages show gracefully
- [ ] Performance acceptable
- [ ] Mobile responsive
- [ ] Accessibility score good

#### Definition of Done
- All tests passing
- Security vulnerabilities fixed
- Performance optimized
- Booking and payment flows validated
- OTP system functional
- Production-ready code

---

### PHASE 10: PRODUCTION DEPLOYMENT
**Duration:** 1-2 days  
**Status:** ⏳ PENDING

#### Objective
- Deploy to production server
- Configure SMS/OTP provider
- Configure Razorpay production credentials
- Set up monitoring and alerts
- Create maintenance procedures
- Document deployment process

#### Tasks
- [ ] Configure production .env with all required keys
- [ ] Set up SMS provider account (client decision: Twilio, MSG91, etc.)
- [ ] Configure SMS API credentials
- [ ] Configure Razorpay production keys
- [ ] Set up production database
- [ ] Configure web server (Apache/Nginx)
- [ ] Set up SSL/HTTPS certificate (required for Razorpay)
- [ ] Configure Razorpay webhook URL
- [ ] Verify Razorpay production account setup
- [ ] Configure email service (optional)
- [ ] Set up database backups
- [ ] Configure error logging
- [ ] Set up booking monitoring/alerts
- [ ] Set up payment monitoring/alerts
- [ ] Set up OTP monitoring (SMS delivery)
- [ ] Create maintenance documentation
- [ ] Document deployment procedures
- [ ] Set up version control workflow
- [ ] Create rollback procedures
- [ ] Test OTP delivery in production
- [ ] Test booking flow in production
- [ ] Test payment processing in production
- [ ] Verify webhook connectivity

#### Files to Create/Modify
- `.env.production` - Production configuration (SMS, Razorpay keys)
- `deployment.md` - Deployment guide (including SMS setup)
- `maintenance.md` - Maintenance guide
- `BOOKING_SYSTEM_SETUP.md` - Complete system setup guide
- `SMS_PROVIDER_SETUP.md` - SMS provider configuration

#### Configuration Required (Pending Client Decisions)
```env
# SMS/OTP Provider
SMS_PROVIDER=twilio  # Or msg91, textlocal, etc.
SMS_API_KEY=xxxxx
SMS_API_SECRET=xxxxx
SMS_FROM_NUMBER=xxxxx

# OTP Configuration
OTP_EXPIRY_MINUTES=5
OTP_RESEND_LIMIT=3
OTP_RESEND_WINDOW_MINUTES=15
OTP_MAX_ATTEMPTS=5

# Booking Configuration
RESERVATION_TIMEOUT_MINUTES=15
HOTEL_CHECKIN_TIME=12:00

# Pricing Configuration
TAX_GST_PERCENT=12
SERVICE_FEE_PERCENT=0

# Razorpay
RAZORPAY_KEY_ID=rzp_live_xxxxx
RAZORPAY_KEY_SECRET=xxxxx
RAZORPAY_WEBHOOK_SECRET=whsec_xxxxx

# Timezone
APP_TIMEZONE=Asia/Kolkata
```

#### Dependencies
- Phase 9 (Testing and optimization complete)
- SMS provider account setup (client decision)
- Razorpay production account approved
- SSL certificate installed
- Production server configured

#### Expected Results
- ✅ Website live and accessible via HTTPS
- ✅ SMS/OTP delivery working
- ✅ Direct booking system operational
- ✅ Room availability accurate
- ✅ Razorpay payment processing working
- ✅ Webhooks receiving events correctly
- ✅ Customer booking management functional
- ✅ Refund processing working
- ✅ Database backed up
- ✅ Monitoring active
- ✅ Ready for production traffic
- ✅ System security verified

#### Testing Checklist
- [ ] Website accessible from internet via HTTPS
- [ ] HTTPS certificate valid
- [ ] Database operations working
- [ ] OTP SMS delivery works
- [ ] Room search returns accurate results
- [ ] Booking creation successful
- [ ] Temporary reservations working
- [ ] Razorpay test payment successful
- [ ] Booking confirmation automatic
- [ ] Customer booking access works
- [ ] Cancellation and refund working
- [ ] Webhook endpoint accessible
- [ ] Error logging working
- [ ] Backups scheduled
- [ ] Admin panel accessible
- [ ] Monitoring active

#### Definition of Done
- Website live in production with HTTPS
- SMS/OTP delivery operational
- Direct booking system functional
- Payment processing operational
- All systems monitored
- Backup procedures active
- Documentation complete
- Ready for customer bookings

---

### Current Status: 🏨 PHASE 8 DOCUMENTATION COMPLETE - DIRECT BOOKING SYSTEM DOCUMENTED
- **Phase 1:** ✅ COMPLETED (Project Setup)
- **Phase 2:** ✅ COMPLETED (Premium Frontend UI)
- **Phase 3:** ✅ COMPLETED (Database Architecture)
- **Phase 4:** ✅ COMPLETED (Admin Authentication)
- **Phase 5:** ✅ COMPLETED (Room Management)
- **Phase 6:** ✅ COMPLETED (Room Browsing & Basic Frontend)
- **Phase 7:** ✅ COMPLETED (Website Settings & Admin Management)
- **Phase 8:** 📄 **DOCUMENTATION COMPLETE** (Direct Online Booking System - Ready for Implementation)
  - Phase 8A: Room Availability & Category Inventory - Documented
  - Phase 8B: OTP-Based Customer Verification - Documented
  - Phase 8C: Direct Booking Flow - Documented
  - Phase 8D: Payment Verification & Confirmation - Documented
  - Phase 8E: Customer Booking Management - Documented
  - Phase 8F: Cancellation & Refund System - Documented
- **Phase 9:** ⏳ Not Started (Testing & Security)
- **Phase 10:** ⏳ Not Started (Production Deployment)

### Completed Tasks
- ✅ Project requirements defined
- ✅ Technology stack selected
- ✅ Development roadmap created
- ✅ Phase structure documented
- ✅ Environment verified (PHP 8.2, Composer, Node.js ready)
- ✅ **Laravel 12 project created**
- ✅ **MySQL database configured**
- ✅ **All 10+ database tables created**
- ✅ **All 9+ Eloquent models created**
- ✅ **Database seeders executed**
- ✅ **Git repository initialized and committed**
- ✅ **Complete frontend UI developed**
- ✅ **All 10 customer pages created**
- ✅ **Responsive design implemented**
- ✅ **Bootstrap 5 integrated**
- ✅ **Custom CSS with luxury aesthetic**
- ✅ **Customer enquiry system complete**
- ✅ **WhatsApp integration working**
- ✅ **Admin authentication implemented**
- ✅ **Admin dashboard with statistics**
- ✅ **Admin layout and navigation**
- ✅ **Profile management**
- ✅ **11 admin routes protected**
- ✅ **Room type CRUD complete**
- ✅ **Room CRUD complete**
- ✅ **Image upload system working**
- ✅ **17 room management routes**
- ✅ **Enquiry management system complete**
- ✅ **Website settings management complete**
- ✅ **Gallery management implemented**
- ✅ **Admin enquiry workflow operational**
- ✅ **Direct Booking System documentation complete** 📄

### Pending Client Decisions
- ⏳ **SMS/OTP Provider Selection** - Which provider? (Twilio, MSG91, TextLocal, etc.)
- ⏳ **OTP Expiry Duration** - Default: 5 minutes (configurable)
- ⏳ **OTP Resend Limits** - Default: 3 resends per 15 minutes
- ⏳ **Temporary Reservation Duration** - Default: 15 minutes (hold during payment)
- ⏳ **Hotel Check-In Time** - Default: 12:00 PM (for refund calculations)
- ⏳ **Tax Percentage** - Default: 12% GST (configurable)
- ⏳ **Cancellation Policy Confirmation** - ≥24h=100%, <24h=50%
- ⏳ **Razorpay Production Credentials** - Production account setup
- ⏳ **Multiple Room Booking** - Allow multiple rooms in one transaction?
- ⏳ **Same-Day Booking** - Allow bookings for today's date?

### Pending Implementation
- ⏳ **Phase 8 Implementation:** Direct Online Booking System (10-12 days)
  - ⏳ Phase 8A: Room Availability & Category Inventory
  - ⏳ Phase 8B: OTP-Based Customer Verification
  - ⏳ Phase 8C: Direct Booking Flow
  - ⏳ Phase 8D: Payment Verification & Confirmation
  - ⏳ Phase 8E: Customer Booking Management
  - ⏳ Phase 8F: Cancellation & Refund System

### Key Milestones
- ✅ Documentation Approval: COMPLETED
- ✅ Laravel Project Setup: COMPLETED
- ✅ Frontend Development: COMPLETED
- ✅ Database Setup: COMPLETED
- ✅ Admin Panel: COMPLETED
- ✅ Enquiry System: COMPLETED
- ✅ Settings Management: COMPLETED
- ✅ **Direct Booking System Documentation: COMPLETED**
- ⏳ **Direct Booking System Implementation: PENDING**
- ⏳ Feature Complete: PENDING
- ⏳ Testing & Optimization: PENDING
- ⏳ Production Live: PENDING

---

## NOTES

### System Architecture
- **Direct Online Booking:** Customers can search, book, and pay directly on the website without manual admin approval for normal bookings.
- **OTP-Based Identity:** Mobile number verification via OTP. NO mandatory passwords or permanent account registration required.
- **Real-Time Availability:** Category-wise and date-wise room availability calculation with overbooking prevention.
- **Automatic Confirmation:** Bookings confirmed automatically after successful payment verification.
- **Customer Self-Service:** Customers can view, manage, and cancel bookings using OTP verification (no passwords).

### Payment & Refunds
- **100% Full Payment via Razorpay:** NO advance, partial, or pay-at-hotel options. Integrated Razorpay checkout with server-side verification.
- **24-Hour Cancellation Policy:** 
  - Cancellation ≥24 hours before check-in: 100% refund
  - Cancellation <24 hours before check-in: 50% refund
  - Timezone: Asia/Kolkata for all calculations
- **Original-Payment Refunds Only:** Refunds processed to original payment method only. NO customer-provided payment IDs accepted.
- **Server-Side Security:** All payment signatures and webhooks verified server-side. Frontend NEVER trusted alone.

### Inventory Management
- **Category-Wise Rooms:** Room categories (types) separate from physical rooms. Each physical room belongs to one category.
- **Overbooking Prevention:** Database transactions with row-level locking (FOR UPDATE) prevent concurrent booking conflicts.
- **Temporary Reservations:** Rooms held temporarily during payment process (default: 15 minutes), then released or converted to confirmed.
- **Physical Room Allocation:** System automatically allocates specific physical rooms from available inventory.

### Security
- **OTP Security:** Bcrypt hashing, configurable expiry (default: 5 min), attempt limiting, rate limiting per mobile.
- **Payment Security:** Payment signature verification, webhook signature verification, idempotent processing, HTTPS required.
- **Authorization:** OTP verification required for booking access, IDOR protection, booking ID alone insufficient for access.
- **Database Security:** Transactions, row-level locking, optimistic locking, fresh availability checks inside transactions.

### Configuration & Flexibility
- **Configurable Settings:** Hotel information, prices, SMS provider, OTP settings, reservation timeouts, check-in times, tax rates, and refund policies all configurable via admin panel or .env.
- **SMS Provider Agnostic:** Support for multiple SMS providers (Twilio, MSG91, TextLocal, etc.) - client decision pending.
- **Premium Design:** Website must appear professional and luxury-oriented, not generic.
- **Scalability:** Architecture supports future enhancements (email notifications, advanced reporting, analytics).

### Pending Client Decisions
- SMS/OTP provider selection and credentials
- OTP expiry duration and resend limits
- Temporary reservation timeout duration
- Hotel check-in time for refund calculations
- Tax percentages and service fees
- Final cancellation policy approval
- Razorpay production account credentials
- Multiple room booking rules
- Same-day booking policy

### Technology Stack (Non-Negotiable)
- **Backend:** Laravel 12, PHP 8.2+
- **Database:** MySQL / MariaDB
- **Frontend:** Blade Templates, Bootstrap 5, Vanilla JavaScript
- **Payment:** Razorpay (India)
- **SMS:** Configurable provider (client choice)
- **NO React, Vue, Angular, Next.js, Node.js backend, or alternative payment gateways**

---

**Document Version:** 3.0 (Direct Booking System)  
**Last Updated:** November 13, 2026  
**Major Change:** Replaced WhatsApp payment link workflow with Direct Online Booking System  
**Next Review:** After Phase 8 implementation begins
