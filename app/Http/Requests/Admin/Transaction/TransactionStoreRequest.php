<?php

namespace App\Http\Requests\Admin\Transaction;
use App\Http\Requests\BaseRequest\BaseRequest;
class TransactionStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'transaction_id' => 'nullable|string|max:255|exists:transactions,id',
            'order_id' => 'nullable|integer',
            'amount' => 'required|numeric',
            'type' => 'required|in:deposit,payment',
            'payment_method' => 'required|in:wallet,cash,credit',
            'status' => 'required|in:pending,success,failed',
            'notes' => 'nullable|string',
        ];
    }
}
