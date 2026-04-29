<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'invoice_number' => 'nullable|string|unique:transactions|max:100',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
