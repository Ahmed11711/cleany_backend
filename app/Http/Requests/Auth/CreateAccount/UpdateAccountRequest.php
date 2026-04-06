<?php

namespace App\Http\Requests\Auth\CreateAccount;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends BaseRequest
{
    public function rules(): array
    {
        $userId = $this->route('id') ?? auth('api')->id();
        return [
            'name'     => 'nullable|string|max:255',

            Rule::unique('users', 'email')->ignore($userId),
            'phone'    => 'nullable|string|max:20',

            'password' => [
                'nullable',
                Password::min(8),
            ],



            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }

    /**
     * رسائل الخطأ بالإنجليزية كما طلبت سابقاً
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered.',
            'phone.unique' => 'This phone number is already in use.',
            'password.confirmed' => 'Password confirmation does not match.',
            'role.in' => 'The selected role is invalid.',
            'company_id.required_if' => 'The company ID is required when the role is staff.',
            'company_id.exists' => 'The selected company does not exist.',
        ];
    }
}
