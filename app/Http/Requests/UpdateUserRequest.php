<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,staff,appraiser',
        ];
    }
}
