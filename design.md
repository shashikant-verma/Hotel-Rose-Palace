# Hotel Rose Palace - UI/UX Design System

**Project:** Hotel Rose Palace  
**Design Document Version:** 1.0  
**Created:** November 12, 2026  
**Status:** For Approval

---

## DESIGN PHILOSOPHY

Hotel Rose Palace's website should exude **luxury, elegance, and sophistication** while remaining **clean, functional, and user-friendly**. The design language should appeal to both business travelers and leisure guests, projecting a premium yet welcoming image.

### Core Design Principles

1. **Elegance Through Simplicity** - Minimize clutter, maximize impact
2. **Premium Hospitality** - Every element should feel high-end
3. **Accessibility** - Beautiful design that works for everyone
4. **Performance** - Fast-loading, smooth interactions
5. **Consistency** - Unified visual language across all pages
6. **Mobile-First** - Optimized for mobile, enhanced for desktop
7. **Trustworthiness** - Professional appearance builds confidence

---

## BRAND IDENTITY

### Brand Name
**Hotel Rose Palace**

### Tagline (Suggested)
*"Where Elegance Meets Comfort"*

### Brand Values
- Luxury and premium service
- Guest-centric hospitality
- Modern sophistication
- Warm welcome
- Reliable excellence

---

## COLOR PALETTE

### Primary Colors

| Color | Usage | HEX | RGB |
|-------|-------|-----|-----|
| **Deep Navy** | Primary buttons, headings, footer, main text | `#1a2332` | RGB(26, 35, 50) |
| **Warm Ivory** | Backgrounds, card backgrounds | `#f5f3f0` | RGB(245, 243, 240) |
| **Muted Gold** | Accents, highlights, hover states | `#c9a961` | RGB(201, 169, 97) |
| **Crisp White** | Clean backgrounds, text contrast | `#ffffff` | RGB(255, 255, 255) |
| **Light Gray** | Borders, dividers, subtle backgrounds | `#e8e6e3` | RGB(232, 230, 227) |

### Secondary Colors

| Color | Usage | HEX | RGB |
|-------|-------|-----|-----|
| **Soft Rose** | Secondary accents, hover effects | `#d9a9a0` | RGB(217, 169, 160) |
| **Charcoal** | Alternative dark color | `#3a3a3a` | RGB(58, 58, 58) |
| **Silver** | Disabled states, secondary text | `#999999` | RGB(153, 153, 153) |

### Functional Colors

| Color | Usage | HEX |
|-------|-------|-----|
| Success | Confirmations, positive actions | `#27ae60` |
| Warning | Alerts, caution messages | `#f39c12` |
| Danger | Errors, cancellations | `#e74c3c` |
| Info | Information messages | `#3498db` |

### Color Usage Rules

- **Headers & Footers:** Deep Navy (`#1a2332`)
- **Main Content Backgrounds:** Warm Ivory (`#f5f3f0`)
- **Call-to-Action Buttons:** Muted Gold (`#c9a961`)
- **Button Hover:** Gold with 10% darker shade
- **Text:** Deep Navy for primary, Silver for secondary
- **Borders & Dividers:** Light Gray
- **Accents:** Soft Rose for premium sections

---

## TYPOGRAPHY

### Font Selection

| Font | Purpose | Usage |
|------|---------|-------|
| **Poppins** | Headings, navigation | Bold (700), Semi-Bold (600) |
| **Lato** | Body text, paragraphs | Regular (400), Light (300) |
| **Playfair Display** | Luxury headings, titles | Bold (700), Regular (400) |

### Font Sizes & Hierarchy

#### Desktop Sizes

| Level | Size | Weight | Line Height | Usage |
|-------|------|--------|-------------|-------|
| **H1** | 48px | 700 | 1.2 | Main page titles |
| **H2** | 36px | 700 | 1.3 | Section headings |
| **H3** | 28px | 600 | 1.4 | Subsection headings |
| **H4** | 24px | 600 | 1.4 | Card titles, highlights |
| **H5** | 20px | 600 | 1.5 | Smaller headings |
| **H6** | 16px | 600 | 1.5 | Minor headings |
| **Body Large** | 18px | 400 | 1.6 | Lead paragraphs |
| **Body Regular** | 16px | 400 | 1.6 | Standard text |
| **Body Small** | 14px | 400 | 1.5 | Secondary text |
| **Caption** | 12px | 400 | 1.4 | Labels, meta info |

#### Mobile Sizes

| Level | Size | Weight | Usage |
|-------|------|--------|-------|
| **H1** | 32px | 700 | Main titles |
| **H2** | 26px | 700 | Section headings |
| **H3** | 22px | 600 | Subsections |
| **Body Regular** | 16px | 400 | Standard text |
| **Body Small** | 14px | 400 | Secondary text |

### Typography Rules

- Use **Playfair Display** for hero sections and main titles (luxury feel)
- Use **Poppins** for navigation, buttons, and structured headings
- Use **Lato** for body copy (high readability)
- Maintain 1.5–1.6 line height for body text (accessibility)
- Limit line length to 60–80 characters for readability
- Use letter-spacing of 0.5–1px for headings

---

## COMPONENT STYLES

### Buttons

#### Primary Button (Call-to-Action)
- **Background:** Muted Gold (`#c9a961`)
- **Text:** Deep Navy (`#1a2332`)
- **Padding:** 14px 32px
- **Border Radius:** 4px
- **Font:** Poppins, 16px, 600
- **Hover:** Background darkens by 10%, slight shadow
- **Active:** Background darkens by 15%
- **Disabled:** Gray background, opacity 0.6

#### Secondary Button
- **Background:** Transparent
- **Border:** 2px solid Muted Gold (`#c9a961`)
- **Text:** Deep Navy (`#1a2332`)
- **Padding:** 12px 28px
- **Hover:** Background becomes Light Gold, shadow appears
- **Border Radius:** 4px

#### Tertiary Button (Link-style)
- **Background:** Transparent
- **Text:** Muted Gold (`#c9a961`)
- **Font Weight:** 600
- **Hover:** Text underlined
- **No padding/border**

### Forms

#### Text Input
- **Border:** 1px solid Light Gray (`#e8e6e3`)
- **Background:** Crisp White (`#ffffff`)
- **Padding:** 12px 14px
- **Font:** Lato, 16px
- **Border Radius:** 4px
- **Focus:** Border color changes to Muted Gold, subtle shadow
- **Label Font:** Poppins, 14px, 600

#### Form Labels
- **Font:** Poppins, 14px, 600
- **Color:** Deep Navy (`#1a2332`)
- **Margin Bottom:** 8px
- **Required indicator:** Asterisk in red

#### Form Validation
- **Valid:** Green border + checkmark
- **Error:** Red border + error message
- **Error Message:** 12px, red color, Lato regular

### Cards

#### Room Card (Homepage/Listing)
- **Background:** Crisp White (`#ffffff`)
- **Border:** None
- **Shadow:** Subtle (0 2px 8px rgba(0,0,0,0.1))
- **Border Radius:** 8px
- **Padding:** 0 (image flush with edge)
- **Hover:** Shadow intensifies, slight scale (1.02)
- **Image Height:** 280px on desktop, 200px on mobile
- **Content Padding:** 24px

#### Card Content
- **Title:** H4 (24px, Bold)
- **Description:** Body Small (14px)
- **Price:** H5 (20px), Muted Gold color
- **Button:** Primary button style

#### Gallery Item Card
- **Aspect Ratio:** 1:1 (square)
- **Border Radius:** 6px
- **Hover:** Zoom effect (1.05 scale), overlay appears
- **Overlay:** Semi-transparent Dark Navy with caption

### Navigation

#### Desktop Navigation
- **Background:** Crisp White
- **Height:** 70px
- **Logo:** 48px height, left-aligned
- **Menu Items:** Poppins, 16px, 600, Deep Navy
- **Active State:** Underline with Muted Gold
- **Hover:** Text changes to Muted Gold
- **Contact Button:** Primary gold button style

#### Mobile Navigation
- **Hamburger Menu:** Deep Navy, 24px icon
- **Slide-out Menu:** Full width, Deep Navy background
- **Menu Items:** 18px, 500 weight, centered
- **Menu Item Padding:** 16px vertical
- **Close Icon:** Top right corner

### Footer

#### Footer Layout
- **Background:** Deep Navy (`#1a2332`)
- **Text:** Warm Ivory (`#f5f3f0`)
- **Padding:** 60px horizontal, 40px vertical
- **Columns:** 4 columns on desktop, 1 on mobile

#### Footer Links
- **Font:** Lato, 14px, 400
- **Hover:** Color changes to Muted Gold
- **Section Headings:** Poppins, 16px, 600

---

## PAGE LAYOUTS

### Home Page Layout

```
┌─────────────────────────────────────┐
│          NAVIGATION BAR              │
│  Logo    Menu Items    Contact Btn   │
├─────────────────────────────────────┤
│                                       │
│     HERO SECTION (Full Width)        │
│  Large Image + Dark Overlay          │
│  Centered Title + Subtitle           │
│  Quick Search / CTA Button           │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  WELCOME SECTION                     │
│  Hotel Introduction (text + image)   │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  FEATURED ROOMS (3 columns)          │
│  Room Cards with Images              │
│  "Explore All" link                  │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  FACILITIES SECTION (4 columns)      │
│  Icons + Text for each facility      │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  GALLERY PREVIEW (6 images grid)     │
│  "View Full Gallery" link            │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  TESTIMONIALS SECTION                │
│  3 guest reviews (carousel optional) │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  LOCATION SECTION                    │
│  Google Maps + Address Info          │
│                                       │
├─────────────────────────────────────┤
│  FOOTER                              │
│  Links, Contact, Social Links        │
└─────────────────────────────────────┘
```

### Room Cards Layout

**Desktop (3 columns):**
```
┌──────────────┬──────────────┬──────────────┐
│    IMAGE     │    IMAGE     │    IMAGE     │
│   280px H    │   280px H    │   280px H    │
├──────────────┼──────────────┼──────────────┤
│ Title        │ Title        │ Title        │
│ Description  │ Description  │ Description  │
│ Price        │ Price        │ Price        │
│ [Button]     │ [Button]     │ [Button]     │
└──────────────┴──────────────┴──────────────┘
```

**Mobile (1 column):**
```
┌─────────────────┐
│     IMAGE       │
│    200px H      │
├─────────────────┤
│ Title           │
│ Description     │
│ Price           │
│ [Button]        │
└─────────────────┘
```

### Room Details Page Layout

```
┌─────────────────────────────────────┐
│       NAVIGATION BAR                 │
├─────────────────────────────────────┤
│                                       │
│  BREADCRUMB: Home > Rooms > Room Name│
│                                       │
├─────────────────────────────────────┤
│                                       │
│  IMAGE GALLERY (Main + Thumbnails)   │
│  Large image on left, thumbnails below
│                                       │
├─────────────────────────────────────┤
│                                       │
│  LEFT COLUMN          RIGHT COLUMN   │
│                                       │
│  - Room Details       - Price Info   │
│  - Description        - Occupancy    │
│  - Amenities List     - Book Button  │
│  - Capacity                          │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  ENQUIRY FORM SECTION                │
│  Full-width form for booking inquiry │
│                                       │
├─────────────────────────────────────┤
│  FOOTER                              │
└─────────────────────────────────────┘
```

### Contact Page Layout

```
┌─────────────────────────────────────┐
│       NAVIGATION BAR                 │
├─────────────────────────────────────┤
│                                       │
│  PAGE TITLE: Contact Us              │
│                                       │
├─────────────────────────────────────┤
│                                       │
│  LEFT COLUMN          RIGHT COLUMN   │
│                                       │
│  CONTACT INFO         CONTACT FORM   │
│  - Address            - Name field   │
│  - Phone              - Email field  │
│  - Email              - Message      │
│  - WhatsApp Link      - [Submit]     │
│  - Hours                             │
│                                       │
├─────────────────────────────────────┤
│  GOOGLE MAPS (Full Width)            │
├─────────────────────────────────────┤
│  FOOTER                              │
└─────────────────────────────────────┘
```

### Admin Dashboard Layout

```
┌──────────────────────────────────────┐
│     ADMIN HEADER / LOGOUT            │
├──────────┬──────────────────────────┤
│          │                           │
│  SIDEBAR │   MAIN DASHBOARD AREA    │
│          │                           │
│ - Dashboard       ┌─────────────────┐│
│ - Rooms          │ Key Metrics     ││
│ - Enquiries      │ - Total         ││
│ - Settings       │ - New           ││
│ - Gallery        │ - Confirmed     ││
│ - Logout         │ - Cancelled     ││
│                  └─────────────────┘│
│                                      │
│                  ┌─────────────────┐│
│                  │ Recent Enquiries││
│                  │ [Table]         ││
│                  └─────────────────┘│
│                                      │
└──────────┴──────────────────────────┘
```

---

## MOBILE RESPONSIVE DESIGN

### Breakpoints

| Breakpoint | Width | Device |
|-----------|-------|--------|
| **Mobile** | < 768px | Phone, small tablet |
| **Tablet** | 768px - 1024px | iPad, medium devices |
| **Desktop** | > 1024px | Laptop, desktop |

### Mobile-First Rules

1. **Navigation:** Hamburger menu (all items hidden until clicked)
2. **Columns:** Single column layout for all sections
3. **Images:** Full width minus padding (16px each side)
4. **Cards:** Full width, no side-by-side arrangement
5. **Buttons:** Full width on mobile forms
6. **Font Sizes:** Reduced (see typography section)
7. **Spacing:** Reduced margins/padding on mobile
8. **Footer:** Single column layout, centered text

### Tablet Rules

1. **Navigation:** Can show on desktop, hamburger menu optional
2. **Columns:** 2-column layouts where applicable
3. **Cards:** 2 per row for room cards
4. **Footer:** 2 columns
5. **Images:** Optimized for tablet viewing

### Desktop Rules

1. **Navigation:** Full horizontal menu
2. **Columns:** Multi-column layouts (3-4 columns)
3. **Cards:** 3 cards per row
4. **Footer:** 4 columns
5. **Spacing:** Generous margins, premium feel

---

## UI COMPONENT STANDARDS

### Spacing (Vertical Rhythm)

Base unit: 8px

| Unit | Size | Usage |
|------|------|-------|
| xs | 4px | Micro spacing |
| sm | 8px | Small components |
| md | 16px | Standard spacing |
| lg | 24px | Section spacing |
| xl | 32px | Large sections |
| xxl | 48px | Hero sections |

### Shadows

| Level | Shadow | Usage |
|-------|--------|-------|
| **Subtle** | 0 2px 8px rgba(0,0,0,0.1) | Cards, subtle elevation |
| **Medium** | 0 4px 16px rgba(0,0,0,0.15) | Modals, buttons on hover |
| **Pronounced** | 0 8px 24px rgba(0,0,0,0.2) | Floating elements |
| **None** | none | Flat design elements |

### Border Radius

| Element | Radius |
|---------|--------|
| Cards | 8px |
| Buttons | 4px |
| Images | 6px |
| Input fields | 4px |
| Large containers | 12px |

### Hover Effects

- **Subtle Scale:** 1.02 (2% increase)
- **Shadow:** Increases by one level
- **Color Shift:** Primary color deepens or gold accent appears
- **Duration:** 300ms ease-in-out

---

## IMAGE & ICON GUIDELINES

### Hotel Photographs

- **Use REAL Hotel Rose Palace photos** when available
- **DO NOT use stock photos** without clear attribution
- **Mark sample photos as "PLACEHOLDER"** until replaced
- **Image Quality:** High-resolution, professional photography
- **Image Format:** JPEG for photos, PNG for graphics
- **Minimum Width:** 1200px for hero images, 600px for cards

### Icon Guidelines

- **Icon Set:** Use Font Awesome 6 or Bootstrap Icons (consistent)
- **Icon Size:** 24px for navigation, 32px for features
- **Icon Color:** Deep Navy or Muted Gold based on context
- **Icon Style:** Filled for active states, outlined for inactive

### Image Optimization

- Compress all images before upload
- Use responsive image sizes (srcset)
- Lazy load images below the fold
- WebP format where browser support exists
- Maximum file size: 200KB per image

---

## ADMIN DASHBOARD DESIGN

### Color Scheme for Admin

- **Primary:** Deep Navy (`#1a2332`)
- **Sidebar:** Slightly lighter Navy (`#2a3a4a`)
- **Backgrounds:** Warm Ivory (`#f5f3f0`)
- **Accents:** Muted Gold (`#c9a961`)
- **Tables:** Alternating row colors for readability
- **Success:** Green for confirmed payments/bookings
- **Warning:** Orange for pending payments
- **Danger:** Red for cancellations/failed payments

### Admin Components

#### Table Design
- **Header:** Deep Navy background, white text
- **Rows:** Alternating white and very light gray
- **Hover:** Light gold background
- **Actions:** Icon buttons (edit, delete, view)

#### Payment Status Badges
- **Paid:** Green background, white text
- **Pending:** Orange background, white text
- **Failed:** Red background, white text
- **Refunded:** Blue background, white text
- **Partially Refunded:** Light blue background, dark text

#### Booking Status Badges
- **Enquiry:** Gray badge
- **Availability Pending:** Yellow badge
- **Awaiting Payment:** Orange badge
- **Confirmed:** Green badge
- **Cancelled:** Red badge

#### Form Fields in Admin
- **Input Height:** 40px
- **Input Border:** 1px solid Light Gray
- **Label:** 14px, 600 weight, Deep Navy
- **Required Fields:** Red asterisk

#### Action Buttons in Admin
- **Edit:** Blue icon button
- **Delete:** Red icon button with confirmation
- **View:** Gray icon button
- **Status Update:** Color-coded buttons
- **Generate Payment Link:** Gold button
- **Initiate Refund:** Blue button with confirmation

---

## DIRECT BOOKING SYSTEM UI/UX DESIGN

### Overview

The direct booking system replaces the enquiry-based workflow with a seamless online booking experience. Customers can search for rooms, book directly, verify their identity via OTP, and pay—all without creating an account or waiting for manual approval.

### Design Principles for Booking System

1. **Frictionless:** Minimize steps between room search and booking confirmation
2. **Trustworthy:** Clear pricing, secure payment indicators, transparent policies
3. **Mobile-First:** Optimized for mobile booking experience
4. **Accessible:** WCAG 2.1 AA compliant, keyboard navigable, screen reader friendly
5. **Transparent:** Real-time availability, clear total costs, no hidden fees

---

### 1. ROOM SEARCH & AVAILABILITY INTERFACE

#### Desktop Layout
```
┌─────────────────────────────────────────────────────────┐
│  SEARCH FOR AVAILABLE ROOMS                             │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Check-in Date    Check-out Date    Guests    [Search]  │
│  [📅 15 Nov 2026] [📅 18 Nov 2026]  [👤 2]             │
│                                                          │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  AVAILABLE ROOMS (3 nights: Nov 15-18, 2026)            │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌──────────────────────────────────────────────────┐  │
│  │ [Image]  DELUXE ROOM                              │  │
│  │          Max 2 Adults · 300 sq ft · King Bed      │  │
│  │          ✓ Free WiFi ✓ AC ✓ TV ✓ Room Service   │  │
│  │                                                    │  │
│  │          ₹1,725/night × 3 nights = ₹5,175        │  │
│  │          + GST (12%): ₹621                        │  │
│  │          Total: ₹5,796                            │  │
│  │                                                    │  │
│  │          5 rooms available                         │  │
│  │          [  - ]  1  [ + ]     [Book Now]         │  │
│  └──────────────────────────────────────────────────┘  │
│                                                          │
│  ┌──────────────────────────────────────────────────┐  │
│  │ [Image]  EXECUTIVE SUITE                          │  │
│  │          Max 3 Adults · 450 sq ft · King + Sofa   │  │
│  │          ... (similar structure)                   │  │
│  └──────────────────────────────────────────────────┘  │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Mobile Layout
```
┌──────────────────┐
│ SEARCH ROOMS     │
├──────────────────┤
│ Check-in         │
│ [📅 15 Nov 2026] │
│                  │
│ Check-out        │
│ [📅 18 Nov 2026] │
│                  │
│ Guests  [👤 2]   │
│                  │
│ [Search]         │
└──────────────────┘

┌──────────────────┐
│ AVAILABLE (3N)   │
├──────────────────┤
│ ┌──────────────┐ │
│ │ [Image]      │ │
│ │ DELUXE ROOM  │ │
│ │ 2 Adults·300'│ │
│ │              │ │
│ │ ₹1,725/night │ │
│ │ Total: ₹5,796│ │
│ │              │ │
│ │ 5 available  │ │
│ │ Qty: [- 1 +] │ │
│ │ [Book Now]   │ │
│ └──────────────┘ │
└──────────────────┘
```

**Design Elements:**
- **Date Picker:** Calendar with disabled past dates, today's date highlighted
- **Guest Selector:** Dropdown with adults (1-4) and children (0-4)
- **Availability Cards:** Room image, category name, amenities icons, pricing breakdown
- **Quantity Selector:** Decrease/increase buttons, current quantity display
- **Real-Time Updates:** Availability refreshes on date/guest changes
- **Loading States:** Skeleton cards during search
- **Empty State:** "No rooms available for selected dates" with alternative dates suggestion

**Color Scheme:**
- Primary Button (Book Now): Muted Gold `#c9a961`
- Card Background: Crisp White `#ffffff`
- Card Border: Light Gray `#e8e6e3`
- Available Badge: Success Green `#27ae60`
- Price Text: Deep Navy `#1a2332`, bold
- Hover Effect: Shadow intensifies, slight scale

---

### 2. BOOKING FORM INTERFACE

#### Desktop Layout
```
┌─────────────────────────────────────────────────────────┐
│  COMPLETE YOUR BOOKING                                   │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌─ ROOM DETAILS ─────────────────────────────────────┐ │
│  │  Deluxe Room × 1                                    │ │
│  │  Check-in: Nov 15, 2026 (12:00 PM)                 │ │
│  │  Check-out: Nov 18, 2026 (11:00 AM)                │ │
│  │  3 Nights · 2 Adults                                │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ GUEST INFORMATION ─────────────────────────────────┐ │
│  │  Full Name *                                        │ │
│  │  [____________________________________]             │ │
│  │                                                      │ │
│  │  Mobile Number *                                    │ │
│  │  [+91] [__________]                                 │ │
│  │  ℹ️ OTP will be sent for verification              │ │
│  │                                                      │ │
│  │  Email Address                                      │ │
│  │  [____________________________________]             │ │
│  │  (Optional - for booking confirmation)              │ │
│  │                                                      │ │
│  │  Number of Adults * [2]  Children [0]               │ │
│  │                                                      │ │
│  │  Special Requests (Optional)                        │ │
│  │  [____________________________________]             │ │
│  │  [____________________________________]             │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ PRICE SUMMARY ─────────────────────────────────────┐ │
│  │  Room Charges (3 nights)        ₹5,175              │ │
│  │  GST (12%)                      ₹621                │ │
│  │  ─────────────────────────────────────              │ │
│  │  Total Amount                   ₹5,796              │ │
│  │                                                      │ │
│  │  ✓ 100% Payment Required                            │ │
│  │  ✓ Instant Confirmation                             │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  [ ] I agree to the cancellation policy and terms       │
│                                                          │
│  [Proceed to Payment]                                    │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Mobile Layout
```
┌──────────────────┐
│ YOUR BOOKING     │
├──────────────────┤
│ Deluxe Room × 1  │
│ Nov 15-18, 2026  │
│ 3 Nights · 2 Adl │
├──────────────────┤
│ GUEST INFO       │
│                  │
│ Name *           │
│ [____________]   │
│                  │
│ Mobile *         │
│ [+91][_______]   │
│ OTP verification │
│                  │
│ Email            │
│ [____________]   │
│                  │
│ Adults [2]       │
│ Children [0]     │
│                  │
│ Requests         │
│ [____________]   │
├──────────────────┤
│ PRICE SUMMARY    │
│                  │
│ Charges  ₹5,175  │
│ GST(12%) ₹621    │
│ ─────────────    │
│ Total    ₹5,796  │
│                  │
│ ✓ 100% Payment   │
│ ✓ Instant Conf.  │
├──────────────────┤
│ [ ] I agree      │
│                  │
│ [Proceed]        │
└──────────────────┘
```

**Design Elements:**
- **Section Headers:** Bold, 16px, Deep Navy
- **Required Fields:** Red asterisk, clear indication
- **Mobile Input:** Country code dropdown, 10-digit number
- **OTP Info:** Small info text with icon
- **Validation:** Real-time inline validation
- **Error Messages:** Red text below field, clear instructions
- **Price Summary Card:** Sticky on scroll (desktop), highlighted background
- **Terms Checkbox:** Must be checked to enable button
- **Button State:** Disabled (gray) until form valid, enabled (gold)

---

### 3. OTP VERIFICATION SCREENS

#### Send OTP Screen
```
┌─────────────────────────────────────────────────────────┐
│  🔐 VERIFY YOUR MOBILE NUMBER                            │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  We'll send a One-Time Password (OTP) to verify         │
│  your mobile number: +91 98765 43210                    │
│                                                          │
│  The OTP is valid for 5 minutes.                        │
│                                                          │
│  [Send OTP]                                              │
│                                                          │
│  [← Back to Booking Form]                               │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Verify OTP Screen
```
┌─────────────────────────────────────────────────────────┐
│  🔐 ENTER OTP                                            │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  We've sent a 6-digit OTP to                            │
│  +91 98765 43210                                        │
│                                                          │
│  Enter OTP:                                             │
│  ┌───┬───┬───┬───┬───┬───┐                            │
│  │ _ │ _ │ _ │ _ │ _ │ _ │                            │
│  └───┴───┴───┴───┴───┴───┘                            │
│                                                          │
│  [Verify OTP]                                            │
│                                                          │
│  Didn't receive OTP?                                    │
│  [Resend OTP] (available in 0:45)                       │
│                                                          │
│  [← Change Mobile Number]                               │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Mobile OTP Screen
```
┌──────────────────┐
│ 🔐 VERIFY MOBILE │
├──────────────────┤
│ OTP sent to:     │
│ +91 98765 43210  │
│                  │
│ Enter OTP:       │
│ ┌─┬─┬─┬─┬─┬─┐   │
│ │ │ │ │ │ │ │   │
│ └─┴─┴─┴─┴─┴─┘   │
│                  │
│ [Verify]         │
│                  │
│ No OTP?          │
│ [Resend] (0:45)  │
│                  │
│ [← Change No.]   │
└──────────────────┘
```

**Design Elements:**
- **Lock Icon:** Security indicator
- **Mobile Number:** Masked display (last 4 digits visible)
- **OTP Inputs:** 6 individual boxes, auto-focus next
- **Countdown Timer:** Resend button disabled with countdown
- **Loading State:** "Sending OTP..." / "Verifying..."
- **Error States:** "Invalid OTP" / "OTP Expired" with retry
- **Success State:** Green checkmark, "Verified!" message
- **Auto-Submit:** OTP verifies automatically when 6 digits entered

**Color Scheme:**
- Background: Light Ivory `#f5f3f0`
- Input Boxes: White with gray border
- Active Input: Gold border
- Error: Red border + red text
- Success: Green checkmark
- Button: Gold when enabled, gray when disabled

---

### 4. PAYMENT CHECKOUT INTEGRATION

#### Razorpay Checkout Modal (Embedded)
```
┌─────────────────────────────────────────────────────────┐
│  [Hotel Logo]  Hotel Rose Palace                        │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Complete Payment                                        │
│  ₹5,796.00                                              │
│                                                          │
│  Booking: Deluxe Room                                   │
│  Nov 15-18, 2026 (3 nights)                            │
│                                                          │
│  [Razorpay Checkout Interface]                          │
│  - Card / UPI / Netbanking / Wallet tabs                │
│  - Payment method selection                             │
│  - Razorpay standard UI                                 │
│                                                          │
│  🔒 Secured by Razorpay                                 │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

**Design Elements:**
- **Pre-fill:** Customer name, email, mobile
- **Amount:** Clearly displayed, read-only
- **Description:** Booking details summary
- **Theme:** Matches hotel color scheme
- **Razorpay Branding:** Standard security indicators
- **Modal:** Centered, backdrop overlay

**Razorpay Configuration:**
```javascript
{
  key: 'rzp_live_xxxxx',
  amount: 579600, // in paise
  currency: 'INR',
  name: 'Hotel Rose Palace',
  description: 'Deluxe Room - Nov 15-18, 2026',
  image: '/images/logo.png',
  prefill: {
    name: 'Customer Name',
    email: 'customer@example.com',
    contact: '9876543210'
  },
  theme: {
    color: '#c9a961' // Muted Gold
  }
}
```

---

### 5. BOOKING CONFIRMATION PAGE

#### Success Screen (Desktop)
```
┌─────────────────────────────────────────────────────────┐
│  ✅ BOOKING CONFIRMED!                                   │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Thank you! Your booking has been confirmed.            │
│                                                          │
│  ┌─ BOOKING DETAILS ──────────────────────────────────┐ │
│  │  Booking Reference: BK-2026-001234                  │ │
│  │  Guest Name: Rajesh Kumar                           │ │
│  │  Mobile: +91 98765 43210                            │ │
│  │  Email: rajesh@example.com                          │ │
│  │                                                      │ │
│  │  Room: Deluxe Room × 1                              │ │
│  │  Check-in: Nov 15, 2026, 12:00 PM                  │ │
│  │  Check-out: Nov 18, 2026, 11:00 AM                 │ │
│  │  Guests: 2 Adults                                   │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ PAYMENT DETAILS ───────────────────────────────────┐ │
│  │  Payment ID: pay_xxxxxxxxxxxxx                      │ │
│  │  Amount Paid: ₹5,796.00                             │ │
│  │  Payment Method: Credit Card                        │ │
│  │  Date: Nov 13, 2026, 3:45 PM                       │ │
│  │  Status: ✅ Paid                                    │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  📧 Confirmation email sent to rajesh@example.com       │
│  📱 SMS sent to +91 98765 43210                         │
│                                                          │
│  [Download Confirmation] [View My Bookings]             │
│                                                          │
│  ┌─ CANCELLATION POLICY ───────────────────────────────┐ │
│  │  ✓ Free cancellation until Nov 14, 12:00 PM        │ │
│  │    (24 hours before check-in = 100% refund)         │ │
│  │  ✓ Cancellation after Nov 14, 12:00 PM             │ │
│  │    (Less than 24 hours = 50% refund)                │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  Need help? Contact us:                                 │
│  📞 +91 70424 24242 | 📧 info@hotelrosepalace.com       │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Mobile Success Screen
```
┌──────────────────┐
│ ✅ CONFIRMED!    │
├──────────────────┤
│ Thank you!       │
│                  │
│ Ref: BK-001234   │
│ Rajesh Kumar     │
│ +91 98765 43210  │
│                  │
│ Deluxe Room × 1  │
│ Nov 15-18, 2026  │
│ 2 Adults         │
├──────────────────┤
│ PAYMENT          │
│ ₹5,796 Paid ✅   │
│ Card ending 4242 │
│ Nov 13, 3:45 PM  │
├──────────────────┤
│ 📧 Email sent    │
│ 📱 SMS sent      │
│                  │
│ [Download]       │
│ [My Bookings]    │
├──────────────────┤
│ CANCELLATION     │
│ Free until       │
│ Nov 14, 12 PM    │
│ (100% refund)    │
│                  │
│ After: 50%       │
├──────────────────┤
│ 📞 Help          │
│ +91 70424 24242  │
└──────────────────┘
```

**Design Elements:**
- **Success Icon:** Large green checkmark, celebratory
- **Booking Reference:** Prominent, bold, copyable
- **Details Cards:** White background, subtle shadow
- **Status Badge:** Green "Paid" badge with checkmark
- **Action Buttons:** Download PDF, View bookings
- **Policy Display:** Clear, highlighted, easy to understand
- **Contact Info:** Always visible for support
- **Print-Friendly:** Clean layout for printing

---

### 6. "MY BOOKINGS" CUSTOMER PORTAL

#### Login Screen (OTP Access)
```
┌─────────────────────────────────────────────────────────┐
│  MY BOOKINGS                                             │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  View and manage your bookings                          │
│                                                          │
│  Enter your mobile number to access your bookings:      │
│                                                          │
│  Mobile Number                                          │
│  [+91] [__________]                                     │
│                                                          │
│  [Continue]                                              │
│                                                          │
│  ℹ️ We'll send you an OTP to verify your identity      │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Bookings List Screen
```
┌─────────────────────────────────────────────────────────┐
│  MY BOOKINGS | +91 98765 43210 | [Logout]               │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌─ UPCOMING BOOKINGS ─────────────────────────────────┐ │
│  │                                                      │ │
│  │  ┌────────────────────────────────────────────────┐ │ │
│  │  │ [Room Image]  BK-2026-001234                   │ │ │
│  │  │               Deluxe Room × 1                  │ │ │
│  │  │               Nov 15-18, 2026 (3 nights)       │ │ │
│  │  │               2 Adults                         │ │ │
│  │  │               Status: ✅ Confirmed             │ │ │
│  │  │               Amount: ₹5,796 (Paid)            │ │ │
│  │  │                                                 │ │ │
│  │  │               [View Details] [Cancel Booking]  │ │ │
│  │  └────────────────────────────────────────────────┘ │ │
│  │                                                      │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ PAST BOOKINGS ──────────────────────────────────────┐ │
│  │                                                      │ │
│  │  ┌────────────────────────────────────────────────┐ │ │
│  │  │ BK-2026-000123 | Executive Suite                │ │ │
│  │  │ Oct 10-12, 2026 | ✅ Completed                 │ │ │
│  │  │ [View Details]                                  │ │ │
│  │  └────────────────────────────────────────────────┘ │ │
│  │                                                      │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Booking Details Screen
```
┌─────────────────────────────────────────────────────────┐
│  ← Back to My Bookings                                   │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  BOOKING DETAILS                                         │
│                                                          │
│  ┌─ BOOKING INFORMATION ───────────────────────────────┐ │
│  │  Reference: BK-2026-001234                          │ │
│  │  Status: ✅ Confirmed                               │ │
│  │  Booked on: Nov 13, 2026, 3:45 PM                  │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ GUEST DETAILS ─────────────────────────────────────┐ │
│  │  Name: Rajesh Kumar                                 │ │
│  │  Mobile: +91 98765 43210                            │ │
│  │  Email: rajesh@example.com                          │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ ROOM DETAILS ──────────────────────────────────────┐ │
│  │  Room: Deluxe Room × 1                              │ │
│  │  Check-in: Nov 15, 2026, 12:00 PM                  │ │
│  │  Check-out: Nov 18, 2026, 11:00 AM                 │ │
│  │  Duration: 3 Nights                                 │ │
│  │  Guests: 2 Adults, 0 Children                       │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ PAYMENT DETAILS ───────────────────────────────────┐ │
│  │  Room Charges: ₹5,175                               │ │
│  │  GST (12%): ₹621                                    │ │
│  │  Total Paid: ₹5,796                                 │ │
│  │  Payment Status: ✅ Paid                            │ │
│  │  Payment ID: pay_xxxxxxxxxxxxx                      │ │
│  │  Payment Date: Nov 13, 2026, 3:45 PM               │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ CANCELLATION POLICY ───────────────────────────────┐ │
│  │  ✓ Free cancellation until Nov 14, 12:00 PM        │ │
│  │  ✓ 100% refund if cancelled before deadline         │ │
│  │  ✓ 50% refund if cancelled after deadline          │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  [Cancel This Booking]                                   │
│                                                          │
│  [Download Receipt] [Contact Hotel]                      │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

**Design Elements:**
- **Session Management:** 2-hour timeout, extend on activity
- **Status Badges:** Colored badges (Confirmed=Green, Cancelled=Red, Completed=Gray)
- **Booking Cards:** Clickable, hover effect, image thumbnail
- **Filters:** Upcoming / Past / Cancelled
- **Empty State:** "No bookings found" with illustration
- **Logout:** Clear logout button, clears session
- **Mobile Responsive:** Single column, swipeable cards

---

### 7. CANCELLATION & REFUND INTERFACE

#### Cancellation Confirmation Modal
```
┌─────────────────────────────────────────────────────────┐
│  ⚠️ CANCEL BOOKING                                       │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Are you sure you want to cancel this booking?          │
│                                                          │
│  Booking: BK-2026-001234                                │
│  Room: Deluxe Room                                      │
│  Dates: Nov 15-18, 2026                                 │
│                                                          │
│  ┌─ REFUND CALCULATION ────────────────────────────────┐ │
│  │                                                      │ │
│  │  Original Amount: ₹5,796                            │ │
│  │                                                      │ │
│  │  Time until check-in: 47 hours 15 minutes           │ │
│  │  ✓ Eligible for 100% refund                        │ │
│  │                                                      │ │
│  │  Refund Amount: ₹5,796                              │ │
│  │  (Refund will be processed to original payment)     │ │
│  │                                                      │ │
│  │  Processing Time: 5-7 business days                 │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  Reason for cancellation (Optional):                    │
│  [___________________________________________]           │
│                                                          │
│  [Cancel Booking]  [Keep Booking]                       │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Partial Refund Scenario
```
┌─────────────────────────────────────────────────────────┐
│  ⚠️ CANCEL BOOKING                                       │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌─ REFUND CALCULATION ────────────────────────────────┐ │
│  │                                                      │ │
│  │  Original Amount: ₹5,796                            │ │
│  │                                                      │ │
│  │  Time until check-in: 15 hours 30 minutes           │ │
│  │  ⚠️ Less than 24 hours                              │ │
│  │                                                      │ │
│  │  Refund: 50% (Cancellation Policy)                  │ │
│  │  Refund Amount: ₹2,898                              │ │
│  │  Deduction: ₹2,898                                  │ │
│  │                                                      │ │
│  │  Processing Time: 5-7 business days                 │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  [Confirm Cancellation]  [Go Back]                      │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Cancellation Success Screen
```
┌─────────────────────────────────────────────────────────┐
│  ✅ BOOKING CANCELLED                                    │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Your booking has been cancelled successfully.          │
│                                                          │
│  Booking Reference: BK-2026-001234                      │
│  Cancelled on: Nov 13, 2026, 4:15 PM                   │
│                                                          │
│  ┌─ REFUND DETAILS ────────────────────────────────────┐ │
│  │                                                      │ │
│  │  Refund Amount: ₹5,796                              │ │
│  │  Refund Status: 🔄 Processing                       │ │
│  │  Estimated Time: 5-7 business days                  │ │
│  │  Refund Method: Original payment method             │ │
│  │                                                      │ │
│  │  Refund ID: rfnd_xxxxxxxxxxxxx                      │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  📧 Cancellation confirmation sent to your email        │
│  📱 SMS notification sent to your mobile                │
│                                                          │
│  [Track Refund Status] [Back to My Bookings]            │
│                                                          │
│  Need help? Contact us: +91 70424 24242                 │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

#### Refund Status Display
```
┌─────────────────────────────────────────────────────────┐
│  REFUND STATUS                                           │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Booking: BK-2026-001234                                │
│  Refund ID: rfnd_xxxxxxxxxxxxx                          │
│                                                          │
│  ┌──────────────────────────────────────────────────────┐│
│  │  ● Processing Refund             Nov 13, 4:15 PM    ││
│  │  │                                                    ││
│  │  ● Refund Initiated              Nov 13, 4:16 PM    ││
│  │  │                                                    ││
│  │  ○ Refund Processed              Pending...          ││
│  │                                                       ││
│  └──────────────────────────────────────────────────────┘│
│                                                          │
│  Amount: ₹5,796                                         │
│  Method: Original payment (Card ending 4242)            │
│  Expected by: Nov 20, 2026                              │
│                                                          │
│  [Back to My Bookings]                                   │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

**Design Elements:**
- **Warning Icon:** Triangle with exclamation for destructive action
- **Countdown:** Real-time calculation of refund percentage
- **Refund Breakdown:** Clear display of original, refund, deduction
- **Confirmation:** Two-step process (modal + confirmation button)
- **Status Timeline:** Visual progress indicator for refund
- **Color Coding:**
  - Processing: Blue `#3498db`
  - Processed/Success: Green `#27ae60`
  - Failed: Red `#e74c3c`
  - Warning: Orange `#f39c12`

---

### 8. ADMIN BOOKING MANAGEMENT DASHBOARD

#### Booking List (Admin)
```
┌─────────────────────────────────────────────────────────────────────────────┐
│  BOOKINGS MANAGEMENT                                                        │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                              │
│  [All] [Upcoming] [Today Check-in] [Today Check-out] [Cancelled]           │
│                                                                              │
│  Search: [________________]  Dates: [From] [To]  [Filter]                  │
│                                                                              │
│  ┌───────────────────────────────────────────────────────────────────────┐ │
│  │ Ref       │ Guest     │ Room      │ Check-in  │ Status  │ Amount │ Actions │ │
│  ├───────────────────────────────────────────────────────────────────────┤ │
│  │ BK-001234 │ Rajesh K. │ Deluxe×1  │ Nov 15    │ ✅ Conf │ ₹5,796 │ [View]  │ │
│  │           │ +9198765  │ 3 nights  │ 2:00 PM   │ 💳 Paid │        │ [Check] │ │
│  ├───────────────────────────────────────────────────────────────────────┤ │
│  │ BK-001235 │ Priya S.  │ Exec×1    │ Nov 16    │ ❌ Canc │ ₹8,500 │ [View]  │ │
│  │           │ +9187654  │ 2 nights  │           │ 💰Rfnd  │        │         │ │
│  └───────────────────────────────────────────────────────────────────────┘ │
│                                                                              │
│  Showing 1-20 of 145 bookings  [Previous] [1] [2] [3] [Next]               │
│                                                                              │
└─────────────────────────────────────────────────────────────────────────────┘
```

#### Booking Details (Admin View)
```
┌─────────────────────────────────────────────────────────┐
│  ← Back to Bookings List                                 │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  BOOKING: BK-2026-001234                                 │
│  Status: ✅ Confirmed & Paid                            │
│                                                          │
│  ┌─ CUSTOMER ──────────────────────────────────────────┐ │
│  │  Name: Rajesh Kumar                                 │ │
│  │  Mobile: +91 98765 43210  [Call] [WhatsApp]         │ │
│  │  Email: rajesh@example.com  [Email]                 │ │
│  │  Mobile Verified: ✅ Yes (Nov 13, 3:40 PM)          │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ RESERVATION ───────────────────────────────────────┐ │
│  │  Room Category: Deluxe Room                         │ │
│  │  Quantity: 1 room                                   │ │
│  │  Allocated Room: Room 103  [Change Room]            │ │
│  │  Check-in: Nov 15, 2026, 12:00 PM                  │ │
│  │  Check-out: Nov 18, 2026, 11:00 AM                 │ │
│  │  Nights: 3                                          │ │
│  │  Guests: 2 Adults, 0 Children                       │ │
│  │  Special Requests: Late check-in (~10 PM)           │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ PAYMENT ───────────────────────────────────────────┐ │
│  │  Total Amount: ₹5,796                               │ │
│  │  Payment ID: pay_xxxxxxxxxxxxx  [View in Razorpay]  │ │
│  │  Payment Status: ✅ Captured                        │ │
│  │  Payment Method: Credit Card (Visa ending 4242)     │ │
│  │  Payment Date: Nov 13, 2026, 3:45 PM               │ │
│  │  Order ID: order_xxxxxxxxxxxxx                      │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌─ TIMELINE ──────────────────────────────────────────┐ │
│  │  ● Booking Created        Nov 13, 3:38 PM           │ │
│  │  ● Mobile Verified (OTP)  Nov 13, 3:40 PM           │ │
│  │  ● Room Reserved          Nov 13, 3:40 PM           │ │
│  │  ● Payment Initiated      Nov 13, 3:43 PM           │ │
│  │  ● Payment Completed      Nov 13, 3:45 PM           │ │
│  │  ● Booking Confirmed      Nov 13, 3:45 PM           │ │
│  │  ● Room Allocated (103)   Nov 13, 3:45 PM           │ │
│  └─────────────────────────────────────────────────────┘ │
│                                                          │
│  [Mark as Checked-In] [Cancel Booking] [Send Email]      │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

**Design Elements:**
- **Status Badges:** Color-coded with icons
  - Confirmed: Green with checkmark
  - Cancelled: Red with X
  - Checked-in: Blue with door icon
  - Checked-out: Gray with checkmark
- **Quick Actions:** Call, WhatsApp, Email buttons
- **Room Allocation:** Editable, shows physical room number
- **Timeline:** Vertical timeline with timestamps
- **Admin Actions:** Check-in, Cancel, Modify, Email
- **Razorpay Link:** Direct link to transaction in Razorpay dashboard

---

### 9. STATUS INDICATORS & BADGES

#### Booking Status Badges
```css
/* Confirmed Booking */
.badge-confirmed {
  background: #27ae60;
  color: white;
  padding: 4px 12px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
}

/* Pending Payment */
.badge-pending {
  background: #f39c12;
  color: white;
}

/* Cancelled */
.badge-cancelled {
  background: #e74c3c;
  color: white;
}

/* Checked-In */
.badge-checked-in {
  background: #3498db;
  color: white;
}

/* Completed */
.badge-completed {
  background: #95a5a6;
  color: white;
}
```

#### Payment Status Badges
```css
/* Paid */
.badge-paid {
  background: #27ae60;
  color: white;
}

/* Processing */
.badge-processing {
  background: #3498db;
  color: white;
}

/* Failed */
.badge-failed {
  background: #e74c3c;
  color: white;
}

/* Refunded */
.badge-refunded {
  background: #5dade2;
  color: white;
}

/* Partially Refunded */
.badge-partial-refund {
  background: #f39c12;
  color: white;
}
```

---

### 10. RESPONSIVE DESIGN ADJUSTMENTS

#### Mobile Booking Flow Optimizations
1. **Single Column Layout:** All forms single column on mobile
2. **Sticky Bottom Bar:** Total amount and "Book Now" button sticky at bottom
3. **Collapsible Sections:** Room details, price breakdown collapsible
4. **Touch-Friendly:** Minimum 44px tap targets
5. **Simplified Navigation:** Breadcrumbs hidden, back button prominent
6. **Optimized Inputs:** Native mobile keyboards (number, email, tel)
7. **Reduced Animations:** Faster, simpler transitions on mobile

#### Tablet Layout (768px - 1024px)
1. **Two-Column Forms:** Guest info + Price summary side-by-side
2. **Card Grid:** 2 rooms per row in availability view
3. **Modal Adjustments:** Modals take 80% width, not full screen
4. **Sidebar Visible:** Admin sidebar remains visible

---

### 11. LOADING & ERROR STATES

#### Loading Skeletons
```
┌──────────────────────────────────────┐
│ ░░░░░░░░░░░░░░░░░░░░░░░░░░          │  (Room card skeleton)
│ ░░░░░░░░░░░░                         │
│ ░░░░░░░░░░░░░░░░░░░░                 │
│ ░░░░░░░  ░░░░░░░  [░░░░░░░]         │
└──────────────────────────────────────┘
```

#### Error Messages
```
┌──────────────────────────────────────┐
│ ⚠️ BOOKING FAILED                    │
│                                       │
│ We couldn't process your booking.    │
│                                       │
│ Reason: Payment verification failed  │
│                                       │
│ Your payment was not charged.        │
│                                       │
│ [Try Again] [Contact Support]        │
└──────────────────────────────────────┘
```

#### No Results State
```
┌──────────────────────────────────────┐
│                                       │
│         🏨                            │
│                                       │
│    No rooms available                │
│    for selected dates                │
│                                       │
│  Try different dates or guest count  │
│                                       │
│  [Modify Search]                      │
│                                       │
└──────────────────────────────────────┘
```

---

### 12. ACCESSIBILITY FEATURES

#### Keyboard Navigation
- Tab order: Search form → Room cards → Booking button → Form inputs → Submit
- Enter key: Submits forms, activates buttons
- Escape key: Closes modals, cancels actions
- Arrow keys: Navigate OTP inputs

#### Screen Reader Announcements
```html
<div role="alert" aria-live="polite">
  Booking confirmed successfully
</div>

<div role="status" aria-live="polite">
  Searching for available rooms...
</div>

<button aria-label="Cancel booking BK-2026-001234">
  Cancel
</button>
```

#### Focus Management
- Focus moves to first error on validation failure
- Focus trapped in modals
- Skip links for main content
- Visible focus indicators (gold outline)

---

## DESIGN CHECKLIST FOR DIRECT BOOKING SYSTEM

#### Booking Approval Interface
**Layout:**
```
┌────────────────────────────────────────────┐
│ BOOKING APPROVAL - ENQ-2026-001234          │
├────────────────────────────────────────────┤
│                                             │
│ Customer: Rajesh Kumar                      │
│ Phone: +91 98765 43210                      │
│ Room Type: Deluxe Family Room               │
│ Check-in: 20 Nov 2026                       │
│ Check-out: 22 Nov 2026                      │
│ Nights: 2                                   │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ MANUAL AVAILABILITY CHECK            │   │
│ │ [ ] Room 101 Available               │   │
│ │ [ ] Room 102 Available               │   │
│ │ [✓] Room 103 Available (Selected)    │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ Base Rate: ₹1,725 x 2 nights = ₹3,450     │
│ GST (12%): ₹414                            │
│ ┌─────────────────────────────────────┐   │
│ │ Final Amount: ₹3,864                 │   │
│ │ [Input] (Admin can adjust)           │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ [Reject Enquiry]  [Approve & Generate Link]│
│                                             │
└────────────────────────────────────────────┘
```

**Design Elements:**
- Clean card-based layout
- Clear booking summary section
- Manual room selection checkboxes
- Editable final amount input (with validation)
- Prominent approve/reject buttons
- Color-coded status indicators

#### Payment Link Management Dashboard
**Features:**
- **Generate Payment Link** button (gold, prominent)
- **Copy Link** button (with clipboard icon)
- **Share via WhatsApp** button (green, WhatsApp icon)
- **Regenerate Link** option (for expired links)
- **Revoke Link** option (red, with confirmation)
- **Link Status** indicator (Active / Expired / Used / Revoked)
- **Link Expiry Countdown** (e.g., "Expires in 47 hours")
- **Payment Status** badge (Pending / Paid / Failed)

**Table Layout:**
```
┌──────────────────────────────────────────────────────────────────┐
│ Booking Ref  │ Customer  │ Amount  │ Link Status │ Payment Status │ Actions │
├──────────────────────────────────────────────────────────────────┤
│ ENQ-001234   │ Rajesh K. │ ₹3,864  │ 🟢 Active  │ ⏳ Pending    │ [Copy][WhatsApp][Revoke] │
│              │           │         │ Exp: 23h   │                │                           │
├──────────────────────────────────────────────────────────────────┤
│ ENQ-001233   │ Priya S.  │ ₹5,198  │ ✅ Used    │ ✅ Paid       │ [View Payment] │
├──────────────────────────────────────────────────────────────────┤
│ ENQ-001232   │ Amit P.   │ ₹2,950  │ ⚠️ Expired │ ❌ Unpaid     │ [Regenerate] │
└──────────────────────────────────────────────────────────────────┘
```

### Customer Payment Page Design

#### Secure Payment Page Layout
```
┌────────────────────────────────────────────┐
│     🏨 HOTEL ROSE PALACE                    │
│     Secure Payment Page                     │
├────────────────────────────────────────────┤
│                                             │
│ ✅ BOOKING APPROVED                        │
│ Your reservation has been confirmed         │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ BOOKING SUMMARY                      │   │
│ │                                      │   │
│ │ Booking Ref: ENQ-2026-001234         │   │
│ │ Customer: Rajesh Kumar               │   │
│ │ Phone: +91 98765 43210               │   │
│ │                                      │   │
│ │ Room: Deluxe Family Room (Room 103)  │   │
│ │ Check-in: 20 Nov 2026, 12:00 PM      │   │
│ │ Check-out: 22 Nov 2026, 11:00 AM     │   │
│ │ Nights: 2                            │   │
│ │ Guests: 2 Adults, 0 Children         │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ PAYMENT BREAKDOWN                    │   │
│ │                                      │   │
│ │ Room Tariff    ₹3,450.00             │   │
│ │ CGST (6%)      ₹207.00               │   │
│ │ SGST (6%)      ₹207.00               │   │
│ │ ─────────────────────────            │   │
│ │ Total Amount   ₹3,864.00             │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ ⚠️ 100% FULL PAYMENT REQUIRED            │
│                                             │
│ ℹ️ This payment link expires in:          │
│ ⏰ 47 hours 23 minutes                    │
│                                             │
│ [   PAY NOW ₹3,864   ]                    │
│   (Secure Razorpay Checkout)               │
│                                             │
│ 🔒 Your payment is 100% secure             │
│ Powered by Razorpay                         │
│                                             │
└────────────────────────────────────────────┘
```

**Design Features:**
- Hotel Rose Palace branding at top
- Clear "Booking Approved" status indicator
- Comprehensive booking summary card
- Detailed payment breakdown
- Prominent "100% Full Payment Required" notice
- Link expiry countdown timer
- Large, gold "PAY NOW" button
- Security indicators (lock icon, Razorpay badge)
- Clean, professional layout
- Mobile-responsive design

#### Payment Page - Mobile View
```
┌──────────────────┐
│ 🏨 Hotel Rose    │
│ Secure Payment   │
├──────────────────┤
│                  │
│ ✅ BOOKING       │
│ APPROVED         │
│                  │
│ ┌──────────────┐ │
│ │ SUMMARY      │ │
│ │              │ │
│ │ Ref: EN-1234 │ │
│ │ Rajesh Kumar │ │
│ │ Deluxe Room  │ │
│ │ 20-22 Nov    │ │
│ │ 2 Nights     │ │
│ └──────────────┘ │
│                  │
│ ┌──────────────┐ │
│ │ AMOUNT       │ │
│ │              │ │
│ │ Tariff 3,450 │ │
│ │ GST    414   │ │
│ │ ─────────    │ │
│ │ Total  3,864 │ │
│ └──────────────┘ │
│                  │
│ ⚠️ 100% Full    │
│ Payment Required │
│                  │
│ ⏰ Exp: 47h 23m  │
│                  │
│ ┌──────────────┐ │
│ │ PAY ₹3,864   │ │
│ │  NOW         │ │
│ └──────────────┘ │
│                  │
│ 🔒 Secure        │
└──────────────────┘
```

### Payment Result Screens

#### Success Screen
```
┌────────────────────────────────────────────┐
│     ✅ PAYMENT SUCCESSFUL                   │
├────────────────────────────────────────────┤
│                                             │
│     Thank you for your payment!             │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ Payment ID: pay_1234567890           │   │
│ │ Amount Paid: ₹3,864.00               │   │
│ │ Date: 13 Nov 2026, 3:45 PM           │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ ✅ Your booking is now CONFIRMED           │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ BOOKING CONFIRMATION                 │   │
│ │ Booking Ref: ENQ-2026-001234         │   │
│ │ Customer: Rajesh Kumar               │   │
│ │ Room: Deluxe Family Room (103)       │   │
│ │ Check-in: 20 Nov 2026, 12:00 PM      │   │
│ │ Check-out: 22 Nov 2026, 11:00 AM     │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ 📧 Confirmation email sent to:              │
│    rajesh@example.com                       │
│                                             │
│ 📱 For any queries, contact us on WhatsApp: │
│    +91 8866771900                           │
│                                             │
│ [Print Confirmation] [Contact Hotel]        │
│                                             │
└────────────────────────────────────────────┘
```

#### Failure Screen
```
┌────────────────────────────────────────────┐
│     ❌ PAYMENT FAILED                       │
├────────────────────────────────────────────┤
│                                             │
│     We couldn't process your payment        │
│                                             │
│ Reason: Insufficient funds                  │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ Your booking is still reserved       │   │
│ │ Payment link is still active         │   │
│ │ Expires in: 46 hours 15 minutes      │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ You can try again:                          │
│                                             │
│ [Try Again] [Contact Hotel]                 │
│                                             │
│ 📱 Need help? WhatsApp: +91 8866771900      │
│                                             │
└────────────────────────────────────────────┘
```

#### Expired Link Screen
```
┌────────────────────────────────────────────┐
│     ⏰ PAYMENT LINK EXPIRED                 │
├────────────────────────────────────────────┤
│                                             │
│     This payment link has expired           │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ Booking Ref: ENQ-2026-001234         │   │
│ │ Expired on: 12 Nov 2026, 2:30 PM     │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ Your booking reservation has not been       │
│ confirmed.                                  │
│                                             │
│ Please contact the hotel to request a       │
│ new payment link.                           │
│                                             │
│ [Contact Hotel via WhatsApp]                │
│                                             │
│ 📱 WhatsApp: +91 8866771900                 │
│ 📧 Email: Hotelrosepalacesurat@gmail.com   │
│                                             │
└────────────────────────────────────────────┘
```

#### Already Paid Screen
```
┌────────────────────────────────────────────┐
│     ✅ ALREADY PAID                         │
├────────────────────────────────────────────┤
│                                             │
│     This booking has already been paid      │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ Booking Ref: ENQ-2026-001234         │   │
│ │ Payment Date: 10 Nov 2026            │   │
│ │ Amount Paid: ₹3,864.00               │   │
│ │ Status: ✅ CONFIRMED                 │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ Your booking is confirmed.                  │
│ No further payment is required.             │
│                                             │
│ [View Booking Details]                      │
│                                             │
│ 📱 For queries: +91 8866771900              │
│                                             │
└────────────────────────────────────────────┘
```

### Cancellation & Refund UI

#### Cancellation Request Screen (Admin)
```
┌────────────────────────────────────────────┐
│ CANCEL BOOKING - ENQ-2026-001234            │
├────────────────────────────────────────────┤
│                                             │
│ Customer: Rajesh Kumar                      │
│ Check-in: 20 Nov 2026, 12:00 PM             │
│ Paid Amount: ₹3,864.00                      │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ REFUND CALCULATION                   │   │
│ │                                      │   │
│ │ Cancellation Time:                   │   │
│ │ 13 Nov 2026, 10:30 AM                │   │
│ │                                      │   │
│ │ Check-in Time:                       │   │
│ │ 20 Nov 2026, 12:00 PM                │   │
│ │                                      │   │
│ │ Time Before Check-in:                │   │
│ │ 7 days, 1 hour, 30 minutes           │   │
│ │                                      │   │
│ │ ✅ Cancellation > 24 hours           │   │
│ │                                      │   │
│ │ Refund Policy: 100% FULL REFUND      │   │
│ │                                      │   │
│ │ Paid Amount:     ₹3,864.00           │   │
│ │ Refund Amount:   ₹3,864.00           │   │
│ │ Refund %:        100%                │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ ⚠️ This will process a refund through      │
│ Razorpay. This action cannot be undone.     │
│                                             │
│ Cancellation Reason:                        │
│ [ Customer Request                    ▼]    │
│                                             │
│ Internal Notes:                             │
│ [                                      ]    │
│                                             │
│ [Cancel] [Confirm Cancellation & Refund]    │
│                                             │
└────────────────────────────────────────────┘
```

#### Refund Status Tracking (Admin)
```
┌────────────────────────────────────────────┐
│ REFUND DETAILS - ENQ-2026-001234            │
├────────────────────────────────────────────┤
│                                             │
│ Refund ID: rfnd_1234567890                  │
│ Razorpay Refund ID: rfnd_xyz123abc           │
│                                             │
│ ┌─────────────────────────────────────┐   │
│ │ Status: ⏳ PROCESSING                │   │
│ └─────────────────────────────────────┘   │
│                                             │
│ Original Payment: ₹3,864.00                 │
│ Refund Amount: ₹3,864.00 (100%)             │
│ Initiated By: Admin User                    │
│ Initiated At: 13 Nov 2026, 10:45 AM         │
│                                             │
│ Expected Processing Time: 5-7 business days │
│                                             │
│ [Refresh Status] [View Booking]             │
│                                             │
└────────────────────────────────────────────┘
```

### Cancellation Policy Display (Customer-Facing)

#### Policy Information Card
```
┌────────────────────────────────────────────┐
│ 📋 CANCELLATION POLICY                      │
├────────────────────────────────────────────┤
│                                             │
│ We understand plans change. Our fair        │
│ cancellation policy:                        │
│                                             │
│ ✅ CANCEL 24+ HOURS BEFORE CHECK-IN        │
│    • 100% FULL REFUND                       │
│    • Refund within 5-7 business days        │
│                                             │
│ ⚠️ CANCEL LESS THAN 24 HOURS              │
│    • 50% PARTIAL REFUND                     │
│    • Refund within 5-7 business days        │
│                                             │
│ 🕒 Timezone: Asia/Kolkata (IST)            │
│                                             │
│ All refunds are processed through the       │
│ original payment method via Razorpay.       │
│                                             │
│ For cancellation requests, contact us:      │
│ 📱 WhatsApp: +91 8866771900                 │
│ 📧 Email: Hotelrosepalacesurat@gmail.com   │
│                                             │
└────────────────────────────────────────────┘
```

### Payment Security Indicators

#### Trust Badges
- **SSL Secure** badge (lock icon)
- **Razorpay Verified** badge
- **"Your payment is 100% secure"** message
- **PCI DSS Compliant** indicator
- **256-bit encryption** notice

#### Loading States
- Payment processing spinner
- "Processing your payment..." message
- "Please wait, do not refresh..." warning
- "Verifying payment with bank..." status

### Color Coding for Payment States

| State | Color | Badge Style |
|-------|-------|-------------|
| Payment Pending | Orange | `#f39c12` background |
| Payment Processing | Blue | `#3498db` background |
| Payment Successful | Green | `#27ae60` background |
| Payment Failed | Red | `#e74c3c` background |
| Refund Pending | Light Blue | `#5dade2` background |
| Refund Processed | Green | `#27ae60` background |
| Link Active | Green | 🟢 indicator |
| Link Expired | Red | 🔴 indicator |
| Link Used | Gray | ⚪ indicator |

---

## ACCESSIBILITY REQUIREMENTS (WCAG 2.1 Level AA)

1. **Color Contrast:** Minimum 4.5:1 for text, 3:1 for graphics
2. **Focus States:** Visible focus indicators on all interactive elements
3. **Keyboard Navigation:** All features accessible via keyboard
4. **Alt Text:** All images must have descriptive alt text
5. **Form Labels:** Every form input must have associated label
6. **Semantic HTML:** Proper heading hierarchy (H1, H2, H3)
7. **ARIA Labels:** Added where necessary
8. **Mobile Accessibility:** Touch targets minimum 48x48px
9. **Responsive Text:** Never prevent zooming
10. **Language:** HTML lang attribute set correctly

---

## RESPONSIVE DESIGN FOR PAYMENT PAGES

### Payment Page Breakpoints

All payment-related pages must be fully responsive:

- **Mobile (< 768px):**
  - Single column layout
  - Stacked booking summary cards
  - Full-width payment button
  - Simplified payment breakdown
  - Touch-friendly button sizes (minimum 48px height)
  
- **Tablet (768px - 1024px):**
  - Optimized card widths
  - Readable text sizes
  - Comfortable spacing
  
- **Desktop (> 1024px):**
  - Centered content (max-width: 600px for payment page)
  - Generous whitespace
  - Professional appearance

### Razorpay Checkout Modal

- Full-screen on mobile
- Centered modal on desktop
- Razorpay's default styling preserved
- Smooth modal transitions
- Close button clearly visible

---

## DESIGN CONSISTENCY CHECKLIST

Before marking design complete, verify:

- [x] All pages use the same color palette
- [x] Typography is consistent across all sections
- [x] Button styles match across entire site
- [x] Spacing is uniform and follows 8px grid
- [x] Navigation consistent on all pages
- [x] Footer identical on all pages
- [x] Images follow guidelines
- [x] No conflicting fonts
- [x] Hover states consistent
- [x] Mobile layouts follow breakpoints
- [x] Admin design separate but professional
- [x] Accessibility standards met
- [x] Performance optimized
- [ ] **Payment pages designed and documented** ✅
- [ ] **Payment status indicators approved**
- [ ] **Refund UI designed**
- [ ] **Cancellation policy display approved**

---

## DESIGN ASSETS

### Files to Create

- `resources/css/app.css` - Custom CSS variables and utilities
- `resources/css/components.css` - Component styles
- `resources/css/responsive.css` - Responsive design rules
- `resources/css/payment.css` - Payment page specific styles (NEW)
- `resources/js/theme.js` - Theme color management (if needed)
- `resources/js/payment.js` - Payment page interactions (NEW)

### CSS Variables (Recommended)

```css
:root {
  --color-navy: #1a2332;
  --color-ivory: #f5f3f0;
  --color-gold: #c9a961;
  --color-white: #ffffff;
  --color-gray: #e8e6e3;
  
  /* Payment Status Colors */
  --color-payment-pending: #f39c12;
  --color-payment-success: #27ae60;
  --color-payment-failed: #e74c3c;
  --color-payment-processing: #3498db;
  --color-refund-pending: #5dade2;
  --color-refund-processed: #27ae60;
  
  --font-heading: 'Playfair Display', serif;
  --font-primary: 'Poppins', sans-serif;
  --font-body: 'Lato', sans-serif;
  
  --spacing-xs: 4px;
  --spacing-sm: 8px;
  --spacing-md: 16px;
  --spacing-lg: 24px;
  --spacing-xl: 32px;
  --spacing-xxl: 48px;
  
  --radius-sm: 4px;
  --radius-md: 8px;
  --radius-lg: 12px;
  
  /* Payment specific */
  --payment-button-height: 56px;
  --payment-card-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
```

---

## ACCESSIBILITY REQUIREMENTS FOR PAYMENT PAGES

### Payment Page Specific

1. **Screen Reader Support:**
   - All payment amounts announced clearly
   - Payment status changes announced
   - Error messages read aloud
   - Success confirmations accessible

2. **Keyboard Navigation:**
   - Payment button accessible via Tab
   - All form fields keyboard navigable
   - Modal dialogs keyboard-trappable
   - Skip links for repeated content

3. **Visual Indicators:**
   - High contrast for payment amounts
   - Clear focus states on payment buttons
   - Color + icon + text for status (not color alone)
   - Loading states visually clear

4. **Error Handling:**
   - Clear error messages
   - Error summary at top of page
   - Inline validation messages
   - Retry instructions clear

---

## DESIGN REVIEW CHECKLIST

- [x] Color palette approved
- [x] Typography selected and installed
- [x] Component designs agreed
- [x] Page layouts approved
- [x] Mobile responsiveness verified
- [x] Admin design approved
- [x] Accessibility standards confirmed
- [x] **Direct Booking System UI/UX designs complete**
- [x] **OTP verification screens designed**
- [x] **Room availability interface designed**
- [x] **Booking management portal designed**
- [x] **Cancellation & refund interface designed**
- [x] **Payment checkout integration designed**
- [x] **Status badges and indicators approved**
- [ ] **Client approval for all booking system designs** (PENDING)
- [ ] Ready for Phase 8 implementation

---

**Document Version:** 3.0 (Direct Booking System)  
**Status:** Direct Booking System Design Complete - Ready for Client Review  
**Last Updated:** November 13, 2026  
**Major Change:** Replaced WhatsApp payment link UI with complete Direct Online Booking System UI/UX designs including room search, OTP verification, direct booking flow, customer portal, cancellation interface, and admin booking management.

**What's New:**
- ✅ Room search and availability interface
- ✅ Real-time availability display with pricing
- ✅ OTP-based customer verification screens
- ✅ Direct booking form with guest information
- ✅ Razorpay checkout integration
- ✅ Booking confirmation and receipt screens
- ✅ "My Bookings" customer self-service portal
- ✅ OTP-based booking access (no passwords)
- ✅ Booking details and management interface
- ✅ Customer-initiated cancellation interface
- ✅ Refund calculation and status display
- ✅ Admin booking management dashboard
- ✅ Room allocation interface
- ✅ Comprehensive status badges and indicators
- ✅ Mobile-first responsive designs
- ✅ Loading states, error states, empty states
- ✅ Accessibility features (WCAG 2.1 AA)

**What's Removed:**
- ❌ WhatsApp payment link management interface
- ❌ Manual booking approval workflow UI
- ❌ Enquiry-to-booking conversion screens
- ❌ Payment link generation interface
- ❌ Payment link sharing via WhatsApp UI
