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
            'service_name' => 'required|string',
            'price'        => 'required|numeric',
            'price_today'  => 'required|numeric',
            'discount'     => 'integer',
            'standard_bags' => 'nullable|string'
        ];
    }
}
