# Hotel Rose Palace — Comprehensive Email System Documentation

**Project:** Hotel Rose Palace  
**Framework:** Laravel 12.x / PHP 8.2  
**Implementation Phase:** Phase 9D  
**Document Revision:** 1.0 (Production-Ready)  

---

## 1. Architecture Overview

The Hotel Rose Palace Email Notification System provides end-to-end transactional email communication for guests and management. It is designed around four key operational pillars:

1. **Transactional Reliability:** All customer booking and payment transactional emails implement `Illuminate\Contracts\Queue\ShouldQueue` with database transaction-aware dispatch (`$this->afterCommit()`), preventing ghost emails from rolling back database operations.
2. **Duplicate-Delivery Prevention (Idempotency):** Dedicated timestamp columns on `bookings` and `payments` tables atomically guard every email trigger. Even with rapid user refreshes, duplicate gateway webhooks, or retry loops, no guest receives multiple confirmations, receipts, or cancellation notices.
3. **Synchronous Immediate Delivery for OTPs:** Unlike queued booking notifications, guest login/booking OTP emails (`OtpMail`) are delivered synchronously via direct execution, ensuring immediate receipt within seconds.
4. **Resilient Mailer Integration (Brevo SMTP & Symfony Mailer):** Standardized against Symfony Mailer's strict scheme requirements (`smtp`, `smtps`, or `null` for opportunistic STARTTLS on port 587), completely preventing legacy `tls` scheme exceptions.

```
┌──────────────────────────────────────────────────────────────────────────────────┐
│                             HOTEL ROSE PALACE ARCHITECTURE                        │
└──────────────────────────────────────────────────────────────────────────────────┘
                                      │
           ┌──────────────────────────┴──────────────────────────┐
           ▼                                                     ▼
┌───────────────────────┐                             ┌───────────────────────┐
│   Synchronous Path    │                             │  Queued Pipeline      │
│  (Real-Time Feedback) │                             │   (Background Jobs)   │
├───────────────────────┤                             ├───────────────────────┤
│ • OtpMail (6-digit)   │                             │ • BookingConfirmedMail│
│   Sent immediately    │                             │ • PaymentReceiptMail  │
│   during OTP checkout │                             │ • BookingCancelledMail│
│                       │                             │ • RefundProcessedMail │
│                       │                             │ • GeneralInquiry      │
└──────────┬────────────┘                             └──────────┬────────────┘
           │                                                     │
           │                                          $afterCommit = true
           │                                                     │
           ▼                                                     ▼
┌──────────────────────────────────────────────────────────────────────────────────┐
│                   Idempotency Guard & Database Timestamp Check                   │
│ (confirmation_email_sent_at, receipt_email_sent_at, cancellation_email_sent_at)   │
└────────────────────────────────────────┬─────────────────────────────────────────┘
                                         │
                                         ▼
┌──────────────────────────────────────────────────────────────────────────────────┐
│                      Symfony Mailer Driver (config/mail.php)                     │
│               Local: log driver | Production: smtp-relay.brevo.com               │
└──────────────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Trigger Inventory & Matrix

| Event Name | Trigger Location / Service | Mailable Class | Recipient | Delivery Mode | Idempotency Column / Guard |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Guest Authentication / OTP Request** | `OtpService::generateAndSendOtp()` | `App\Mail\OtpMail` | Guest Email | **Synchronous** | Rate-limited by `OtpService` & cache cooldown |
| **Booking Payment Verified** | `PaymentProcessingService::verifyAndConfirm()` & `handlePaymentCapturedWebhook()` | `App\Mail\BookingConfirmedMail` | Guest Email | **Queued** (`afterCommit`) | `bookings.confirmation_email_sent_at` |
| **Payment Receipt Generated** | `PaymentProcessingService::dispatchPaymentSuccessEmails()` | `App\Mail\PaymentReceiptMail` | Guest Email | **Queued** (`afterCommit`) | `payments.receipt_email_sent_at` |
| **Booking Cancellation Approved** | `CancellationService::approveCancellation()` | `App\Mail\BookingCancelledMail` | Guest Email | **Queued** (`afterCommit`) | `bookings.cancellation_email_sent_at` |
| **Refund Processed** | `RefundProcessingService::processRefund()` & `PaymentProcessingService::handleRefundProcessedWebhook()` | `App\Mail\RefundProcessedMail` | Guest Email | **Queued** (`afterCommit`) | `payments.refund_email_sent_at` |
| **Refund Pending / Initiated** | `RefundProcessingService::processRefund()` | `App\Mail\RefundProcessedMail` | Guest Email | **Queued** (`afterCommit`) | `payments.refund_email_sent_at` |
| **Refund Failed** | `RefundProcessingService::processRefund()` (catch block) | `App\Mail\RefundProcessedMail` | Guest Email | **Queued** (`afterCommit`) | Logged; customer notified of delay |
| **General Contact Inquiry** | `ContactInquiryController::submit()` | `App\Mail\GeneralInquiryReceived` | Hotel Manager | **Queued** (`afterCommit`) | Contact message record persisted before dispatch |

---

## 3. Database Schema Updates for Idempotency

Migration: `database/migrations/2026_11_15_140000_add_email_notification_tracking_columns.php`

### Added to `bookings` Table:
- `confirmation_email_sent_at` (`timestamp`, nullable): Timestamp when booking confirmation email was queued.
- `cancellation_email_sent_at` (`timestamp`, nullable): Timestamp when cancellation notice was queued.

### Added to `payments` Table:
- `receipt_email_sent_at` (`timestamp`, nullable): Timestamp when official payment receipt email was queued.
- `refund_email_sent_at` (`timestamp`, nullable): Timestamp when refund notice email was queued.

---

## 4. Brand Styling & Luxury Design Standards

All email templates (`resources/views/emails/*.blade.php`) adhere to Hotel Rose Palace luxury identity guidelines:

- **Primary Brand Color:** Imperial Burgundy (`#6E2C3A`)
- **Background Parchment:** Soft Warm White / Cream (`#F7F1E8`, `#EDE4D8`)
- **Accent Tones:** Deep Maroon (`#58202C`), Subtle Charcoal Text (`#2E1F22`), Forest Green (`#2E7D32`), Amber Alert (`#EF6C00`)
- **Typography:** Serif Georgia/Garamond headings paired with crisp system sans-serif (`Segoe UI`, Arial, sans-serif) body text.
- **Client Compatibility:** Bulletproof HTML tables with inline styles, compatible across Outlook, Gmail, Apple Mail, and mobile email clients.
- **Official Hotel Details:**
  - **Address:** 4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007
  - **Phone / WhatsApp:** +91 88667 71900
  - **Official Inquiries:** `Hotelrosepalacesurat@gmail.com`

---

## 5. Brevo SMTP Production Configuration

Brevo (formerly Sendinblue) provides reliable transactional SMTP delivery (free tier includes 300 emails/day).

### Environment Configuration (`.env`):

```env
# Mailer configuration
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=your-brevo-account-email@example.com
MAIL_PASSWORD=your-brevo-smtp-master-key
MAIL_FROM_ADDRESS="Hotelrosepalacesurat@gmail.com"
MAIL_FROM_NAME="Hotel Rose Palace"

# Optional Brevo API Key (for transactional API integration)
BREVO_API_KEY=your-brevo-v3-api-key
```

### Important Technical Rules for Symfony Mailer:
1. **Never set `MAIL_SCHEME=tls` or `MAIL_ENCRYPTION=tls`:** In Laravel 12 / Symfony Mailer, `tls` is NOT a recognized URL scheme. Port `587` automatically negotiates STARTTLS encryption using scheme `smtp` (or leaving `MAIL_SCHEME=null`).
2. **Sender Domain Verification:** The address in `MAIL_FROM_ADDRESS` must be verified inside Brevo under **Senders, Domains & Dedicated IPs → Senders**. Unverified senders will be rejected by Brevo with `550 Sender address rejected`.
3. **DKIM & SPF Records:** For optimal deliverability to guest inboxes (avoiding Spam/Promotions), configure DNS records provided by Brevo (`TXT` SPF and `TXT` DKIM) on the hotel domain.

---

## 6. Background Queue Worker Setup & Production Operations

### Running Queue Workers Locally:
```bash
php artisan queue:work --tries=3 --backoff=30
```

### Production Supervisor Configuration (`/etc/supervisor/conf.d/hotel-rose-palace-worker.conf`):
```ini
[program:hotel-rose-palace-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/hotel-rose-palace/artisan queue:work --queue=default --sleep=3 --tries=3 --backoff=30 --timeout=60 --rest=1
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/hotel-rose-palace/storage/logs/worker.log
stopwaitsecs=3600
```

### Queue Management Commands:
```bash
# Monitor failed queue jobs
php artisan queue:failed

# Retry all failed jobs
php artisan queue:retry all

# Flush failed jobs after inspection
php artisan queue:flush
```

---

## 7. Operational Verification Command

A dedicated Artisan command is available to verify mailer configuration and connectivity safely at any time:

```bash
php artisan email:test guest@example.com
```

### Expected Output (Safe Log Mailer Mode):
```
Hotel Rose Palace — Email System Operational Verification
Preparing test email using 'log' driver...
  From:      Hotel Rose Palace <hello@example.com>
  Recipient: guest@example.com
✓ Test email dispatched successfully via 'log' mailer to guest@example.com.
```

### Output in Production (Brevo SMTP Mode):
```
Hotel Rose Palace — Email System Operational Verification
Preparing test email using 'smtp' driver...
  From:      Hotel Rose Palace <Hotelrosepalacesurat@gmail.com>
  Recipient: guest@example.com
  Server:    smtp-relay.brevo.com:587
✓ Test email dispatched successfully via 'smtp' mailer to guest@example.com.
```

---

## 8. Pre-Production Deployment Checklist

- [x] All 28 database migrations applied (including `2026_11_15_140000_add_email_notification_tracking_columns`).
- [x] All 147 test cases passing (473 assertions across unit and feature suites).
- [x] `config/mail.php` normalized with scheme fallback and integer port casting.
- [x] `config/services.php` configured with `'brevo' => ['api_key' => env('BREVO_API_KEY')]`.
- [x] Mailables configured with `$afterCommit()` to ensure database transaction integrity.
- [x] Idempotency timestamps verified to block duplicate emails on webhooks and re-entries.
- [ ] Management provides live Brevo SMTP key (`MAIL_PASSWORD`) and verified sender email (`MAIL_FROM_ADDRESS`).
- [ ] Supervisor queue worker service enabled and running on production server.
- [ ] Run `php artisan email:test recipient@domain.com` against live production Brevo account.
