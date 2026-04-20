<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class Address extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string',
            'address'      => 'required|string',
            'city'         => 'required|string',
            'country'      => 'required|string',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            'state'        => 'nullable|string',
            'postal_code'  => 'nullable|string',
        ];
    }
}
