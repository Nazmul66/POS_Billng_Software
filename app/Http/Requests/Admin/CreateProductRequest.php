<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        $purchase_price = $this->input('purchase_price'); // Access input directly
        $selling_price  = $this->input('selling_price'); // Access input directly

        return [
            'name'            => ['required', 'unique:products,name', 'max:255'],
            'thumb_image'     => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'sku'             => ['required', 'max:155'],
            'category_id'     => ['required', 'numeric'],
            'subCategory_id'  => ['nullable', 'numeric'],
            'brand_id'        => ['required', 'numeric'],
            'purchase_price'  => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($selling_price) {
                    if ($value >= $selling_price) {
                        $fail('The Purchase price must be greater than the Selling price.');
                    }
                },
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($purchase_price) {
                    if ($value <= $purchase_price) {
                        $fail('The selling price must be greater than the purchase price.');
                    }
                },
            ],
            'qty'   => ['required', 'numeric', 'min:0'],
            'units' => ['required', 'string'],
            'long_description' => ['required'],
        ];
    }


    public function messages(): array
    {
        return [
            'thumb_image.required' => 'Product Image is required',
            'thumb_image.image' => 'The uploaded file must be an image',
            'thumb_image.mimes' => 'The image must be a file of type: ( png, jpg, jpeg, webp )',

            'name.required' => 'Please fill up Product name',
            'name.max' => 'Character might be 255 word',
            'name.unique' => 'Character might be unique',
            'name.unique' => 'Character might be unique',

            'category_id.required' => 'Please Select the Category Name',
            'brand_id.required' => 'Please Select the Brand Name',
            'qty.required' => 'Please add product quantity',

            'purchase_price.required' => 'The purchase price is required.',
            'purchase_price.numeric' => 'The purchase price must be a valid number.',

            'selling_price.required' => 'The selling price is required.',
            'selling_price.numeric' => 'The selling price must be a valid number.',
            'long_description.required' => 'Please add long description',
        ];
    }
}
