<?php

namespace App\Http\Resources\Admin\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->whenLoaded('user', function () {
                return $this->user->name;
            }),
            'transaction_id' => $this->transaction_id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'type' => $this->type,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
