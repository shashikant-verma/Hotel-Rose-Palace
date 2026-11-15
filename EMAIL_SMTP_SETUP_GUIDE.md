# Email SMTP Setup Guide (Brevo)

This project sends OTP verification emails and booking notifications through
**Brevo** (formerly Sendinblue) using its free SMTP tier (300 emails/day).

## 1. Create a Brevo Account

1. Go to   and sign up for a free account.
2. Verify your email address to activate the account.

## 2. Get Your SMTP Credentials

1. Log in to Brevo.
2. Go to **Settings → SMTP & API** (or **Senders, Domains & Dedicated IPs → SMTP & API**).
3. Under the **SMTP** tab you will see:
   - **SMTP Server**: `smtp-relay.brevo.com`
   - **Port**: `587`
   - **Login**: your Brevo account email address
4. Click **Generate a new SMTP key** (or reuse an existing one) and copy it.
   This key is your `MAIL_PASSWORD` — it is **not** your account password.

## 3. Verify a Sender Email/Domain

Brevo requires the "From" address to be a verified sender:

1. Go to **Senders, Domains & Dedicated IPs → Senders**.
2. Add the address you want to send from (e.g. `noreply@hotelrosepalace.com`).
3. Confirm it via the verification email Brevo sends, or verify your full
   domain (SPF/DKIM) for better deliverability if you own the domain.

If you don't own a custom domain yet, you can verify a personal email
address as the sender for testing, then switch to a domain-based address
later.

## 4. Configure `.env`

Add/update these values in your project's `.env` file (not `.env.example`):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=your-brevo-account-email@example.com
MAIL_PASSWORD=your-brevo-smtp-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@hotelrosepalace.com"
MAIL_FROM_NAME="Hotel Rose Palace"
```

- `MAIL_USERNAME` = the login shown on the Brevo SMTP page (your account email).
- `MAIL_PASSWORD` = the SMTP key you generated in step 2.
- `MAIL_FROM_ADDRESS` must be a sender verified in step 3, or sending will fail.

## 5. Clear Config Cache & Test

```bash
php artisan config:clear
php artisan tinker
```

Inside Tinker, send a test email:

```php
Mail::raw('Test email from Hotel Rose Palace', function ($message) {
    $message->to('your-personal-email@example.com')
        ->subject('SMTP Test');
});
```

Check the recipient inbox (and spam folder). If it doesn't arrive, check
Brevo's **Transactional → Logs** page for delivery/rejection details.

## 6. Where This Is Used

- `app/Services/OtpService.php` — sends the 6-digit OTP via
  `Mail::to($email)->send(new OtpMail(...))`.
- `app/Mail/OtpMail.php` — the Mailable class.
- `resources/views/emails/otp.blade.php` — the email template.

## Notes & Limits

- Free tier: **300 emails/day**. Monitor usage in the Brevo dashboard if
  booking volume grows.
- Never commit real SMTP credentials — `.env` is gitignored; only
  `.env.example` (with placeholder values) is committed.
- If emails land in spam, verify your sending domain's SPF/DKIM records in
  Brevo's domain settings.
