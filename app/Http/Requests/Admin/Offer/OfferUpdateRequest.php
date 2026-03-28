<?php

namespace App\Http\Requests\Admin\Offer;
use App\Http\Requests\BaseRequest\BaseRequest;
class OfferUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|sometimes|string',
            'is_active' => 'sometimes|required|integer',
            'image_path' => 'nullable|sometimes|string|max:255|file|max:2048',
            'company_id' => 'nullable|sometimes|integer|exists:companies,id',
            'category_id' => 'nullable|sometimes|integer|exists:categories,id',
        ];
    }
}
