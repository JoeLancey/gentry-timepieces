<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'watch_id' => 'required|exists:watches,id',
            'client_id' => 'required|exists:clients,id',
            'agreed_price' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,sold,returned,expired',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
