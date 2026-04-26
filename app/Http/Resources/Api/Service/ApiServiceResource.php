<?php

namespace App\Http\Resources\Api\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiServiceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->service_name,
            'name_ar' => $this->service_name_ar,
            'standard_bags' => $this->standard_bags,
            'standard_bags_ar' => $this->standard_bags_ar,

        ];
    }
}
