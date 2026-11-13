<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Must be OTP verified
        return session('otp_verified') === true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'room_type_id' => 'required|exists:room_types,id',
            'quantity' => 'required|integer|min:1|max:10',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'total_guests' => 'required|integer|min:1|max:100',
            'special_requests' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'check_in.required' => 'Check-in date is required.',
            'check_in.after_or_equal' => 'Check-in date must be today or later.',
            'check_out.required' => 'Check-out date is required.',
            'check_out.after' => 'Check-out date must be after check-in date.',
            'room_type_id.required' => 'Please select a room category.',
            'room_type_id.exists' => 'Selected room category is invalid.',
            'quantity.required' => 'Number of rooms is required.',
            'quantity.min' => 'At least 1 room must be selected.',
            'quantity.max' => 'Maximum 10 rooms can be booked.',
            'customer_name.required' => 'Guest name is required.',
            'customer_email.required' => 'Email address is required.',
            'total_guests.required' => 'Total number of guests is required.',
            'total_guests.min' => 'At least 1 guest is required.',
        ];
    }
}
