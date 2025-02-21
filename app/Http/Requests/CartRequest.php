<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            '*.min' => 'The :attribute field must be at least :min',
            '*.required' => 'The :attribute field is required',
            '*.integer' => 'The :attribute field must be an integer'
        ];
    }
}
