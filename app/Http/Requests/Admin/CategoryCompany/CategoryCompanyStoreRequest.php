<?php

namespace App\Http\Requests\Admin\CategoryCompany;
use App\Http\Requests\BaseRequest\BaseRequest;
class CategoryCompanyStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required|integer|exists:companies,id',
            'category_id' => 'required|integer|exists:categories,id',
            'region_id' => 'nullable|integer|exists:regions,id',
        ];
    }
}
