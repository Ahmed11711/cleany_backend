<?php

namespace App\Http\Requests\Auth\CreateAccount;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Validation\Rules\Password;

class CreateAccountRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',

            'email' => 'required|email|unique:users,email,',
            'phone'    => 'required|string|max:20',

            'password' => [
                'required',
                Password::min(8),
            ],



            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg', // 2MB كحد أقصى
            'fcm_token' => 'nullable|string'

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
