<?php

namespace App\Http\Requests\Admin\Specialty;
use App\Http\Requests\BaseRequest\BaseRequest;
class SpecialtyStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'required|integer',
            'company_id' => 'required|integer|exists:companies,id',
        ];
    }
}
