<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GeneralInquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $inquiry;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectText = $this->inquiry->subject ? $this->inquiry->subject : 'General Inquiry';
        
        return new Envelope(
            subject: "New Guest Inquiry: {$subjectText} - Hotel Rose Palace",
            replyTo: [
                new Address($this->inquiry->email, $this->inquiry->name),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.general-inquiry',
            with: [
                'inquiry' => $this->inquiry,
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
