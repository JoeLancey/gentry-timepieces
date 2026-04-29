<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_id' => 'required|exists:transactions,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:cash,bank_transfer,check',
            'reference_number' => 'nullable|string|max:100',
            'proof_path' => 'nullable|file|image|max:5120',
            'status' => 'required|in:pending,confirmed,failed',
        ];
    }
}
