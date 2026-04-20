<?php

namespace App\Http\Requests\Company\Service;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'image' => 'nullable|file',
            'service_name_ar' => 'nullable|string',
            'service_name' => 'nullable|string',
            'price'        => 'nullable|numeric',
            'price_today'  => 'nullable|numeric',
            'discount'     => 'integer',
            'standard_bags' => 'nullable|string',
            'standard_bags_ar' => 'nullable|string',
            'max_staff' => 'nullable|integer',
            'price_staff' => 'nullable|integer',

        ];
    }
}
