<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\BaseRequest\BaseRequest;

class CategoryStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'is_active' => 'required|integer',
            'image' => 'required|file',
        ];
    }
}
