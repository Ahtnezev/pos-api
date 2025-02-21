<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'The :attribute field is required.',
            'price.numeric' => 'The :attribute field must be a number.',
            'stock.integer' => 'The :attribute field must be an integer.'
        ];
    }
}
