<?php

namespace App\Http\Requests\Admin\Transaction;
use App\Http\Requests\BaseRequest\BaseRequest;
class TransactionUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'transaction_id' => 'nullable|sometimes|string|max:255|exists:transactions,id',
            'order_id' => 'nullable|sometimes|integer',
            'amount' => 'sometimes|required|numeric',
            'type' => 'sometimes|required|in:deposit,payment',
            'payment_method' => 'sometimes|required|in:wallet,cash,credit',
            'status' => 'sometimes|required|in:pending,success,failed',
            'notes' => 'nullable|sometimes|string',
        ];
    }
}
