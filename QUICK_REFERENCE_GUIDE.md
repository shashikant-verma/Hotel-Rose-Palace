# 🎨 Quick Reference Guide - Luxury Design System

## Color Palette Quick Reference

### Copy-Paste Colors
```css
/* Canvas Colors */
--color-sandstone-base: #EDE4D8;   /* Main background */
--color-champagne: #F7F1E8;        /* Card/modal surface */
--color-beige: #E2D5C3;            /* Section alt/sidebar */
--color-border-subtle: #D8CBB8;    /* Borders */

/* Brand Colors */
--color-burgundy-rose: #6E2C3A;    /* Primary buttons */
--color-burgundy-dark: #58222E;    /* Button hover */
--color-brass-gold: #B88A44;       /* Accents/icons */

/* Typography Colors */
--color-charcoal-deep: #2E1F22;    /* Headings/primary text */
--color-mauve-grey: #5E4B4E;       /* Secondary text */
--color-cream: #FAF6F0;            /* Hover backgrounds */

/* Functional Colors */
--color-success: #27ae60;          /* Success states */
--color-warning: #F39C12;          /* Warnings */
--color-danger: #E74C3C;           /* Errors */
--color-info: #3498DB;             /* Info states */
```

## Common CSS Snippets

### Button Styling
```html
<!-- Primary Button -->
<button class="btn btn-primary">Save Changes</button>

<!-- Secondary Button -->
<button class="btn btn-secondary">Cancel</button>

<!-- Outline Button -->
<button class="btn btn-outline-primary">View Details</button>
```

### Form Styling
```html
<div class="mb-3">
    <label class="form-label">Email Address</label>
    <input type="email" class="form-control" placeholder="user@example.com">
</div>
```

### Card Styling
```html
<div class="stat-card">
    <div class="stat-icon"><i class="fas fa-bed"></i></div>
    <h3>50</h3>
    <p>Luxury Rooms</p>
</div>
```

### Table Styling
```html
<div class="table-card">
    <h5>Recent Enquiries</h5>
    <table class="table">
        <thead><tr><th>Name</th><th>Email</th></tr></thead>
        <tbody><tr><td>John</td><td>john@example.com</td></tr></tbody>
    </table>
</div>
```

## Responsive Grid Examples

### 3-Column Grid
```html
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
    <div class="card">Column 1</div>
    <div class="card">Column 2</div>
    <div class="card">Column 3</div>
</div>
```

### 2-Column Split
```html
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px;">
    <div>Left content</div>
    <div>Right content</div>
</div>
```

### Mobile-First Responsive
```css
@media (max-width: 768px) {
    grid-template-columns: 1fr;
    gap: 16px;
}
```

## Typography Quick Reference

### Headings
```html
<!-- Use Playfair Display serif -->
<h1>Main Heading (56px, 700 weight)</h1>
<h2>Section Heading (36px, 700 weight)</h2>
<h3>Subsection (28px, 600 weight)</h3>
<h4>Minor Heading (24px, 600 weight)</h4>
```

### Body Text
```html
<!-- Use Plus Jakarta Sans sans-serif -->
<p>Body text (14px, 400 weight, #2E1F22)</p>
<small>Small text (12px, 400 weight, #5E4B4E)</small>
```

## Status Badge Examples

```html
<!-- Success Badge -->
<span class="badge bg-success">Confirmed</span>

<!-- Warning Badge -->
<span class="badge bg-warning">Pending</span>

<!-- Danger Badge -->
<span class="badge bg-danger">Cancelled</span>

<!-- Info Badge -->
<span class="badge bg-info">Processing</span>
```

## Alert Examples

```html
<!-- Success Alert -->
<div class="alert alert-success">✓ Action completed successfully!</div>

<!-- Danger Alert -->
<div class="alert alert-danger">✗ Something went wrong!</div>

<!-- Warning Alert -->
<div class="alert alert-warning">⚠ Please review this information</div>

<!-- Info Alert -->
<div class="alert alert-info">ℹ New update available</div>
```

## Spacing Reference

### Standard Spacing
```
4px   - xs
8px   - sm
16px  - md
24px  - lg
32px  - xl
48px  - xxl
```

### Margin/Padding Classes
```html
<div class="mb-3">Margin bottom 24px</div>
<div class="mt-3">Margin top 24px</div>
<div class="p-3">Padding all sides 24px</div>
```

## Shadow Reference

```css
--shadow-sm: 0 2px 8px rgba(46, 31, 34, 0.08);
--shadow-md: 0 4px 16px rgba(46, 31, 34, 0.12);
--shadow-lg: 0 8px 24px rgba(46, 31, 34, 0.15);
```

## Hover Effects

### Card Hover
```css
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(46, 31, 34, 0.12);
    border-color: var(--color-brass-gold);
}
```

### Button Hover
```css
.btn-primary:hover {
    background-color: var(--color-burgundy-dark);
    box-shadow: 0 4px 16px rgba(110, 44, 58, 0.3);
}
```

### Link Hover
```css
a:hover {
    color: var(--color-burgundy-rose);
    text-decoration: none;
}
```

## Commonly Used CSS Variables

```css
/* Use these in all new code */
color: var(--color-charcoal-deep);
background: var(--color-champagne);
border: 1px solid var(--color-border-subtle);
font-family: var(--font-heading);

/* Never hardcode colors like: */
color: #FFFFFF;  /* ❌ Use palette instead */
background: #000000;  /* ❌ Use palette instead */
```

## Mobile Responsive Breakpoints

```css
/* Mobile-first approach */
/* Default: Mobile (< 576px) */

/* Tablet */
@media (min-width: 768px) {
    /* Tablet styles */
}

/* Desktop */
@media (min-width: 992px) {
    /* Desktop styles */
}

/* Large Desktop */
@media (min-width: 1200px) {
    /* Large desktop styles */
}
```

## Testing Checklist

- [ ] All colors from palette (no #FFFFFF or #000000)
- [ ] Responsive at 375px, 768px, 1024px, 1920px
- [ ] Hover effects on interactive elements
- [ ] Focus rings visible on form inputs
- [ ] All fonts loaded correctly
- [ ] Images load and scale properly
- [ ] No console errors
- [ ] Mobile menu works
- [ ] Forms submit successfully
- [ ] All links work

## Build & Deploy Commands

```bash
# Build CSS/JS
npm run build

# Clear all caches
php artisan optimize:clear

# Test build
npm run build && echo "Build successful!"

# Deploy
git add .
git commit -m "feat: description"
git push origin main
```

## Design System Files Reference

| Purpose | File |
|---------|------|
| CSS Variables & Fonts | `resources/css/app.css` |
| Public Layout | `resources/views/layouts/app.blade.php` |
| Admin Layout | `resources/views/admin/layouts/app.blade.php` |
| Navbar Component | `resources/views/components/navbar.blade.php` |
| Footer Component | `resources/views/components/footer.blade.php` |
| Complete Docs | `LUXURY_DESIGN_SYSTEM.md` |
| Implementation Guide | `IMPLEMENTATION_STATUS.md` |
| Admin Report | `LUXURY_DESIGN_PHASES_10_13_COMPLETION_REPORT.md` |
| Full Summary | `FINAL_LUXURY_DESIGN_SUMMARY.md` |

## Quick Problem Solver

### Build Fails
```bash
rm -rf public/build node_modules
npm install
npm run build
```

### Styles Not Updating
```bash
php artisan view:clear
php artisan cache:clear
npm run build
```

### Colors Look Wrong
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh page (Ctrl+F5)
3. Check DevTools → Network → public/build/assets/app-*.css loads
4. Verify file exists: `public/build/manifest.json`

### Admin Sidebar Missing
1. Check CSS file loaded in Network tab
2. Verify `resources/views/admin/layouts/app.blade.php` exists
3. Clear view cache: `php artisan view:clear`
4. Rebuild: `npm run build`

### Responsive Issues
1. Test viewport: DevTools → Toggle Device Toolbar (F12)
2. Check media queries: `@media (max-width: 768px)`
3. Verify grid/flex layouts
4. Test on actual mobile device

## Remember

✅ **DO**:
- Use CSS variables for all colors
- Follow responsive mobile-first approach
- Test on multiple device sizes
- Use semantic HTML
- Keep animations smooth (0.3s)
- Document your changes

❌ **DON'T**:
- Use hardcoded colors (#FFFFFF, #000000)
- Ignore mobile responsiveness
- Use inline styles when CSS variables exist
- Break semantic HTML structure
- Make animations too slow or jittery
- Skip testing on mobile devices

---

**Last Updated**: November 12, 2026  
**System Version**: 1.0 - Complete  
**Status**: ✅ Production Ready

