# Email SMTP Setup Guide (Brevo & Laravel 12)

This project sends OTP verification emails, customer booking confirmations, payment receipts, cancellation confirmations, and refund notices through **Brevo** (formerly Sendinblue) using its high-deliverability SMTP service.

---

## 1. Create a Brevo Account

1. Go to [https://www.brevo.com](https://www.brevo.com) and create a free account (includes 300 free transactional emails/day).
2. Complete your email verification to activate the account.

---

## 2. Generate Your SMTP Credentials

1. Log in to your Brevo Dashboard.
2. Navigate to **Transactional → Settings → Configuration** (or top-right profile menu → **SMTP & API**).
3. Under the **SMTP** tab, note the connection settings:
   - **SMTP Server**: `smtp-relay.brevo.com`
   - **Port**: `587`
   - **Login**: Your Brevo account email address (e.g., `hotelrosepalacesurat@gmail.com`)
4. Click **Generate a new SMTP key**, provide a descriptive name (e.g. `HotelRosePalace-Prod`), and copy the key.
   > **Important:** This generated key is your `MAIL_PASSWORD`. Never use your personal login password.

---

## 3. Verify Sender Email & Domain

Brevo requires all sending addresses to be explicitly verified:

1. In the Brevo menu, navigate to **Senders, Domains & Dedicated IPs → Senders**.
2. Click **Add a Sender**:
   - **From Name**: `Hotel Rose Palace`
   - **From Email**: `Hotelrosepalacesurat@gmail.com` (or your verified domain email).
3. Confirm the sender via the verification code/link sent to that inbox.
4. *(Recommended for Production)* Go to **Domains**, add your domain, and configure the SPF, DKIM, and DMARC TXT records in your DNS manager to ensure emails land directly in the Primary Inbox.

---

## 4. Configure Environment Variables (`.env`)

Add or update the following values in your production `.env` file (do not commit this file to Git):

```env
# Brevo SMTP Configuration (Laravel 12 / Symfony Mailer Standard)
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=your-brevo-account-email@example.com
MAIL_PASSWORD=your-generated-smtp-master-key
MAIL_FROM_ADDRESS="Hotelrosepalacesurat@gmail.com"
MAIL_FROM_NAME="Hotel Rose Palace"

# Optional: Brevo API V3 Key
BREVO_API_KEY=your-brevo-api-v3-key
```

> [!NOTE]
> **Symfony Mailer Scheme Standard in Laravel 12:**
> Do **not** set `MAIL_ENCRYPTION=tls` or `MAIL_SCHEME=tls`. Symfony Mailer only supports `smtp`, `smtps`, or `null`. On port `587`, leaving `MAIL_SCHEME=null` automatically initiates TLS encryption via opportunistic STARTTLS.

---

## 5. Verify Connectivity & Test

Clear the cached configuration and run the built-in operational test command:

```bash
# Clear any cached environment configuration
php artisan config:clear

# Send an operational test email
php artisan email:test your-personal-email@example.com
```

### Verification Checks:
1. Console outputs `✓ Test email dispatched successfully via 'smtp' mailer`.
2. Inspect the recipient inbox (and spam folder) for the test email.
3. Check **Brevo Dashboard → Transactional → Statistics / Real-time Logs** to view delivery status and response codes.

---

## 6. Email System Architecture

The following emails are fully automated in the system:

| Mailable Class | View Template | Trigger Event | Queue Mode |
| :--- | :--- | :--- | :--- |
| `App\Mail\OtpMail` | `emails.otp` | Guest enters email on booking or login form | **Synchronous** (instant) |
| `App\Mail\BookingConfirmedMail` | `emails.booking-confirmed` | Razorpay payment successfully verified | **Queued** (`afterCommit`) |
| `App\Mail\PaymentReceiptMail` | `emails.payment-receipt` | Razorpay payment captured | **Queued** (`afterCommit`) |
| `App\Mail\BookingCancelledMail` | `emails.booking-cancelled` | Hotel manager approves cancellation request | **Queued** (`afterCommit`) |
| `App\Mail\RefundProcessedMail` | `emails.refund-processed` | Gateway refund processed, pending, or failed | **Queued** (`afterCommit`) |
| `App\Mail\GeneralInquiryReceived` | `emails.general-inquiry` | Guest submits contact form inquiry | **Queued** (`afterCommit`) |

---

## 7. Background Queue Worker Setup

All transactional booking emails are queued for fast page loads and resilient retry handling. Ensure a background worker is running:

```bash
php artisan queue:work --queue=default --sleep=3 --tries=3 --backoff=30
```

For production servers, configure a Supervisor daemon (see [EMAIL_SYSTEM_DOCUMENTATION.md](file:///d:/Hotel-Rose-Palace/EMAIL_SYSTEM_DOCUMENTATION.md) for the configuration file).

---

## 8. Safety & Compliance Notes

- **Credential Secrecy:** Never commit real SMTP keys or API secrets to version control.
- **Fail-Safe Local Mode:** If `MAIL_USERNAME` or `MAIL_PASSWORD` are unconfigured, keep `MAIL_MAILER=log` in your local development `.env` to prevent app crashes while testing bookings.
- **Quota Monitoring:** Brevo free tier allows 300 emails per day. If the hotel exceeds this volume, upgrade to a Starter tier or higher in Brevo.
