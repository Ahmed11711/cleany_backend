<?php

namespace App\Http\Resources\Api\Booking;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'service_id' => $this->service_id,
            'service_name' => $this->service->service_name ?? null,
            'status' => $this->status,
            'booking_date' => $this->booking_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'address' => $this->address,
            'notes' => $this->notes,

            'hours' => $this->hours,
            'unit_price' => $this->unit_price,
            'discount_applied' => $this->discount_applied,
            'total_price' => $this->total_price,


            'created_at' => $this->created_at->format('d M Y'),
        ];
    }
}
