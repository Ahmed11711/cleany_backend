<?php

namespace App\Http\Requests\Company\Service;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'image' => 'nullable|file',
            'service_name' => 'required|string',
            'service_name_ar' => 'nullable|string',
            'price'        => 'required|numeric',
            'price_today'  => 'required|numeric',
            'discount'     => 'integer',
            'standard_bags' => 'nullable|string',
            'standard_bags_ar' => 'nullable|string',
            'max_staff' => 'nullable|integer',
            'price_staff' => 'nullable|string',
        ];
    }
}
