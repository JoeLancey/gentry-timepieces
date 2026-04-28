<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'method' => 'required|in:cash,card,bank_transfer,cheque',
            'reference_number' => 'nullable|string|max:100',
            'proof_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'status' => 'required|in:pending,confirmed,rejected',
        ];
    }
}
