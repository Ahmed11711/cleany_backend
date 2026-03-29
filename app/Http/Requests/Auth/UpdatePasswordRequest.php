<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'old_password' => 'required',

            'password' => 'required|string|min:8|different:old_password',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'old_password.required' => 'Please enter your current password.',
            'password.required'     => 'Please enter a new password.',
            'password.min'          => 'The new password must be at least 8 characters.',
            'password.confirmed'    => 'The password confirmation does not match.',
            'password.different'    => 'The new password must be different from the current password.',
        ];
    }
}
