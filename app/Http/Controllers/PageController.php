<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Amenity;
use App\Models\GalleryImage;
use App\Models\ContactMessage;
use App\Mail\GeneralInquiryReceived;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show the home page
     */
    public function home(): View
    {
        $featuredRooms = Room::with(['roomType', 'images'])
            ->where('is_available', true)
            ->take(3)
            ->get();

        $amenities = Amenity::where('is_active', true)
            ->take(9)
            ->get();

        $galleryImages = GalleryImage::where('is_active', true)
            ->orderBy('display_order')
            ->take(6)
            ->get();

        return view('pages.home', [
            'featuredRooms' => $featuredRooms,
            'amenities' => $amenities,
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * Show the about page
     */
    public function about(): View
    {
        $amenities = Amenity::where('is_active', true)->get();

        return view('pages.about', [
            'amenities' => $amenities,
        ]);
    }

    /**
     * Show all rooms
     */
    public function rooms(): View
    {
        $roomTypes = RoomType::with(['rooms', 'amenities'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.rooms', [
            'roomTypes' => $roomTypes,
        ]);
    }

    /**
     * Show room details
     */
    public function roomDetail($slug): View
    {
        $roomType = RoomType::with(['rooms', 'amenities'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $rooms = $roomType->rooms()->with('images')->get();

        return view('pages.room-detail', [
            'roomType' => $roomType,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Show gallery
     */
    public function gallery(): View
    {
        $galleryImages = GalleryImage::where('is_active', true)
            ->orderBy('display_order')
            ->paginate(24);

        return view('pages.gallery', [
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * Show amenities page
     */
    public function amenities(): View
    {
        $amenities = Amenity::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('pages.amenities', [
            'amenities' => $amenities,
        ]);
    }

    /**
     * Show contact page
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email:filter|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => ['required', 'string', 'max:255', 'in:Room Reservation,Banquet & Event Inquiry,General Question'],
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Please provide your full name.',
            'email.required'   => 'Please provide your email address.',
            'email.email'      => 'Please provide a valid email address.',
            'subject.required' => 'Please select the purpose of your inquiry.',
            'subject.in'       => 'Please select a valid inquiry subject from the list.',
            'message.required' => 'Please enter your message or special requirements.',
        ]);

        try {
            $validated['status'] = 'new';
            $inquiry = ContactMessage::create($validated);
        } catch (\Throwable $e) {
            Log::error('Failed to save contact inquiry to database: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'We encountered an issue saving your inquiry. Please try again or reach out to us directly via WhatsApp.');
        }

        // Send email notification to hotel manager
        try {
            $managerEmail = config('hotel.contact.manager_email', env('MANAGER_EMAIL', env('HOTEL_EMAIL', 'Hotelrosepalacesurat@gmail.com')));
            if (!empty($managerEmail)) {
                Mail::to($managerEmail)->send(new GeneralInquiryReceived($inquiry));
            }
        } catch (\Throwable $mailException) {
            // Log failure gracefully without exposing sensitive credentials
            Log::warning('Failed to dispatch general inquiry notification email: ' . $mailException->getMessage(), [
                'inquiry_id' => $inquiry->id,
            ]);
            // Do not fail the submission or delete the inquiry!
        }

        return redirect()->route('contact')
            ->with('success', 'Thank you for your inquiry! Our concierge team has received your message and will respond within 2 hours.');
    }

    /**
     * Show privacy policy
     */
    public function privacy(): View
    {
        return view('pages.privacy');
    }

    /**
     * Show terms and conditions
     */
    public function terms(): View
    {
        return view('pages.terms');
    }

    /**
     * Show cancellation policy
     */
    public function cancellation(): View
    {
        return view('pages.cancellation');
    }
}
