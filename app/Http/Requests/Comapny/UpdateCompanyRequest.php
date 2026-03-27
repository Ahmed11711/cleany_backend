<?php

namespace App\Http\Requests\Comapny;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|file',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'hourly_rate' => 'nullable'
        ];
    }
}
