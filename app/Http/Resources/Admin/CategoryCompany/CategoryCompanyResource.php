<?php

namespace App\Http\Resources\Admin\CategoryCompany;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCompanyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'company_id' => $this->company_id,
            'region_id' => $this->region_id,
            'category_name' => $this->category?->name ?? null,
            'company_name' => $this->company?->name ?? null,
            'region_name' => $this->region?->name ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
