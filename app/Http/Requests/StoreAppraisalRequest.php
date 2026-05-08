<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppraisalRequest extends FormRequest
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
            'watch_reference_number' => 'nullable|string|max:100',
            'watch_serial_number' => 'required|string|unique:watches,serial_number|max:100',
            'watch_year_produced' => 'nullable|integer|min:1800|max:' . now()->year,
            'watch_condition' => 'required|in:mint,excellent,good,fair',
            'watch_has_box' => 'boolean',
            'watch_has_papers' => 'boolean',
            'watch_description' => 'nullable|string|max:1000',
            'client_id' => 'nullable|exists:clients,id',
            'appraiser_id' => 'required|exists:users,id',
            'appraised_value' => 'required|numeric|min:0',
            'condition_notes' => 'required|string|max:1000',
            'has_box' => 'boolean',
            'has_papers' => 'boolean',
            'status' => 'required|in:pending,completed,rejected',
        ];
    }
}
