<?php

namespace App\Http\Resources\Api\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'transaction_id' => $this->transaction_id,
            'order_id'       => $this->order_id,
            'amount'         => $this->amount,
            'type'           => $this->type,
            'payment_method' => $this->payment_method,
            'status'         => $this->status,
            'notes'          => $this->notes,
            'service_id'     => $this->service_id,
            // Accessing the relationship safely
            'service_name'   => $this->service->service_name ?? "Deposite",
            'created_at'     => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'     => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
