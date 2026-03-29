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
            'standard_bags' => $this->standard_bags,

        ];
    }
}
