<?php

namespace App\Http\Resources\Api\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DrivireServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => 1,
            'name' => "free",
            'desc' => "descfree",
            'price' => 52,
        ];
    }
}
