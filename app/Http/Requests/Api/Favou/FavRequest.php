<?php

namespace App\Http\Requests\Api\Favou;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FavRequest extends BaseRequest
{


    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }
}
