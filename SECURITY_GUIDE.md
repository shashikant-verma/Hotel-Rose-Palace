# Hotel Rose Palace - Security Implementation Guide

**Version:** 1.0  
**Last Updated:** November 12, 2026  
**Status:** Production Ready

---

## 🔒 Security Overview

This guide documents all security measures implemented in the Hotel Rose Palace application. Security is implemented at multiple layers:

1. **Authentication & Authorization**
2. **Input Validation & Sanitization**
3. **File Upload Security**
4. **Rate Limiting**
5. **Security Headers**
6. **Logging & Monitoring**

---

## 1. Authentication & Authorization

### Admin Authentication
- **Location:** `app/Http/Controllers/Admin/AuthController.php`
- **Middleware:** `app/Http/Middleware/AdminAuthenticate.php`

#### Features:
- Password hashing using bcrypt
- Session-based authentication
- Remember Me functionality
- CSRF token protection on login form
- Rate limiting on login attempts (5 per minute)

#### Login Process:
```php
// Login route - protected with rate limiting
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:login')
    ->name('login.post');

// Rate limit configuration (config/app.php)
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});
```

#### Protected Routes:
All admin routes are protected with `AdminAuthenticate` middleware:
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Protected routes here
});
```

---

## 2. Input Validation & Sanitization

### SecurityService Class
**Location:** `app/Services/SecurityService.php`

#### Input Sanitization:
```php
// Remove XSS attacks
SecurityService::sanitizeInput($userInput);

// Features:
// - Remove null bytes
// - Strip unsafe HTML tags
// - Encode special characters
// - Trim whitespace
```

#### Usage Example:
```php
$safeName = SecurityService::sanitizeInput($request->input('name'));
```

### Form Validation

All forms use Laravel's built-in validation:

#### Enquiry Form:
```php
$validated = $request->validate([
    'guest_name' => 'required|string|max:255',
    'guest_email' => 'required|email|max:255',
    'guest_phone' => 'required|string|max:20',
    'check_in_date' => 'required|date|after:today',
    'check_out_date' => 'required|date|after:check_in_date',
    'room_type_id' => 'required|exists:room_types,id',
    'number_of_guests' => 'required|integer|min:1|max:10',
    'message' => 'nullable|string|max:1000',
]);
```

#### Room Type Form:
```php
$validated = $request->validate([
    'name' => 'required|string|max:100|unique:room_types,name',
    'description' => 'nullable|string|max:1000',
    'base_price' => 'required|numeric|min:0',
    'max_guests' => 'required|integer|min:1|max:10',
]);
```

---

## 3. File Upload Security

### File Upload Configuration
**Location:** `config/security.php`

#### Allowed File Types:
```php
'uploads' => [
    'images' => [
        'max_size' => 5120, // 5MB
        'allowed_mimes' => ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
    ],
]
```

#### Upload Validation:
```php
// In controller
$validated = $request->validate([
    'images.*' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
]);

// Additional validation with SecurityService
foreach ($request->file('images') as $file) {
    $validation = SecurityService::validateUploadedFile($file, 'images');
    
    if (!$validation['valid']) {
        return back()->withErrors(['images' => $validation['errors']]);
    }
}
```

#### Security Checks:
```php
public static function validateUploadedFile($file, string $type = 'images'): array
{
    // Check file size
    // Check MIME type
    // Check file extension
    // Verify file is actual image (getimagesize)
    // Sanitize filename
}
```

### File Storage:
- **Location:** `storage/app/public/gallery/` and `storage/app/public/rooms/`
- **Access:** Via symbolic link at `/public/storage/`
- **Naming:** Timestamped unique filenames to prevent collisions
- **Cleanup:** Files deleted from storage when database record deleted

---

## 4. Rate Limiting

### Configured Rate Limits

#### Enquiry Form (3 per hour per IP):
```php
RateLimiter::for('enquiry', function (Request $request) {
    return Limit::perHour(3)->by($request->ip());
});
```

**Route:**
```php
Route::middleware(['throttle:enquiry'])->group(function () {
    Route::post('/enquiry', [EnquiryController::class, 'store']);
});
```

#### Admin Login (5 per minute per IP):
```php
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});
```

#### API Rate Limiting (60 per minute):
```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

### Rate Limit Response Handling:
- **Enquiry:** Returns 429 JSON response
- **Login:** Redirects back with error message
- **API:** Returns 429 JSON response

---

## 5. Security Headers

### Middleware
**Location:** `app/Http/Middleware/SecurityHeaders.php`

### Implemented Headers:

```
X-Frame-Options: SAMEORIGIN
    → Prevents clickjacking attacks
    → Only allow framing from same origin

X-Content-Type-Options: nosniff
    → Prevents MIME type sniffing
    → Browser must respect Content-Type header

X-XSS-Protection: 1; mode=block
    → Enable browser XSS protection

Referrer-Policy: strict-origin-when-cross-origin
    → Control referrer information

Permissions-Policy: geolocation=(), microphone=(), camera=()
    → Restrict access to device features

Content-Security-Policy: [detailed directives]
    → Prevent injection attacks
    → Control resource loading
```

### CSP Directives:
```
default-src 'self'                      → Default: same origin only
script-src 'self' 'unsafe-inline' ...   → Allow scripts from self + CDNs
style-src 'self' 'unsafe-inline' ...    → Allow styles from self + CDNs
img-src 'self' data: https:             → Allow images from self, data URIs, HTTPS
font-src 'self' data: ...               → Allow fonts from self + CDNs
connect-src 'self'                      → Allow connections to same origin
frame-ancestors 'self'                  → Prevent clickjacking
base-uri 'self'                         → Restrict base tag
form-action 'self'                      → Form submissions to same origin
```

---

## 6. CSRF Protection

### Automatic CSRF Protection
- Enabled on all POST, PUT, PATCH, DELETE requests
- Token generated per session
- Token verified before processing forms

### In Blade Templates:
```blade
<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')
    <!-- form fields -->
</form>
```

### In AJAX Requests:
```javascript
headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
}
```

---

## 7. Logging & Monitoring

### Security Logging Channel
**Location:** `config/logging.php`

```php
'security' => [
    'driver' => 'daily',
    'path' => storage_path('logs/security.log'),
    'level' => 'warning',
    'days' => 30,
]
```

### Events Logged:
```php
// Using SecurityService
SecurityService::logSecurityEvent('unauthorized_access_attempt', [
    'user_id' => auth()->id(),
    'resource' => 'admin/users',
]);
```

### Log Rotation:
- Daily log rotation
- 30-day retention
- Located at `storage/logs/security.log`

---

## 8. Error Handling

### Custom Error Pages

#### 404 Error Page
- **File:** `resources/views/errors/404.blade.php`
- **Message:** User-friendly "page not found" message
- **Actions:** Home, Rooms, Contact links

#### 500 Error Page
- **File:** `resources/views/errors/500.blade.php`
- **Message:** "Internal server error" without technical details
- **Actions:** Home, Retry, Contact links

#### 403 Error Page
- **File:** `resources/views/errors/403.blade.php`
- **Message:** "Access denied" without technical details
- **Actions:** Home, Admin Login (if guest)

### Error Configuration
**Location:** `bootstrap/app.php`

```php
->withExceptions(function (Exceptions $exceptions): void {
    // Custom exception handling
})
```

---

## 9. Database Security

### SQL Injection Prevention
- Uses Laravel's Eloquent ORM exclusively
- All queries use parameterized bindings
- Never concatenate user input into queries

#### Safe Query Example:
```php
// Safe - uses parameterized binding
$room = Room::where('slug', $request->input('slug'))->first();

// Never do this:
// $room = Room::whereRaw("slug = '" . $input . "'");
```

### Password Security:
- Passwords hashed using bcrypt
- Minimum configuration: cost factor of 12

```php
// Safe password hashing
'password' => Hash::make('user_password'),
```

---

## 10. Session Security

### Session Configuration
**Location:** `config/session.php`

```php
'lifetime' => 120,              // 2 hours
'expire_on_close' => false,     // Don't expire on close
'encrypt' => true,              // Encrypt sessions
'http_only' => true,            // Prevent JavaScript access
'same_site' => 'lax',           // SameSite cookie attribute
'secure' => env('SESSION_SECURE_COOKIE', false), // HTTPS only in production
```

### Session Regeneration:
- Session ID regenerated on login
- Prevents session fixation attacks

---

## 11. Testing Security

### Security Tests

Run tests to verify security measures:
```bash
# Run all tests
php artisan test

# Run specific test class
php artisan test tests/Unit/SecurityServiceTest.php

# Run with verbose output
php artisan test --verbose
```

### Test Coverage:

#### Feature Tests:
- `tests/Feature/AdminAuthenticationTest.php` - Authentication & rate limiting
- `tests/Feature/EnquiryFlowTest.php` - Enquiry form validation & rate limiting
- `tests/Feature/RoomManagementTest.php` - Authorization checks

#### Unit Tests:
- `tests/Unit/SecurityServiceTest.php` - Input sanitization & reference generation
- `tests/Unit/ModelRelationshipsTest.php` - Data integrity

---

## 12. Deployment Security Checklist

- [ ] Change default admin password
- [ ] Set `APP_DEBUG=false` in production
- [ ] Set `APP_ENV=production`
- [ ] Generate new APP_KEY: `php artisan key:generate`
- [ ] Enable HTTPS with SSL certificate
- [ ] Set `SESSION_SECURE_COOKIE=true` for production
- [ ] Configure `.env` with production database
- [ ] Set up automated backups
- [ ] Configure email service for notifications
- [ ] Enable security logging and monitoring
- [ ] Review and test all security headers
- [ ] Set up web server security headers (Apache/Nginx)
- [ ] Configure firewall rules
- [ ] Set up DDoS protection if needed
- [ ] Enable CORS restrictions
- [ ] Configure HSTS headers for HTTPS

---

## 13. Regular Security Maintenance

### Weekly Tasks:
- [ ] Review security logs for suspicious activity
- [ ] Check for failed login attempts
- [ ] Monitor rate limit violations

### Monthly Tasks:
- [ ] Update Laravel and dependencies
- [ ] Review and rotate API keys if used
- [ ] Analyze error logs for patterns
- [ ] Test backup restoration
- [ ] Review user access and permissions

### Quarterly Tasks:
- [ ] Security audit of code changes
- [ ] Penetration testing
- [ ] Review and update security policies
- [ ] Update this guide if needed

### Annually:
- [ ] Full security assessment
- [ ] Update SSL certificates
- [ ] Review all dependencies for vulnerabilities

---

## 14. Security Resources

### Dependencies:
- Laravel 12: Built-in security features
- PHP 8.2: Latest security patches

### Useful Commands:
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Generate new encryption key
php artisan key:generate

# Create secure hash (for passwords)
echo "password" | php artisan tinker --prompt='>>> hash("password")'

# Check for known security vulnerabilities
composer audit

# Run security tests
php artisan test
```

---

## 15. Incident Response

### If Security Breach is Suspected:

1. **Immediate Actions:**
   - Isolate affected systems
   - Preserve logs and evidence
   - Notify management

2. **Investigation:**
   - Review security logs
   - Check access logs
   - Identify compromised accounts

3. **Remediation:**
   - Reset compromised passwords
   - Remove unauthorized access
   - Patch vulnerabilities
   - Update security measures

4. **Prevention:**
   - Review what went wrong
   - Implement preventive measures
   - Update this guide
   - Train team members

---

## Contact & Support

For security issues or questions:
- **Report:** Do not publicly disclose security vulnerabilities
- **Contact:** admin@hotelrosepalace.com
- **Urgent:** Contact system administrator immediately

---

## Revision History

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | Nov 12, 2026 | Initial security guide for Phase 8 |

---

**Document Status:** ✅ Production Ready  
**Last Review:** November 12, 2026  
**Next Review:** January 12, 2027

