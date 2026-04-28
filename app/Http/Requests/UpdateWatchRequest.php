<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'reference_number' => 'nullable|string|max:100',
            'serial_number' => ['required', 'string', 'max:100', Rule::unique('watches')->ignore($this->watch)],
            'year_produced' => 'nullable|integer|min:1800|max:' . now()->year,
            'condition' => 'required|in:mint,excellent,good,fair',
            'has_box' => 'boolean',
            'has_papers' => 'boolean',
            'asking_price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,sold,consigned,reserved',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
