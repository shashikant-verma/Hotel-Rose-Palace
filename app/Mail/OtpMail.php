<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $purpose;
    public int $expiryMinutes;

    public function __construct(string $otp, string $purpose, int $expiryMinutes = 5)
    {
        $this->otp = $otp;
        $this->purpose = $purpose;
        $this->expiryMinutes = $expiryMinutes;
    }

    public function envelope(): Envelope
    {
        $purposeLabel = $this->purpose === 'manage_bookings' ? 'Manage Bookings' : 'Booking';

        return new Envelope(
            subject: "Your Verification Code - Hotel Rose Palace ({$purposeLabel})",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'otp' => $this->otp,
                'purpose' => $this->purpose,
                'expiryMinutes' => $this->expiryMinutes,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
