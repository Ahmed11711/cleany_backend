<?php

namespace App\Http\Resources\Admin\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'hourly_rate' => $this->hourly_rate,
            'address' => $this->address,
            'phone' => $this->phone,
            'description' => $this->description,
            'rating' => $this->rating,
            'is_verified' => $this->is_verified,
            'free_delivery' => $this->free_delivery,
            'admin_id' => $this->admin_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
