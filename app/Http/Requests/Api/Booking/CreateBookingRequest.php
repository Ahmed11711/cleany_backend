<?php

namespace App\Http\Requests\Api\Booking;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'hours' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'address' => 'nullable|string',
            'addres_id' => 'required|string',
            'count_staff' => 'nullable|integer|min:1'
        ];
    }
}
