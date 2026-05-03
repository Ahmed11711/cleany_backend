<?php

namespace App\Http\Requests\Admin\Contactus;
use App\Http\Requests\BaseRequest\BaseRequest;
class ContactusUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => 'sometimes|required|in:email,phone,whatsapp',
            'value' => 'sometimes|required|string|max:255',
        ];
    }
}
