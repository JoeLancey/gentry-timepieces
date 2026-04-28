<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|regex:/^[0-9\-\+\(\)\s]+$/',
            'email' => 'nullable|email|max:255|unique:clients',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone number format is invalid.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
