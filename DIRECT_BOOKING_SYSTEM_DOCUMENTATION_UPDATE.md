# Hotel Rose Palace - Direct Online Booking System Documentation Update

**Date:** November 13, 2026  
**Task Type:** DOCUMENTATION UPDATE ONLY  
**Status:** ⏳ IN PROGRESS

---

## EXECUTIVE SUMMARY

This document tracks the complete replacement of the previous WhatsApp-enquiry-based workflow with a **Direct Online Room Booking System** that allows customers to search, book, pay, and manage their reservations entirely through the website without mandatory registration or manual admin approval for normal bookings.

---

## KEY WORKFLOW CHANGES

### ❌ REMOVED: Old Enquiry-Based Workflow

The following workflow is being **REMOVED** from documentation:

1. ~~Customer submits booking enquiry~~
2. ~~Admin manually checks room availability~~
3. ~~Admin approves or rejects enquiry~~
4. ~~Admin enters final booking amount~~
5. ~~Admin generates WhatsApp payment link~~
6. ~~Customer pays via separate payment link~~
7. ~~Manual confirmation by admin~~

### ✅ NEW: Direct Online Booking Workflow

The new workflow being **ADDED** to documentation:

1. Customer searches available rooms (date-based, category-wise)
2. Customer selects room category and quantity
3. Customer enters personal details (name, mobile, email)
4. Customer verifies mobile number via OTP
5. System automatically calculates total amount (server-side)
6. System creates temporary room reservation
7. Customer proceeds to Razorpay Checkout
8. Customer pays 100% booking amount
9. System verifies payment signature (server-side)
10. System confirms booking automatically
11. Customer receives instant booking confirmation
12. Customer can manage bookings via OTP (no password needed)

---

## CORE SYSTEM REQUIREMENTS BEING DOCUMENTED

### 1. Direct Online Booking
- Real-time room availability checking
- Category-wise and date-wise availability
- Automatic booking confirmation after payment
- No manual admin approval for normal bookings
- Instant booking confirmation

### 2. OTP-Based Customer Identity
- Mobile number verification via OTP
- No mandatory password or permanent account
- Customers can book without signup
- Customers can manage bookings using OTP verification
- "My Bookings" feature with OTP access

### 3. Category-Wise Room Inventory
- Room categories (types) separate from physical rooms
- Each physical room belongs to one category
- Availability calculated per category and date range
- Prevents overbooking with database transactions
- Row-level locking for concurrent booking prevention

### 4. Automatic Temporary Reservations
- System holds rooms during payment process
- Configurable expiry duration
- Automatic release if payment fails/expires
- Conversion to confirmed booking after payment
- No database transaction kept open during Razorpay

### 5. Server-Side Pricing & Validation
- All prices calculated on backend
- Never trust frontend amounts
- Tax calculations on server
- Discount rules on server
- Total amount verification before payment

### 6. Razorpay Full Online Payment
- 100% full payment only
- No partial/advance payments
- No pay-at-hotel option
- Direct Razorpay Checkout integration
- Payment signature verification (server-side)
- Webhook verification (independent)

### 7. Customer Booking Management
- View bookings via OTP verification
- No permanent login required
- Booking details display
- Payment status tracking
- Refund status tracking
- Cancellation request functionality

### 8. Cancellation & Refund System
- 24-hour policy (≥24h = 100%, <24h = 50%)
- Customer-initiated cancellations
- Automatic refund calculation
- Original-payment-based refunds only
- No manual refund destination entry
- Razorpay Refund API integration
- Asia/Kolkata timezone

### 9. Admin Dashboard Updates
- View all direct bookings
- Manage room inventory
- View payment/refund status
- Handle exceptional cases only
- No need to approve normal bookings

### 10. Security Architecture
- OTP hashing and expiry
- Rate limiting
- CSRF protection
- Authorization checks
- IDOR protection
- Database transactions
- Payment signature verification
- Webhook signature verification
- Idempotent processing
- Audit logging

---

## DATABASE ARCHITECTURE CHANGES BEING DOCUMENTED

### New/Modified Tables to Document:

#### 1. `bookings` Table (NEW)
Purpose: Store confirmed customer bookings
- Booking ID (unique)
- Customer details (name, mobile, email)
- Room category ID
- Physical room allocation
- Check-in/check-out dates
- Guest counts
- Room quantity
- Total amount (server-calculated)
- Razorpay Order ID
- Razorpay Payment ID
- Booking status (confirmed, cancelled, checked_in, checked_out)
- Payment status (paid, refunded, partially_refunded)
- Cancellation details
- Timestamps

#### 2. `otp_verifications` Table (NEW)
Purpose: Handle OTP-based mobile verification
- Mobile number
- OTP hash (bcrypt)
- Purpose (booking, manage_booking)
- Expiry timestamp
- Verified flag
- Attempt count
- Created timestamp

#### 3. `room_allocations` Table (NEW)
Purpose: Track physical room assignments
- Booking ID
- Room ID (physical room)
- Check-in date
- Check-out date
- Allocation status (temporary, confirmed, released)
- Allocated timestamp
- Released timestamp

#### 4. `temporary_reservations` Table (NEW)
Purpose: Hold rooms during payment process
- Reservation ID
- Customer mobile
- Room category ID
- Room quantity
- Check-in/check-out dates
- Razorpay Order ID
- Expiry timestamp
- Status (active, expired, converted, released)
- Created timestamp

#### 5. `payments` Table (UPDATED)
Additions to existing structure:
- Booking ID reference
- Payment method details
- Webhook event tracking
- Verification timestamps

#### 6. `refunds` Table (EXISTS - UPDATE REFERENCE)
Update to reference `bookings` instead of `enquiries`
- Booking ID (instead of enquiry ID)
- Refund policy applied
- Customer-initiated flag

#### 7. Room Inventory Architecture
Update relationships:
- `room_types` (categories) → one-to-many → `rooms` (physical)
- `bookings` → many-to-one → `room_types`
- `bookings` → one-to-many → `room_allocations`
- `room_allocations` → many-to-one → `rooms` (physical)

### Existing Tables to Keep:
- `enquiries` - For historical enquiry records (optional legacy)
- `room_types` - Room categories
- `rooms` - Physical rooms
- `amenities` - Room amenities
- `gallery_images` - Hotel gallery
- `hotel_settings` - Configuration
- `users` - Admin users

---

## CONFLICTING DOCUMENTATION TO RESOLVE

### Conflicts with Previous Phase 8 Documentation:

**OLD Phase 8 (to be replaced):**
- WhatsApp payment link generation
- Manual admin approval for every booking
- Payment links sent via WhatsApp
- Admin-initiated payment process

**NEW Phase 8 (to be documented):**
- Direct online booking system
- Automatic booking confirmation
- OTP-based customer verification
- Integrated Razorpay checkout
- Customer self-service booking management

### Resolution Strategy:
1. **Completely replace** Phase 8 content
2. **Remove** references to:
   - WhatsApp payment links as primary flow
   - Manual admin approval for normal bookings
   - Enquiry-to-booking conversion workflow
3. **Add** references to:
   - Direct room search and booking
   - OTP verification
   - Category-wise inventory
   - Automatic temporary reservations
   - Customer booking management

---

## SECURITY REQUIREMENTS TO DOCUMENT

### OTP Security:
- Server-side generation
- Bcrypt hashing
- Configurable expiry (default: 5 minutes)
- Attempt limiting (max 3-5 attempts)
- Resend throttling
- Single-use validation
- Rate limiting per mobile number

### Booking Authorization:
- OTP verification required for booking access
- Secure session management
- Session expiry after inactivity
- Authorization on every booking action
- Booking ID alone insufficient for access
- IDOR protection

### Inventory Protection:
- Database transactions
- Row-level locking (FOR UPDATE)
- Fresh availability checks in transaction
- Optimistic locking where needed
- Deadlock prevention strategies
- Concurrent booking handling

### Payment Security:
- Server-side amount calculation only
- Payment signature verification
- Webhook signature verification
- Idempotent payment processing
- Duplicate payment prevention
- Razorpay secret keys in .env only

### Refund Security:
- Original payment ID retrieval from database
- No customer-provided payment IDs accepted
- Refund against verified payment only
- Automatic refund destination (original payment)
- No manual refund destination entry
- Idempotent refund processing

---

## PENDING CLIENT DECISIONS TO DOCUMENT

### 1. SMS/OTP Provider Configuration
- **Decision Needed:** Which SMS provider (Twilio, MSG91, TextLocal, etc.)?
- **Default Documentation:** Configurable SMS provider
- **Environment Variable:** `SMS_PROVIDER`, `SMS_API_KEY`, etc.

### 2. OTP Expiry Duration
- **Decision Needed:** How long should OTP remain valid?
- **Default Documentation:** 5 minutes (configurable)
- **Environment Variable:** `OTP_EXPIRY_MINUTES`

### 3. OTP Resend Limits
- **Decision Needed:** How many OTP resends allowed?
- **Default Documentation:** 3 resends per 15 minutes
- **Environment Variable:** `OTP_RESEND_LIMIT`, `OTP_RESEND_WINDOW`

### 4. Temporary Reservation Duration
- **Decision Needed:** How long to hold rooms during payment?
- **Default Documentation:** 15 minutes (configurable)
- **Environment Variable:** `RESERVATION_TIMEOUT_MINUTES`

### 5. Hotel Check-In Time
- **Decision Needed:** Standard check-in time for refund calculations?
- **Default Documentation:** 12:00 PM (configurable)
- **Environment Variable:** `HOTEL_CHECKIN_TIME`

### 6. Pricing & Taxes
- **Decision Needed:** GST percentage, additional charges, service fees?
- **Default Documentation:** 12% GST (configurable)
- **Environment Variable:** `TAX_GST_PERCENT`, `SERVICE_FEE_PERCENT`

### 7. Cancellation Policy Details
- **Decision Needed:** Final confirmation of 24-hour policy?
- **Default Documentation:** ≥24h=100%, <24h=50%
- **Client Approval:** Required

### 8. Razorpay Production Credentials
- **Decision Needed:** Production account setup complete?
- **Default Documentation:** Use test credentials for development
- **Environment Variables:** `RAZORPAY_KEY_ID`, `RAZORPAY_KEY_SECRET`, `RAZORPAY_WEBHOOK_SECRET`

### 9. Multiple Room Booking
- **Decision Needed:** Allow booking multiple rooms in one transaction?
- **Default Documentation:** Yes, with quantity selection
- **Business Logic:** To be confirmed

### 10. Same-Day Booking
- **Decision Needed:** Allow bookings for today's date?
- **Default Documentation:** No same-day bookings
- **Business Rule:** Check-in must be tomorrow or later

---

## FILES TO BE UPDATED

### 1. `planphase.md` ✅ TO UPDATE
**Changes:**
- Replace Phase 6-8 content
- Add Direct Booking System phases
- Add OTP verification tasks
- Add inventory management tasks
- Add temporary reservation tasks
- Remove WhatsApp payment link tasks
- Remove manual approval tasks (for normal bookings)
- Update dependencies and milestones

### 2. `design.md` ✅ TO UPDATE
**Changes:**
- Add room search/availability UI
- Add room category listing UI
- Add booking form UI
- Add OTP verification screens
- Add Razorpay checkout integration UI
- Add booking confirmation UI
- Add "My Bookings" UI
- Add booking management UI
- Add cancellation interface UI
- Remove WhatsApp payment link UI
- Remove manual approval UI
- Update responsive designs

### 3. `archestrate.md` ✅ TO UPDATE
**Changes:**
- Add direct booking architecture
- Add OTP generation/verification architecture
- Add category-wise inventory architecture
- Add temporary reservation architecture
- Add concurrent booking prevention strategy
- Add database transaction/locking strategy
- Update payment workflow (remove payment links)
- Update customer identity architecture (OTP-based)
- Add customer booking management architecture
- Update refund architecture (customer-initiated)
- Update security architecture

---

## IMPLEMENTATION PHASES TO DOCUMENT

### Revised Phase Structure:

**Phase 1-5:** ✅ COMPLETED (No changes)
- Project Setup
- Frontend UI
- Database Architecture
- Admin Authentication
- Room Management

**Phase 6:** ✅ COMPLETED → UPDATE DOCUMENTATION
- ~~Enquiry System~~ → Keep for reference
- Add: Basic room browsing (already exists)

**Phase 7:** ✅ COMPLETED → UPDATE DOCUMENTATION
- ~~Settings Management~~ → Keep as-is
- Add: Room availability logic documentation

**Phase 8:** 📝 COMPLETELY REPLACE
- **OLD:** WhatsApp payment links + manual approval
- **NEW:** Direct booking system with OTP + integrated payment

**Proposed NEW Phase 8 Sub-Phases:**

**Phase 8A: Room Availability & Category Inventory**
- Category-wise availability calculation
- Date-range availability queries
- Physical room allocation logic
- Database transaction strategies
- Concurrent booking prevention

**Phase 8B: OTP-Based Customer Verification**
- SMS provider integration
- OTP generation service
- OTP verification service
- Rate limiting
- Security measures

**Phase 8C: Direct Booking Flow**
- Booking form
- Temporary reservation system
- Server-side pricing calculation
- Razorpay order creation
- Payment integration

**Phase 8D: Payment Verification & Confirmation**
- Payment signature verification
- Webhook handling
- Booking confirmation logic
- Room allocation finalization
- Confirmation notifications

**Phase 8E: Customer Booking Management**
- "My Bookings" feature
- OTP-based booking access
- Booking details display
- Cancellation interface
- Refund status tracking

**Phase 8F: Refund System**
- Customer-initiated cancellation
- Automatic refund calculation
- Razorpay refund API
- Original-payment refunds
- Refund status tracking

**Phase 9:** Testing & Security (Update with new features)

**Phase 10:** Production Deployment (Update with new requirements)

---

## DOCUMENTATION STATUS

### Current Status:
- ⏳ Audit complete
- ⏳ Conflicts identified
- ⏳ New requirements mapped
- ⏳ Pending client decisions documented
- ⏳ Updating planphase.md
- ⏳ Updating design.md
- ⏳ Updating archestrate.md
- ⏳ Final report generation

### Next Steps:
1. Update `planphase.md` with new phases
2. Update `design.md` with new UI/UX
3. Update `archestrate.md` with new architecture
4. Generate final report
5. STOP and await approval

---

## CONFIRMATION: NO CODE IMPLEMENTATION

✅ **This is documentation update only**

**NOT doing:**
- ❌ Writing application code
- ❌ Creating migrations
- ❌ Modifying models
- ❌ Creating controllers
- ❌ Adding routes
- ❌ Modifying views
- ❌ Installing packages
- ❌ Changing .env
- ❌ Modifying database
- ❌ Starting Phase 8 implementation

**Only doing:**
- ✅ Updating documentation files
- ✅ Documenting new architecture
- ✅ Documenting new workflows
- ✅ Identifying pending decisions
- ✅ Creating update report

---

**Document Status:** ⏳ IN PROGRESS  
**Last Updated:** November 13, 2026  
**Next Action:** Begin systematic documentation updates
