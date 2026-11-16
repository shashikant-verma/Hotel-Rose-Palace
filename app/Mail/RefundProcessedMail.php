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

class RefundProcessedMail extends Mailable implements ShouldQueue
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
    public string $refundStatus;
    public float $refundAmount;
    public ?string $refundId;

    /**
     * Create a new message instance.
     *
     * @param Booking $booking
     * @param Payment $payment
     * @param string $refundStatus 'processed', 'pending', or 'failed'
     * @param float $refundAmount
     * @param string|null $refundId
     */
    public function __construct(
        Booking $booking,
        Payment $payment,
        string $refundStatus = 'processed',
        float $refundAmount = 0.0,
        ?string $refundId = null
    ) {
        $this->afterCommit();

        $booking->loadMissing(['roomType']);
        $this->booking = $booking;
        $this->payment = $payment;
        $this->refundStatus = $refundStatus;
        $this->refundAmount = $refundAmount > 0 ? $refundAmount : (float) ($payment->refund_amount ?? $booking->eligible_refund_amount ?? 0);
        $this->refundId = $refundId ?? $payment->refund_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match ($this->refundStatus) {
            'processed' => "Refund Processed Successfully - Hotel Rose Palace [Booking #{$this->booking->booking_reference}]",
            'pending', 'initiated' => "Refund Initiated - Hotel Rose Palace [Booking #{$this->booking->booking_reference}]",
            'failed' => "Important Update Regarding Your Refund - Hotel Rose Palace [Booking #{$this->booking->booking_reference}]",
            default => "Refund Update - Hotel Rose Palace [Booking #{$this->booking->booking_reference}]",
        };

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.refund-processed',
            with: [
                'booking' => $this->booking,
                'payment' => $this->payment,
                'refundStatus' => $this->refundStatus,
                'refundAmount' => $this->refundAmount,
                'refundId' => $this->refundId,
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
