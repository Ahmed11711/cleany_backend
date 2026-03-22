<?php

namespace App\Http\Requests\Admin\Company;

use App\Http\Requests\BaseRequest\BaseRequest;

class CompanyUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'logo' => 'nullable|sometimes|file',
            'hourly_rate' => 'nullable|sometimes|numeric|min:0',
            'address' => 'nullable|sometimes|string|max:255',
            'phone' => 'nullable|sometimes|string|max:255',
            'description' => 'nullable|sometimes|string',
            'rating' => 'nullable|sometimes|numeric|min:0|max:5',
            'is_verified' => 'sometimes|required|integer',
            'admin_id' => 'sometimes|required|integer|exists:users,id',
            'free_delivery' => 'nullable|sometimes|boolean',
        ];
    }
}
