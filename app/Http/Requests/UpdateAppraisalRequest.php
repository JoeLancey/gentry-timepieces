<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppraisalRequest extends FormRequest
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
            'watch_serial_number' => 'required|string|max:100|unique:watches,serial_number,' . $this->route('appraisal')->watch_id,
            'watch_year_produced' => 'nullable|integer|min:1800|max:' . now()->year,
            'watch_condition' => 'required|in:mint,excellent,good,fair',
            'watch_has_box' => 'boolean',
            'watch_has_papers' => 'boolean',
            'watch_description' => 'nullable|string|max:1000',
            'client_id' => 'nullable|exists:clients,id',
            'appraiser_id' => 'required|exists:users,id',
            'appraised_value' => 'required_if:status,completed|nullable|numeric|min:0',
            'condition_notes' => 'required_if:status,completed|nullable|string|max:1000',
            'review_notes' => 'nullable|string|max:1000',
            'has_box' => 'boolean',
            'has_papers' => 'boolean',
            'status' => 'required|in:pending,checking,completed,rejected',
        ];
    }
}
