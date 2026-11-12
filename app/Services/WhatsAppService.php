<?php

namespace App\Services;

use App\Models\Enquiry;

class WhatsAppService
{
    /**
     * Generate a formatted enquiry message for WhatsApp
     */
    public function generateEnquiryMessage(Enquiry $enquiry): string
    {
        $checkInDate = $enquiry->check_in_date->format('d M, Y');
        $checkOutDate = $enquiry->check_out_date->format('d M, Y');
        $nightsCount = $enquiry->check_out_date->diffInDays($enquiry->check_in_date);

        $message = "Enquiry ID: {$enquiry->reference_id}\n\n";
        $message .= "Room Type: {$enquiry->roomType->name}\n";
        $message .= "Check-in: {$checkInDate}\n";
        $message .= "Check-out: {$checkOutDate}\n";
        $message .= "Nights: {$nightsCount}\n";
        $message .= "Adults: {$enquiry->num_adults}\n";
        $message .= "Children: {$enquiry->num_children}\n\n";
        $message .= "Guest Name: {$enquiry->customer_name}\n";
        $message .= "Phone: {$enquiry->customer_phone}\n";

        if ($enquiry->customer_email) {
            $message .= "Email: {$enquiry->customer_email}\n";
        }

        if ($enquiry->special_requests) {
            $message .= "\nSpecial Requests:\n{$enquiry->special_requests}\n";
        }

        $message .= "\n---\nHotel Rose Palace Booking Enquiry";

        return $message;
    }

    /**
     * Generate WhatsApp URL with pre-filled message
     */
    public function generateWhatsAppUrl(string $message): string
    {
        $phoneNumber = $this->getWhatsAppNumber();
        $encodedMessage = urlencode($message);
        
        // Format: https://wa.me/[phone]?text=[message]
        return "https://wa.me/" . str_replace([' ', '+', '-', '(', ')'], '', $phoneNumber) . "?text={$encodedMessage}";
    }

    /**
     * Get WhatsApp number from config
     */
    public function getWhatsAppNumber(): string
    {
        return config('hotel.contact.whatsapp_number');
    }
}
