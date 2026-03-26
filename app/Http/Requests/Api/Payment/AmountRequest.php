<?php

namespace App\Http\Requests\Api\Payment;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AmountRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:5|max:10000'
        ];
    }
}
