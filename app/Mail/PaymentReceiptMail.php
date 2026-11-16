<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The number of times the queued job may be attempted.
     */
    public int $tries = 3;

    /**
     * The backoff duration in seconds between retries.
     */
    public int $backoff = 30;

    public Booking $booking;
    public Payment $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, Payment $payment)
    {
        $this->afterCommit();

        $booking->loadMissing(['roomType']);
        $this->booking = $booking;
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $paymentRef = $this->payment->razorpay_payment_id ?? ('PAY-' . $this->payment->id);

        return new Envelope(
            subject: "Payment Receipt - Hotel Rose Palace [Payment ID: {$paymentRef}]",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-receipt',
            with: [
                'booking' => $this->booking,
                'payment' => $this->payment,
                'hotel' => config('hotel'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
