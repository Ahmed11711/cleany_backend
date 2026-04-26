<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactusRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'phone' => 'required|string',
            'name' => 'nullable|string',
            'message' => 'required|string',
        ];
    }
}
