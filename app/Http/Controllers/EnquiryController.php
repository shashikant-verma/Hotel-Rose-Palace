<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use App\Models\RoomType;
use App\Services\WhatsAppService;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Store a new enquiry
     */
    public function store(StoreEnquiryRequest $request)
    {
        // Generate unique reference ID
        $referenceId = $this->generateReferenceId();

        // Create the enquiry
        $enquiry = Enquiry::create([
            'reference_id' => $referenceId,
            'room_type_id' => $request->room_type_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'num_adults' => $request->num_adults,
            'num_children' => $request->num_children,
            'special_requests' => $request->special_requests,
            'status' => 'new',
        ]);

        // Redirect to success page with reference ID
        return redirect()->route('enquiry.success', ['reference' => $enquiry->reference_id])
            ->with('success', 'Enquiry submitted successfully! Redirecting to WhatsApp...');
    }

    /**
     * Show enquiry success page
     */
    public function success($reference): View
    {
        $enquiry = Enquiry::with('roomType')
            ->where('reference_id', $reference)
            ->firstOrFail();

        // Generate WhatsApp message and URL
        $message = $this->whatsappService->generateEnquiryMessage($enquiry);
        $whatsappUrl = $this->whatsappService->generateWhatsAppUrl($message);
        $whatsappNumber = $this->whatsappService->getWhatsAppNumber();

        return view('pages.enquiry-success', [
            'enquiry' => $enquiry,
            'message' => $message,
            'whatsappUrl' => $whatsappUrl,
            'whatsappNumber' => $whatsappNumber,
        ]);
    }

    /**
     * Generate unique reference ID in format HRP-YYYY-XXXXX
     */
    protected function generateReferenceId(): string
    {
        $year = now()->year;
        $randomNumber = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        
        // Ensure uniqueness
        $referenceId = "HRP-{$year}-{$randomNumber}";
        
        while (Enquiry::where('reference_id', $referenceId)->exists()) {
            $randomNumber = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
            $referenceId = "HRP-{$year}-{$randomNumber}";
        }

        return $referenceId;
    }
}
