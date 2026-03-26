<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest\BaseRequest;

class UserStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|in:super_admin,company,staff,user',
            'company_id' => 'nullable|exists:companies,id',
            'is_active' => 'boolean',
            'profile_photo' => 'nullable|image|max:2048',
        ];
    }
}
