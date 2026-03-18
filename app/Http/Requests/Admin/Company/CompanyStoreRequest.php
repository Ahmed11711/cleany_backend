<?php

namespace App\Http\Requests\Admin\Company;

use App\Http\Requests\BaseRequest\BaseRequest;

class CompanyStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'logo' => 'required|file',
            'hourly_rate' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'is_verified' => 'required|integer',
            'admin_id' => 'required|integer|exists:users,id',
        ];
    }
}
