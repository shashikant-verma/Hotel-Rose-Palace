# Hotel Rose Palace - Technical Architecture Document

**Project:** Hotel Rose Palace  
**Technology Stack:** Laravel 12, MySQL, Blade, Bootstrap 5/Tailwind CSS  
**Architecture Document Version:** 1.0  
**Created:** November 12, 2026  
**Status:** For Approval

---

## ARCHITECTURE OVERVIEW

Hotel Rose Palace uses a **clean, modular Laravel 12 MVC (Model-View-Controller) architecture** designed for maintainability, scalability, and security. The system is divided into two distinct applications sharing the same database:

1. **Public Website** - Customer-facing hotel website with enquiry system
2. **Admin Dashboard** - Secure backend for hotel staff management

### Architecture Principles

- **Single Responsibility:** Each class/module has one clear purpose
- **DRY (Don't Repeat Yourself):** Reusable components and services
- **SOLID Principles:** Clean, maintainable code structure
- **Security-First:** Protection against common vulnerabilities
- **Testability:** Code designed to be easily tested
- **Performance:** Optimized queries and caching strategies

---

## LARAVEL 12 DIRECTORY STRUCTURE

```
Hotel-Rose-Palace/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PageController.php          # Public pages
│   │   │   ├── EnquiryController.php       # Customer enquiries
│   │   │   ├── Admin/
│   │   │   │   ├── AuthController.php      # Admin login/logout
│   │   │   │   ├── DashboardController.php # Admin dashboard
│   │   │   │   ├── RoomTypeController.php  # Room category management
│   │   │   │   ├── RoomController.php      # Room management
│   │   │   │   ├── EnquiryManagementController.php  # Enquiry handling
│   │   │   │   ├── SettingsController.php  # Website settings
│   │   │   │   └── GalleryController.php   # Gallery management
│   │   │   └── Api/
│   │   │       └── (Future API endpoints)
│   │   ├── Middleware/
│   │   │   ├── AdminAuthenticate.php       # Admin access control
│   │   │   ├── RedirectIfAdminAuthenticated.php
│   │   │   └── ValidateAdminAction.php
│   │   └── Requests/
│   │       ├── StoreEnquiryRequest.php     # Enquiry form validation
│   │       ├── StoreRoomTypeRequest.php    # Room type validation
│   │       ├── StoreRoomRequest.php        # Room validation
│   │       ├── UpdateSettingsRequest.php   # Settings validation
│   │       └── LoginRequest.php            # Admin login validation
│   ├── Models/
│   │   ├── User.php                        # Admin users
│   │   ├── RoomType.php                    # Room categories
│   │   ├── Room.php                        # Individual rooms
│   │   ├── RoomImage.php                   # Room photos
│   │   ├── Amenity.php                     # Hotel amenities
│   │   ├── Enquiry.php                     # Customer enquiries
│   │   ├── Gallery.php                     # Gallery images
│   │   ├── GalleryImage.php                # Gallery image records
│   │   ├── HotelSettings.php               # Website configuration
│   │   └── ContactMessage.php              # Contact form messages
│   ├── Services/
│   │   ├── WhatsAppService.php             # WhatsApp URL generation
│   │   ├── ImageUploadService.php          # Image handling
│   │   ├── SettingsService.php             # Settings management
│   │   ├── EnquiryService.php              # Enquiry business logic
│   │   └── RoomService.php                 # Room business logic
│   ├── Traits/
│   │   ├── HasTimestamps.php               # Timestamp management
│   │   └── HandleImages.php                # Image handling trait
│   └── Exceptions/
│       ├── EnquiryException.php
│       └── ImageUploadException.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_create_users_table.php
│   │   ├── 2024_01_02_create_room_types_table.php
│   │   ├── 2024_01_03_create_rooms_table.php
│   │   ├── 2024_01_04_create_room_images_table.php
│   │   ├── 2024_01_05_create_amenities_table.php
│   │   ├── 2024_01_06_create_amenity_room_type_table.php
│   │   ├── 2024_01_07_create_enquiries_table.php
│   │   ├── 2024_01_08_create_gallery_images_table.php
│   │   ├── 2024_01_09_create_hotel_settings_table.php
│   │   ├── 2024_01_10_create_contact_messages_table.php
│   │   └── 2024_01_11_add_indexes_and_soft_deletes.php
│   ├── seeders/
│   │   ├── AdminUserSeeder.php             # Initial admin user
│   │   ├── AmenitiesSeeder.php             # Default amenities
│   │   ├── RoomTypeSeeder.php              # Default room types
│   │   ├── HotelSettingsSeeder.php         # Initial settings
│   │   └── DatabaseSeeder.php              # Main seeder
│   └── factories/
│       ├── UserFactory.php
│       ├── RoomTypeFactory.php
│       └── EnquiryFactory.php              # For testing
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php               # Main website layout
│   │   │   ├── admin.blade.php             # Admin layout
│   │   │   └── components/
│   │   │       ├── navbar.blade.php
│   │   │       ├── footer.blade.php
│   │   │       ├── admin-sidebar.blade.php
│   │   │       └── form-errors.blade.php
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── about.blade.php
│   │   │   ├── rooms.blade.php
│   │   │   ├── room-detail.blade.php
│   │   │   ├── gallery.blade.php
│   │   │   ├── amenities.blade.php
│   │   │   ├── contact.blade.php
│   │   │   ├── privacy.blade.php
│   │   │   ├── terms.blade.php
│   │   │   └── cancellation.blade.php
│   │   ├── enquiry/
│   │   │   ├── form.blade.php              # Enquiry form component
│   │   │   └── success.blade.php
│   │   └── admin/
│   │       ├── dashboard.blade.php
│   │       ├── auth/
│   │       │   ├── login.blade.php
│   │       │   └── register.blade.php
│   │       ├── room-types/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   └── edit.blade.php
│   │       ├── rooms/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   ├── edit.blade.php
│   │       │   └── show.blade.php
│   │       ├── enquiries/
│   │       │   ├── index.blade.php
│   │       │   └── show.blade.php
│   │       ├── gallery/
│   │       │   ├── index.blade.php
│   │       │   └── upload.blade.php
│   │       ├── settings/
│   │       │   └── index.blade.php
│   │       └── profile/
│   │           └── edit.blade.php
│   ├── css/
│   │   ├── app.css                         # Main styles
│   │   ├── components.css                  # Component styles
│   │   └── responsive.css                  # Responsive rules
│   └── js/
│       ├── app.js                          # Main JS
│       ├── form-validation.js              # Client-side validation
│       ├── whatsapp-handler.js             # WhatsApp integration
│       └── admin.js                        # Admin-specific JS
├── routes/
│   ├── web.php                             # Public routes
│   ├── admin.php                           # Admin routes (included in web.php)
│   └── api.php                             # API routes (future)
├── config/
│   ├── app.php
│   ├── database.php
│   ├── mail.php
│   ├── filesystems.php
│   ├── auth.php
│   └── hotel.php                           # Custom config
├── tests/
│   ├── Feature/
│   │   ├── EnquiryTest.php
│   │   ├── RoomManagementTest.php
│   │   └── AdminAuthTest.php
│   └── Unit/
│       ├── WhatsAppServiceTest.php
│       └── ImageUploadServiceTest.php
├── bootstrap/
│   └── app.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   ├── rooms/                      # Room images
│   │   │   ├── gallery/                    # Gallery images
│   │   │   └── uploads/                    # General uploads
│   │   └── logs/
│   └── cache/
├── public/
│   ├── index.php                           # Entry point
│   ├── css/                                # Compiled CSS
│   ├── js/                                 # Compiled JS
│   └── images/                             # Static images/logos
├── .env                                    # Environment variables
├── .env.example                            # Environment template
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## DATABASE DESIGN

### Database Schema

#### 1. `users` Table
Admin/Staff users

```sql
CREATE TABLE users (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'manager') DEFAULT 'manager',
  is_active BOOLEAN DEFAULT TRUE,
  last_login_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP NULL
);
```

**Relationships:**
- One user creates many enquiry notes (future feature)

---

#### 2. `room_types` Table
Room categories (Standard, Superior, Executive)

```sql
CREATE TABLE room_types (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  description LONGTEXT,
  base_price DECIMAL(10,2) NOT NULL,
  max_occupancy INT NOT NULL,
  max_adults INT NOT NULL DEFAULT 2,
  max_children INT NOT NULL DEFAULT 2,
  is_active BOOLEAN DEFAULT TRUE,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP NULL
);
```

**Indexes:** slug, is_active  
**Relationships:**
- One room_type has many rooms
- Many room_types have many amenities (pivot table)

---

#### 3. `rooms` Table
Individual room records

```sql
CREATE TABLE rooms (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  room_type_id BIGINT UNSIGNED NOT NULL,
  room_number VARCHAR(50) NOT NULL UNIQUE,
  floor INT,
  current_price DECIMAL(10,2) NOT NULL,
  is_available BOOLEAN DEFAULT TRUE,
  status ENUM('available', 'booked', 'maintenance') DEFAULT 'available',
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  FOREIGN KEY (room_type_id) REFERENCES room_types(id)
);
```

**Indexes:** room_type_id, room_number, status, is_available  
**Relationships:**
- Many rooms belong to one room_type
- One room has many room_images

---

#### 4. `room_images` Table
Photos for each room

```sql
CREATE TABLE room_images (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  room_id BIGINT UNSIGNED NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  display_order INT DEFAULT 0,
  is_featured BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
);
```

**Relationships:**
- Many room_images belong to one room

---

#### 5. `amenities` Table
Hotel features/amenities

```sql
CREATE TABLE amenities (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL UNIQUE,
  description TEXT,
  icon_class VARCHAR(100),
  category VARCHAR(50),
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

**Sample Data:**
- Free Wi-Fi
- Free Parking
- 24-Hour Front Desk
- Restaurant
- Room Service
- Laundry Service
- Air Conditioning

---

#### 6. `amenity_room_type` Table (Pivot)
Links amenities to room types

```sql
CREATE TABLE amenity_room_type (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  amenity_id BIGINT UNSIGNED NOT NULL,
  room_type_id BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP,
  FOREIGN KEY (amenity_id) REFERENCES amenities(id) ON DELETE CASCADE,
  FOREIGN KEY (room_type_id) REFERENCES room_types(id) ON DELETE CASCADE,
  UNIQUE KEY unique_amenity_roomtype (amenity_id, room_type_id)
);
```

---

#### 7. `enquiries` Table
Customer booking enquiries

```sql
CREATE TABLE enquiries (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  reference_id VARCHAR(50) NOT NULL UNIQUE,
  room_type_id BIGINT UNSIGNED NOT NULL,
  customer_name VARCHAR(255) NOT NULL,
  customer_email VARCHAR(255),
  customer_phone VARCHAR(20) NOT NULL,
  check_in_date DATE NOT NULL,
  check_out_date DATE NOT NULL,
  num_adults INT NOT NULL DEFAULT 2,
  num_children INT NOT NULL DEFAULT 0,
  special_requests TEXT,
  status ENUM('new', 'contacted', 'availability_confirmed', 'booking_confirmed', 'cancelled', 'closed') DEFAULT 'new',
  internal_notes LONGTEXT,
  whatsapp_message_sent_at TIMESTAMP NULL,
  contacted_at TIMESTAMP NULL,
  confirmed_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  FOREIGN KEY (room_type_id) REFERENCES room_types(id)
);
```

**Indexes:** reference_id, customer_phone, status, check_in_date, created_at  
**Relationships:**
- Many enquiries belong to one room_type

---

#### 8. `gallery_images` Table
Hotel gallery photos

```sql
CREATE TABLE gallery_images (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  image_path VARCHAR(255) NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  category VARCHAR(100),
  alt_text VARCHAR(500),
  display_order INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP NULL
);
```

**Categories:** Hotel, Rooms, Restaurant, Lobby, etc.

---

#### 9. `hotel_settings` Table
Website configuration (dynamic settings)

```sql
CREATE TABLE hotel_settings (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  setting_key VARCHAR(255) NOT NULL UNIQUE,
  setting_value LONGTEXT,
  description TEXT,
  setting_type ENUM('text', 'textarea', 'number', 'boolean', 'url') DEFAULT 'text',
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

**Sample Settings:**
- hotel_name: Hotel Rose Palace
- hotel_tagline: Where Elegance Meets Comfort
- hotel_address: 4th Floor, Atlanta Business Hub...
- hotel_phone_1: +91 70424 24242
- hotel_phone_2: +91 8071 515 210
- hotel_email: info@hotelrosepalace.com
- whatsapp_number: +91xxxxxxxxx
- google_maps_embed_code: (iframe code)
- website_logo_url: /images/logo.png
- booking_terms: (HTML content)
- cancellation_policy: (HTML content)
- privacy_policy: (HTML content)

---

#### 10. `contact_messages` Table
Contact form submissions (optional)

```sql
CREATE TABLE contact_messages (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(20),
  message LONGTEXT NOT NULL,
  is_read BOOLEAN DEFAULT FALSE,
  is_replied BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP NULL
);
```

---

### Database Relationships Diagram

```
┌────────────────┐
│     users      │
└────────────────┘
        │
        ├─────► (creates notes on enquiries)
        │
┌────────────────┐         ┌─────────────────┐
│  room_types    │◄────────┤amenity_room_type├────────►┌───────────┐
└────────────────┘         └─────────────────┘         │ amenities │
        │                                               └───────────┘
        │ (has many)
        ▼
┌────────────────┐         ┌──────────────────┐
│     rooms      │◄────────┤  room_images     │
└────────────────┘         └──────────────────┘
        │
        ├─────► enquiries (many to many future feature)
        │
┌────────────────────┐
│    enquiries       │
└────────────────────┘

┌──────────────────┐
│ gallery_images   │
└──────────────────┘

┌──────────────────┐
│ hotel_settings   │
└──────────────────┘
```

---

## ELOQUENT MODELS

### Model Relationships

#### User Model
```php
class User extends Model {
    has Many('enquiry_notes');
    // Admin user model
}
```

#### RoomType Model
```php
class RoomType extends Model {
    has Many('rooms');
    belongs To Many('amenities', 'amenity_room_type');
    has Many('enquiries');
}
```

#### Room Model
```php
class Room extends Model {
    belongs To('room_type');
    has Many('room_images');
}
```

#### Enquiry Model
```php
class Enquiry extends Model {
    belongs To('room_type');
    // Has generated reference ID
    // Has status workflow
}
```

---

## ROUTES ARCHITECTURE

### Public Routes (`routes/web.php`)

```
GET  /                              → PageController@home
GET  /about                         → PageController@about
GET  /rooms                         → PageController@rooms (listing)
GET  /rooms/{slug}                  → PageController@roomDetail
GET  /gallery                       → PageController@gallery
GET  /amenities                     → PageController@amenities
GET  /contact                       → PageController@contact
POST /enquiry                       → EnquiryController@store
GET  /enquiry/success/{reference}   → EnquiryController@success
GET  /privacy                       → PageController@privacy
GET  /terms                         → PageController@terms
GET  /cancellation                  → PageController@cancellation

POST /contact                       → PageController@submitContact
```

### Admin Routes (`routes/admin.php`)

```
Middleware: auth.admin (custom admin middleware)
Prefix: /admin

GET  /login                         → AuthController@showLoginForm
POST /login                         → AuthController@login
POST /logout                        → AuthController@logout

GET  /dashboard                     → DashboardController@index
GET  /profile                       → DashboardController@profile
PUT  /profile                       → DashboardController@updateProfile

CRUD: Room Types
GET  /room-types                    → RoomTypeController@index
GET  /room-types/create             → RoomTypeController@create
POST /room-types                    → RoomTypeController@store
GET  /room-types/{id}/edit          → RoomTypeController@edit
PUT  /room-types/{id}               → RoomTypeController@update
DELETE /room-types/{id}             → RoomTypeController@destroy

CRUD: Rooms
GET  /rooms                         → RoomController@index
GET  /rooms/create                  → RoomController@create
POST /rooms                         → RoomController@store
GET  /rooms/{id}/edit               → RoomController@edit
PUT  /rooms/{id}                    → RoomController@update
DELETE /rooms/{id}                  → RoomController@destroy

Enquiries Management
GET  /enquiries                     → EnquiryManagementController@index
GET  /enquiries/{id}                → EnquiryManagementController@show
PUT  /enquiries/{id}                → EnquiryManagementController@updateStatus
PUT  /enquiries/{id}/notes          → EnquiryManagementController@updateNotes

Gallery Management
GET  /gallery                       → GalleryController@index
POST /gallery                       → GalleryController@store
DELETE /gallery/{id}                → GalleryController@destroy

Settings
GET  /settings                      → SettingsController@index
PUT  /settings                      → SettingsController@update
```

---

## SERVICE LAYER

### WhatsAppService

**Purpose:** Generate WhatsApp Click-to-Chat URLs and format messages

```php
class WhatsAppService {
    public function generateEnquiryMessage(Enquiry $enquiry): string
    // Returns pre-formatted WhatsApp message
    
    public function generateWhatsAppUrl(string $message): string
    // Returns encoded WhatsApp URL
    
    public function getWhatsAppNumber(): string
    // Retrieves from settings
}
```

### ImageUploadService

**Purpose:** Handle image uploads, validation, and storage

```php
class ImageUploadService {
    public function uploadRoomImage(UploadedFile $file, Room $room): RoomImage
    
    public function uploadGalleryImage(UploadedFile $file): GalleryImage
    
    public function deleteImage(string $path): bool
    
    public function validateImageFile(UploadedFile $file): void
    // Throws ImageUploadException on invalid files
}
```

### SettingsService

**Purpose:** Manage hotel settings and configuration

```php
class SettingsService {
    public function get(string $key, $default = null)
    // Retrieve setting value
    
    public function set(string $key, $value): void
    // Save setting value
    
    public function getAllSettings(): array
    
    public function getWhatsAppNumber(): string
    
    public function getHotelInfo(): array
}
```

### EnquiryService

**Purpose:** Handle enquiry business logic

```php
class EnquiryService {
    public function createEnquiry(array $data): Enquiry
    // Validate, create record, return enquiry
    
    public function updateEnquiryStatus(Enquiry $enquiry, string $status): Enquiry
    
    public function generateReferenceId(): string
    // Unique reference like HRP-2024-001234
}
```

---

## CONTROLLERS ARCHITECTURE

### PageController (Public)

**Methods:**
- `home()` - Homepage with featured rooms and facilities
- `about()` - About page
- `rooms()` - List all rooms with filters
- `roomDetail($slug)` - Individual room details
- `gallery()` - Hotel gallery
- `amenities()` - Amenities listing
- `contact()` - Contact page
- `submitContact()` - Process contact form
- `privacy()` - Privacy policy
- `terms()` - Terms and conditions
- `cancellation()` - Cancellation policy

### EnquiryController (Public)

**Methods:**
- `store()` - Accept enquiry form submission
- `success($reference)` - Show success page after enquiry

### AdminAuthController

**Methods:**
- `showLoginForm()` - Display login page
- `login()` - Process login
- `logout()` - End session

### DashboardController (Admin)

**Methods:**
- `index()` - Show dashboard with metrics
- `profile()` - Admin profile view
- `updateProfile()` - Update admin profile

### RoomTypeController (Admin)

**Methods:**
- `index()` - List room types
- `create()` - Show create form
- `store()` - Save room type
- `edit($id)` - Show edit form
- `update($id)` - Update room type
- `destroy($id)` - Delete room type

### RoomController (Admin)

**Methods:**
- `index()` - List rooms
- `create()` - Show create form
- `store()` - Save room
- `edit($id)` - Show edit form
- `update($id)` - Update room
- `destroy($id)` - Delete room

### EnquiryManagementController (Admin)

**Methods:**
- `index()` - List enquiries with filters
- `show($id)` - Show enquiry details
- `updateStatus($id)` - Update enquiry status
- `updateNotes($id)` - Add admin notes

### SettingsController (Admin)

**Methods:**
- `index()` - Show settings form
- `update()` - Save settings

---

## VALIDATION & FORM REQUESTS

### Form Request Classes

#### StoreEnquiryRequest
```php
public function rules(): array {
    return [
        'room_type_id' => 'required|exists:room_types,id',
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'nullable|email',
        'customer_phone' => 'required|regex:/^[0-9\s\-\+\(\)]{10,}$/',
        'check_in_date' => 'required|date|after:today',
        'check_out_date' => 'required|date|after:check_in_date',
        'num_adults' => 'required|integer|min:1',
        'num_children' => 'required|integer|min:0',
        'special_requests' => 'nullable|string|max:1000',
    ];
}
```

#### StoreRoomTypeRequest
```php
public function rules(): array {
    return [
        'name' => 'required|string|max:255|unique:room_types',
        'description' => 'required|string',
        'base_price' => 'required|numeric|min:0',
        'max_occupancy' => 'required|integer|min:1',
        'max_adults' => 'required|integer|min:1',
        'max_children' => 'required|integer|min:0',
        'amenities' => 'array',
        'amenities.*' => 'exists:amenities,id',
    ];
}
```

---

## MIDDLEWARE

### AdminAuthenticate Middleware

**Purpose:** Protect admin routes, redirect unauthenticated users

```php
public function handle(Request $request, Closure $next) {
    if (!auth()->check()) {
        return redirect('/admin/login');
    }
    return $next($request);
}
```

### ValidateAdminAction Middleware

**Purpose:** Verify admin has permission for action (for future role-based access)

```php
public function handle(Request $request, Closure $next, $action) {
    // Check if user has permission for action
    return $next($request);
}
```

---

## CUSTOMER ENQUIRY WORKFLOW

```
1. CUSTOMER VISITS WEBSITE
   ↓
2. BROWSE ROOMS
   ↓
3. CLICK "ENQUIRE" ON ROOM
   ↓
4. SUBMIT ENQUIRY FORM
   ├─ Form validation (client & server)
   ├─ Data saved to 'enquiries' table
   ├─ Reference ID generated (HRP-2024-xxxxx)
   ├─ WhatsApp message formatted
   ├─ Customer redirected to WhatsApp
   │  └─ If WhatsApp unavailable, success page shows
   │     with WhatsApp number to manually contact
   └─ Success page displays reference ID
      
5. ADMIN VIEWS ENQUIRY IN DASHBOARD
   ├─ New enquiry appears in admin panel
   ├─ Admin can update status (New → Contacted → Confirmed → Booked)
   ├─ Admin can add internal notes
   ├─ Admin can open customer WhatsApp chat
   └─ Admin confirms booking manually via WhatsApp

6. CUSTOMER RECEIVES RESPONSE
   └─ Hotel staff responds via WhatsApp
```

---

## WHATSAPP INTEGRATION WORKFLOW

### Message Format

```
Hi, I'd like to make a booking enquiry!

Hotel: Hotel Rose Palace
Room Type: Superior Room
Check-in: 15 Dec 2024
Check-out: 18 Dec 2024
Adults: 2
Children: 0
Enquiry Ref: HRP-2024-001234

Message: I'd like to know about special rates.

Please contact me to confirm availability and pricing.
```

### URL Generation

```
Base URL: https://wa.me/PHONE_NUMBER
Message: URL-encoded pre-filled message
Final URL: https://wa.me/919876543210?text=ENCODED_MESSAGE
```

---

## ADMIN AUTHENTICATION WORKFLOW

```
1. ADMIN VISIT /admin/login
   ↓
2. ENTER EMAIL & PASSWORD
   ↓
3. VALIDATE CREDENTIALS
   ├─ Check against 'users' table
   ├─ Verify password (bcrypt)
   ├─ Check is_active flag
   └─ Set session/remember token
      
4. REDIRECT TO DASHBOARD
   ├─ Load dashboard with metrics
   ├─ Show recent enquiries
   ├─ Display key statistics
   └─ Admin menu available
      
5. ON LOGOUT
   └─ Clear session & tokens
```

---

## SECURITY ARCHITECTURE

### CSRF Protection

- **Every form includes `@csrf`** Blade directive
- Laravel's CSRF middleware validates POST/PUT/DELETE requests
- Tokens stored in session and verified on each request

### Authentication & Authorization

- Admin users authenticated via Laravel Auth facade
- Passwords hashed using bcrypt algorithm
- Admin routes protected by middleware
- Session timeout configurable

### Input Validation

- All user inputs validated server-side via Form Requests
- Client-side validation for UX (not security)
- Whitelist approach: only expected fields accepted

### SQL Injection Prevention

- Eloquent ORM with parameterized queries
- Never concatenate user input into queries
- Use query builders and models exclusively

### File Upload Security

- Only image file types allowed (.jpg, .jpeg, .png, .webp)
- Maximum file size enforced (5MB)
- Files stored outside public web root
- Filename randomized to prevent direct access
- File type verified by MIME type, not extension

### XSS Prevention

- All dynamic content escaped in Blade: `{{ $variable }}`
- HTML purified when storing rich text
- Content Security Policy headers set

### Rate Limiting

- Enquiry form submission rate-limited (5 per hour per IP)
- Admin login attempts limited (5 attempts per minute)

---

## ERROR HANDLING

### Exception Handling

```php
// In App\Exceptions\Handler.php

public function register() {
    $this->reportable(function (EnquiryException $e) {
        // Log enquiry-specific errors
    });
    
    $this->renderable(function (Exception $e, $request) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Server error'], 500);
        }
        return view('errors.500');
    });
}
```

### Error Pages

- 404 - Page not found
- 500 - Server error
- 403 - Unauthorized access
- Custom error messages for validation failures

---

## LOGGING

### Log Channels

- **Daily logs:** `/storage/logs/laravel-*.log`
- **Admin actions:** Logged separately for audit trail
- **Enquiry processing:** Tracked in database and logs
- **Errors:** Captured with stack trace and context

### Loggable Events

- Admin login/logout
- Room/category changes
- Enquiry creation and status updates
- File upload failures
- Validation errors

---

## PERFORMANCE OPTIMIZATION

### Database Optimization

- Proper indexes on frequently queried columns
- Eager loading with Eloquent `with()` method
- Pagination for large result sets (15-25 items per page)
- Database connection pooling for production

### Caching Strategy

- Hotel settings cached (invalidated on update)
- Room listings cached with 1-hour TTL
- Admin query results cached where appropriate

### Asset Optimization

- CSS and JS minified via Vite
- Images optimized and lazy-loaded
- WebP format for supported browsers
- CDN setup for static assets (future)

### Query Optimization

- Avoid N+1 queries with eager loading
- Use select() to fetch only needed columns
- Implement pagination
- Database query profiling in development

---

## DEPLOYMENT ARCHITECTURE

### Development Environment
- Local machine with PHP 8.2+, MySQL, Node.js
- `.env` with local database credentials
- `php artisan serve` for development server

### Production Environment
- Dedicated web server (Apache/Nginx)
- Separate MySQL database server
- SSL/TLS certificate for HTTPS
- Environment-specific `.env` file
- Automated backups
- Error monitoring (Sentry/similar optional)

### Deployment Steps

1. Clone repository from Git
2. Install PHP dependencies: `composer install --optimize-autoloader`
3. Install Node dependencies: `npm install`
4. Build frontend assets: `npm run build`
5. Copy `.env.example` to `.env`
6. Generate app key: `php artisan key:generate`
7. Run migrations: `php artisan migrate`
8. Seed initial data: `php artisan db:seed`
9. Set proper file permissions
10. Configure web server document root
11. Set up SSL certificate
12. Enable HTTPS redirect

---

## TECHNOLOGY DECISIONS

### Why Laravel 12?
- Modern, well-documented framework
- Built-in security features (CSRF, SQL injection prevention)
- Eloquent ORM for database interactions
- Blade templating for clean syntax
- Excellent package ecosystem

### Why MySQL?
- Reliable relational database
- ACID compliance for data integrity
- Perfect for this project's scale
- Easy backup and recovery

### Why Blade Templates?
- Native Laravel templating
- Reusable components
- Easy to learn and maintain
- Built-in security features

### Why Bootstrap 5 / Tailwind?
- Either framework provides:
  - Responsive grid system
  - Pre-built components
  - Mobile-first design
  - Active community support
- Decision: Bootstrap 5 for simpler setup, Tailwind for customization
- Final choice after approval in Phase 2

---

## FUTURE EXTENSIBILITY

The architecture supports future features:

- **Email Notifications:** Use Laravel Mail for booking confirmations
- **SMS Integration:** Add Twilio for SMS alerts
- **Payment Gateway:** Add payment system when needed (separate from enquiry flow)
- **Mobile App:** API endpoints ready for future mobile development
- **Advanced Analytics:** Track enquiry conversion rates, popular rooms
- **Calendar Management:** Visual availability calendar
- **User Reviews:** Guest review system
- **Multi-language Support:** i18n translations
- **Restaurant Reservations:** Extend for F&B bookings

---

## CONCLUSION

This architecture provides:

✅ Clean, maintainable code structure  
✅ Security-first approach  
✅ Scalability for future features  
✅ Separation of concerns (Models, Views, Controllers, Services)  
✅ Reusable components and traits  
✅ Proper error handling and logging  
✅ Performance optimization strategies  

The system is designed for easy maintenance and future expansion without major architectural changes.

---

**Document Version:** 1.0  
**Status:** Awaiting Approval  
**Last Updated:** November 12, 2026  
**Next Steps:** Await approval → Begin Phase 1 Implementation
