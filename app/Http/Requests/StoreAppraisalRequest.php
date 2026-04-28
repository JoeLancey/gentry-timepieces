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
            'watch_id' => 'required|exists:watches,id',
            'client_id' => 'required|exists:clients,id',
            'appraiser_id' => 'required|exists:users,id',
            'appraised_value' => 'required|numeric|min:0',
            'condition_notes' => 'required|string|max:1000',
            'has_box' => 'boolean',
            'has_papers' => 'boolean',
            'status' => 'required|in:pending,completed,rejected',
        ];
    }
}
