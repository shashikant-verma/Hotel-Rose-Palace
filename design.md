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

### Admin Components

#### Table Design
- **Header:** Deep Navy background, white text
- **Rows:** Alternating white and very light gray
- **Hover:** Light gold background
- **Actions:** Icon buttons (edit, delete, view)

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

## DESIGN CONSISTENCY CHECKLIST

Before marking design complete, verify:

- [ ] All pages use the same color palette
- [ ] Typography is consistent across all sections
- [ ] Button styles match across entire site
- [ ] Spacing is uniform and follows 8px grid
- [ ] Navigation consistent on all pages
- [ ] Footer identical on all pages
- [ ] Images follow guidelines
- [ ] No conflicting fonts
- [ ] Hover states consistent
- [ ] Mobile layouts follow breakpoints
- [ ] Admin design separate but professional
- [ ] Accessibility standards met
- [ ] Performance optimized

---

## DESIGN ASSETS

### Files to Create

- `resources/css/app.css` - Custom CSS variables and utilities
- `resources/css/components.css` - Component styles
- `resources/css/responsive.css` - Responsive design rules
- `resources/js/theme.js` - Theme color management (if needed)

### CSS Variables (Recommended)

```css
:root {
  --color-navy: #1a2332;
  --color-ivory: #f5f3f0;
  --color-gold: #c9a961;
  --color-white: #ffffff;
  --color-gray: #e8e6e3;
  
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
}
```

---

## DESIGN REVIEW CHECKLIST

- [ ] Color palette approved
- [ ] Typography selected and installed
- [ ] Component designs agreed
- [ ] Page layouts approved
- [ ] Mobile responsiveness verified
- [ ] Admin design approved
- [ ] Accessibility standards confirmed
- [ ] Ready for frontend development

---

**Document Version:** 1.0  
**Status:** Awaiting Approval  
**Last Updated:** November 12, 2026
