<?php

namespace App\Http\Requests\Admin\Offer;
use App\Http\Requests\BaseRequest\BaseRequest;
class OfferStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|integer',
            'image_path' => 'nullable|string|max:255|file|max:2048',
            'company_id' => 'nullable|integer|exists:companies,id',
            'category_id' => 'nullable|integer|exists:categories,id',
        ];
    }
}
