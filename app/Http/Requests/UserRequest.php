<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:client,vendor', //! Sólo estos dos roles permitidos
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'El campo :attribute es obligatorio',
            '*.string' => 'El campo :attribute debe ser un texto',

            'name' => [
                'max' => 'El campo :attribute no debe superar los :max caracteres'
            ],
            'email' => [
                'email' => 'El campo :attribute debe ser un email válido',
                'unique' => 'El campo :attribute ya está en uso'
            ],
            'password' => [
                'min' => 'El campo :attribute debe tener al menos :min caracteres',
            ],
            'role' => [
                'in' => 'Rol no válido'
            ],
        ];
    }
}
