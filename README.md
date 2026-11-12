# Hotel Rose Palace - Premium Hotel Website

A complete, production-ready hotel website for **Hotel Rose Palace**, Surat, Gujarat, India.

**Status:** 📋 Documentation & Planning Phase  
**Last Updated:** November 12, 2026

---

## 🏨 Project Overview

Hotel Rose Palace is a modern, responsive hotel website built with **Laravel 12** and **MySQL**. The project features:

- **Customer-Facing Website** - Premium hotel browsing and WhatsApp-based enquiry system
- **Admin Dashboard** - Secure backend for managing rooms, enquiries, gallery, and hotel settings
- **WhatsApp Integration** - Direct booking enquiries with pre-filled messages (no payment gateway)
- **Dynamic Content** - All hotel information configurable via admin panel

### Key Features

✅ **No Payment Gateway** - Enquiries redirect to WhatsApp for manual confirmation  
✅ **Responsive Design** - Mobile, tablet, and desktop optimized  
✅ **Premium Aesthetic** - Luxury hotel appearance  
✅ **Secure Admin Panel** - Protected admin routes with authentication  
✅ **Database-Driven** - All content managed via admin  
✅ **Clean Architecture** - Laravel MVC with service layer  

---

## 📍 Hotel Information

**Hotel Name:** Hotel Rose Palace  
**Location:** 4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007  
**Phone:** +91 70424 24242 | +91 8071 515 210  
**Website:** (To be deployed)

### Room Categories

- Standard Double Room
- Superior Room
- Executive / Family Room

---

## 🛠 Technology Stack

### Backend
- **PHP:** 8.2+
- **Framework:** Laravel 12
- **Database:** MySQL 8.0+
- **ORM:** Eloquent

### Frontend
- **Templates:** Blade Templates
- **CSS:** Bootstrap 5 / Tailwind CSS
- **JavaScript:** Vanilla JS + jQuery (optional)
- **Build Tool:** Vite

### Additional
- **Version Control:** Git
- **Package Manager:** Composer (PHP), npm (Node.js)
- **Environment:** Windows / Linux / macOS

---

## 📋 Documentation

Complete documentation files are included in the project root:

### 1. **planphase.md** - Development Roadmap
- 9-phase development plan
- Detailed tasks and dependencies
- Progress tracking
- Testing requirements

### 2. **design.md** - UI/UX Design System
- Color palette and typography
- Component designs
- Layout specifications
- Responsive design rules
- WCAG accessibility guidelines

### 3. **archestrate.md** - Technical Architecture
- Laravel 12 directory structure
- Database schema (10 tables)
- API routes and workflows
- Security architecture
- Deployment specifications

---

## 🚀 Development Phases

The project follows a **strict phase-wise development approach**:

| Phase | Objective | Status |
|-------|-----------|--------|
| **Phase 1** | Project Setup & Analysis | ⏳ Pending |
| **Phase 2** | Premium Frontend UI Development | ⏳ Pending |
| **Phase 3** | Database Design & Backend Architecture | ⏳ Pending |
| **Phase 4** | Authentication & Admin Dashboard | ⏳ Pending |
| **Phase 5** | Room & Category Management | ⏳ Pending |
| **Phase 6** | Customer Enquiry & WhatsApp Integration | ⏳ Pending |
| **Phase 7** | Enquiry Management & Website Settings | ⏳ Pending |
| **Phase 8** | Testing, Security & Optimization | ⏳ Pending |
| **Phase 9** | Production Deployment | ⏳ Pending |

---

## 💾 Database Structure

### Tables (10 total)

1. **users** - Admin/staff users
2. **room_types** - Room categories (Standard, Superior, Executive)
3. **rooms** - Individual room records
4. **room_images** - Room photographs
5. **amenities** - Hotel features (Wi-Fi, Parking, Restaurant, etc.)
6. **amenity_room_type** - Amenity-RoomType relationships (pivot)
7. **enquiries** - Customer booking enquiries
8. **gallery_images** - Hotel gallery photos
9. **hotel_settings** - Website configuration/CMS
10. **contact_messages** - Contact form submissions

---

## 📱 Customer Features

### Public Website Pages

- **Home** - Hero section, featured rooms, facilities, gallery preview, testimonials
- **About** - Hotel introduction and services
- **Rooms & Suites** - Browse available room categories
- **Room Details** - Individual room information with images and enquiry form
- **Gallery** - Hotel and room photographs
- **Amenities** - Detailed amenities listing
- **Contact** - Address, phone, Google Maps, contact form
- **Legal** - Privacy Policy, Terms & Conditions, Cancellation Policy

### Enquiry System

1. Customer selects room and dates
2. Enters name, phone, and optional message
3. System saves enquiry to database
4. Unique reference ID generated
5. Redirects to WhatsApp with pre-filled message
6. Hotel staff responds and confirms manually

---

## 🔐 Admin Dashboard Features

### Modules

- **Dashboard** - Key metrics (total, new, confirmed, cancelled enquiries)
- **Room Categories** - Add, edit, delete room types
- **Room Management** - Add/edit rooms, upload images, manage inventory
- **Enquiry Management** - View, search, filter enquiries, update status, add notes
- **Gallery Management** - Upload and delete gallery images
- **Website Settings** - Configure hotel info, WhatsApp number, contact details
- **Admin Profile** - Manage admin account

### Enquiry Statuses

- New
- Contacted
- Availability Confirmed
- Booking Confirmed
- Cancelled
- Closed

---

## 🔒 Security Features

✅ CSRF Protection  
✅ SQL Injection Prevention (Eloquent ORM)  
✅ XSS Protection (Blade escaping)  
✅ Admin Authentication & Authorization  
✅ Password Hashing (bcrypt)  
✅ File Upload Validation  
✅ Rate Limiting  
✅ Input Validation (Server-side)  
✅ Environment Variable Protection  

---

## 📦 Installation

### Prerequisites

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Node.js v18+ and npm
- Composer
- Git

### Local Setup (Coming in Phase 1)

```bash
# Clone the repository
git clone https://github.com/shashikant-verma/Hotel-Rose-Palace.git
cd Hotel-Rose-Palace

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database and run migrations
php artisan migrate

# Seed initial data
php artisan db:seed

# Build frontend assets
npm run dev

# Start development server
php artisan serve
```

The website will be available at `http://localhost:8000`

---

## 🎨 Design System

### Color Palette

| Color | Hex | Usage |
|-------|-----|-------|
| Deep Navy | `#1a2332` | Headings, navigation, footer |
| Warm Ivory | `#f5f3f0` | Backgrounds |
| Muted Gold | `#c9a961` | Accents, CTAs, buttons |
| Crisp White | `#ffffff` | Content backgrounds |
| Light Gray | `#e8e6e3` | Borders, dividers |

### Typography

- **Headings:** Playfair Display (elegant, luxury feel)
- **Navigation & Buttons:** Poppins (modern, professional)
- **Body Text:** Lato (high readability)

---

## 📁 Project Structure

```
Hotel-Rose-Palace/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Services/
│   └── Exceptions/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── config/
├── tests/
├── storage/
├── public/
├── .env.example
├── .gitignore
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## 🧪 Testing

Comprehensive testing will be included in Phase 8:

- Unit tests for services
- Feature tests for controllers
- Database integration tests
- Form validation tests
- Security vulnerability testing

---

## 🚢 Deployment

Production deployment configuration will be provided in Phase 9, including:

- Web server setup (Apache/Nginx)
- SSL/HTTPS configuration
- Database backups
- Error monitoring
- Performance optimization

---

## 📚 Documentation Files

1. **planphase.md** - Complete development roadmap with all phases and tasks
2. **design.md** - UI/UX design system with colors, typography, and layouts
3. **archestrate.md** - Technical architecture with database schema and workflows
4. **DOCUMENTATION_SUMMARY.md** - Overview of all three documents

---

## 🤝 Contributing

This is a project-specific repository. For development guidelines, refer to the documentation files included in the project root.

---

## 📝 License

This project is proprietary. All rights reserved by Hotel Rose Palace.

---

## 👤 Developer

**Lead Developer:** Kiro AI Assistant  
**Project Manager:** Shashikant Verma  
**Start Date:** November 12, 2026

---

## 📞 Support

For questions or issues related to this project, please contact:
- **Email:** [To be configured]
- **WhatsApp:** [To be configured]

---

## 📋 Current Status

**Phase:** Planning & Documentation  
**Status:** ✅ Documentation Complete - Awaiting Approval  
**Next Step:** Phase 1 - Project Setup (after approval)

---

**Last Updated:** November 12, 2026  
**Repository:** https://github.com/shashikant-verma/Hotel-Rose-Palace
