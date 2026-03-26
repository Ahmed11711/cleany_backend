<?php

namespace App\Http\Requests\Admin\Specialty;
use App\Http\Requests\BaseRequest\BaseRequest;
class SpecialtyUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'is_active' => 'sometimes|required|integer',
            'company_id' => 'sometimes|required|integer|exists:companies,id',
        ];
    }
}
