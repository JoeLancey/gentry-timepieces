<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'watch_brand' => 'required|string|max:100',
            'watch_model' => 'required|string|max:100',
            'watch_serial_number' => 'required|string|unique:watches,serial_number|max:100',
            'watch_reference_number' => 'nullable|string|max:100',
            'watch_year_produced' => 'nullable|integer|min:1800|max:' . now()->year,
            'watch_condition' => 'required|in:mint,excellent,good,fair',
            'watch_has_box' => 'boolean',
            'watch_has_papers' => 'boolean',
            'watch_asking_price' => 'required|numeric|min:0',
            'watch_cost_price' => 'required|numeric|min:0',
            'watch_description' => 'nullable|string|max:1000',
            'client_id' => 'required|exists:clients,id',
            'agreed_price' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date|after:yesterday',
            'end_date' => 'nullable|date|after:start_date',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after' => 'End date must be after start date.',
        ];
    }
}
