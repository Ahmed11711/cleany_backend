<?php

namespace App\Http\Resources\Api\Comapny;

use App\Http\Resources\Admin\Specialty\SpecialtyResource;
use App\Http\Resources\Api\Service\ApiServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiComapnyResource extends JsonResource
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
            'name' => $this->name,
            'name_ar' => $this->name_ar,
            'logo' => $this->logo,
            'description' => $this->description,
            'description_ar' => $this->description_ar,
            'rating' => $this->rating,
            'is_verified' => $this->is_verified,
            'price' => $this->hourly_rate,
            'free_delivery' => $this->free_delivery,
            'max_staff' => 10,
            'price_staff' => 5,
            'services' => ApiServiceResource::collection($this->whenLoaded('services')),
            'specialties' => SpecialtyResource::collection($this->whenLoaded('specialties')),

        ];
    }
}
