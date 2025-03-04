<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;  // By Default false but make this true
        return true; // Set to true to allow all authorized users
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:categories,name', 'max:255'],
            'img' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Please fill up Category name',
            'name.max' => 'Character might be 255 word',
            'name.unique' => 'Character might be unique',
            'img.required' => 'Category Image is required',
            'img.image' => 'The uploaded file must be an image',
            'img.mimes' => 'The image must be a file of type: ( png, jpg, jpeg, webp )',
        ];
    }
}
