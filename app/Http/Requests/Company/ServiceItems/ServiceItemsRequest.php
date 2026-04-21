<?php

namespace App\Http\Requests\Company\ServiceItems;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceItemsRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'service_id'     => 'required|exists:services,id',
            'name'           => 'required|string|max:255',
            'name_ar'        => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
