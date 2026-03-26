<?php

namespace App\Http\Requests\Admin\CategoryCompany;
use App\Http\Requests\BaseRequest\BaseRequest;
class CategoryCompanyUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => 'sometimes|required|integer|exists:companies,id',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'region_id' => 'nullable|sometimes|integer|exists:regions,id',
        ];
    }
}
