<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    
     // Determine if the user is authorized to make this request.
     
     public function authorize()
     {
        return true; // Set to true to authorize all users (adjust as needed)
    }

    // Get the validation rules that apply to the request.
     
    public function rules()
    {
        return [
            'product_name' => 'required|string|min:3|max:255|unique:products,product_name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }
}
