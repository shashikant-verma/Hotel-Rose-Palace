<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'room_type_id' => 'required|exists:room_types,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|regex:/^[0-9\s\-\+\(\)]{10,}$/',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_adults' => 'required|integer|min:1|max:10',
            'num_children' => 'required|integer|min:0|max:10',
            'special_requests' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'room_type_id.required' => 'Please select a room type',
            'room_type_id.exists' => 'Invalid room type selected',
            'customer_name.required' => 'Your name is required',
            'customer_phone.required' => 'Phone number is required',
            'customer_phone.regex' => 'Please enter a valid phone number',
            'check_in_date.required' => 'Check-in date is required',
            'check_in_date.after_or_equal' => 'Check-in date must be today or later',
            'check_out_date.required' => 'Check-out date is required',
            'check_out_date.after' => 'Check-out date must be after check-in date',
            'num_adults.required' => 'Number of adults is required',
            'num_adults.min' => 'At least 1 adult is required',
            'num_children.required' => 'Number of children is required',
        ];
    }
}
