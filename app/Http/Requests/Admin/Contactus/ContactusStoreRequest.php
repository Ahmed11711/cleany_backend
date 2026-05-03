<?php

namespace App\Http\Requests\Admin\Contactus;
use App\Http\Requests\BaseRequest\BaseRequest;
class ContactusStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => 'required|in:email,phone,whatsapp',
            'value' => 'required|string|max:255',
        ];
    }
}
