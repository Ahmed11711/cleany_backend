<?php

namespace App\Http\Requests\Comapny;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends BaseRequest
{


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string',
            'logo' => 'required|file',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'description' => 'required|string',
            'hourly_rate' => 'required'

        ];
    }
}
