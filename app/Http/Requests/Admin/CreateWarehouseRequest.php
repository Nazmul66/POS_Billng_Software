<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;  // By Default false but make this true
        return true; // Set to true to allow all authorized users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse' => ['required', 'max:155'],
            'contact_person' => ['required', 'integer', 'max:155'],
            'email' => ['nullable', 'email', 'max:155'],
            'phone' => ['required', 'regex:/^0\d{10}$/', 'max:11'],
            'address' => ['required', 'max:300'],
            'city' => ['required', 'max:155'],
            'state' => ['nullable', 'max:155'],
            'country' => ['required', 'max:155'],
            'postal_code' => ['nullable', 'max:155'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ];
    }


    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name is required.',
            'first_name.max' => 'The first name must not exceed 155 characters.',
            
            'last_name.required' => 'The last name is required.',
            'last_name.max' => 'The last name must not exceed 155 characters.',
            
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email must not exceed 155 characters.',
            
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'Please enter a valid phone number starting with 0 and having 11 digits.',
            'phone.max' => 'The phone number must not exceed 11 digits.',
            
            'address.required' => 'The address is required.',
            'address.max' => 'The address must not exceed 300 characters.',
            
            'city.required' => 'The city is required.',
            'city.max' => 'The city must not exceed 155 characters.',
            
            'state.required' => 'The state is required.',
            'state.max' => 'The state must not exceed 155 characters.',
            
            'country.required' => 'The country is required.',
            'country.max' => 'The country must not exceed 155 characters.',
            
            'postal_code.required' => 'The postal code is required.',
            'postal_code.max' => 'The postal code must not exceed 155 characters.',
            
            'image.image' => 'Please upload a valid image file.',
            'image.mimes' => 'Only PNG, JPG, JPEG, and WEBP formats are allowed.',
            'image.max' => 'The image size must not exceed 4MB.',
        ];
    }
}
