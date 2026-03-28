<?php

namespace App\Http\Resources\Admin\booking;

use Illuminate\Http\Resources\Json\JsonResource;

class bookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'service_id' => $this->service_id,
            'booking_date' => $this->booking_date,
            'start_time' => $this->start_time,
            'hours' => $this->hours,
            'end_time' => $this->end_time,
            'unit_price' => $this->unit_price,
            'discount_applied' => $this->discount_applied,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'address' => $this->address,
            'notes' => $this->notes,
            'staff_id' => $this->staff_id,
            'transaction_id' => $this->transaction_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
