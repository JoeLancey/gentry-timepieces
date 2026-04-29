<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
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
            'type' => 'required|in:sale,trade_in',
            'amount' => 'required|numeric|min:0.01',
            'invoice_number' => ['nullable', 'string', 'max:100', Rule::unique('transactions')->ignore($this->transaction)],
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
