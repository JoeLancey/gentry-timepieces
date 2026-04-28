<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'max:255', Rule::unique('clients')->ignore($this->client)],
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
