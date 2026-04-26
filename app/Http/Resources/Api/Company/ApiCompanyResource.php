<?php

namespace App\Http\Resources\Api\Company;

use App\Http\Resources\Api\Service\ApiServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiCompanyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_ar' => $this->name_ar,
            'logo' => $this->logo,
            'rating' => $this->rating,
            'hourly_rate' => $this->hourly_rate,
            'region_id' => $this->pivot ? $this->pivot->region_id : null,
            'free_delivery' => $this->free_delivery,
            'services' => ApiServiceResource::collection($this->services),


        ];
    }
}
