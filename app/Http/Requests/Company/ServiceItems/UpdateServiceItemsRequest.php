<?php

namespace App\Http\Requests\Company\ServiceItems;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceItemsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'service_id'     => 'nullable|exists:services,id',
            'name'           => 'nullable|string|max:255',
            'name_ar'        => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price'          => 'nullable|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
