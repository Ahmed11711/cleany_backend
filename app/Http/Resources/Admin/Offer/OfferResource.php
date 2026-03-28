<?php

namespace App\Http\Resources\Admin\Offer;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'image_path' => $this->image_path,
            'company_id' => $this->company_id,
            'company_name' => $this->whenLoaded('company', function () {
                return $this->company->name;
            }),
            'category_id' => $this->category_id,
            'category_name' => $this->whenLoaded('category', function () {
                return $this->category->name;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
