<?php

namespace App\Http\Requests\Company\Booking;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,confirmed,cancelled',
        ];
    }
}
