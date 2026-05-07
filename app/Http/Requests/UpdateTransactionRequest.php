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
            'type' => 'required|in:sale,buy,trade_in',
            'amount' => 'required|numeric|min:0.01',
            'trade_in_watch_id' => 'nullable|exists:watches,id|required_if:type,trade_in',
            'trade_in_appraisal_value' => 'nullable|numeric|min:0|required_if:type,trade_in',
            'trade_in_cash_from' => 'nullable|in:company,client|required_if:type,trade_in',
            'invoice_number' => ['nullable', 'string', 'max:100', Rule::unique('transactions')->ignore($this->transaction)],
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
