<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest\BaseRequest;

class UserUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'sometimes|nullable|string|min:8|max:255',
            'role' => 'sometimes|required|in:super_admin,company,staff,user',
            'company_id' => 'sometimes|nullable|exists:companies,id',
            'is_active' => 'sometimes|boolean',
            'profile_photo' => 'sometimes|nullable|image|max:2048',
        ];
    }
}
