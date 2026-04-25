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
            // Global fields
            'address'                                   => 'nullable|string',
            'notes'                                     => 'nullable|string',

            // Services array
            'services'                                  => 'required|array|min:1',
            'services.*.service_id'                     => 'required|exists:services,id',
            'services.*.hours'                          => 'required|integer|min:1',
            'services.*.start_time'                     => 'required',
            'services.*.booking_date'                   => 'required|date|after_or_equal:today',
            'services.*.package_sizes'                  => 'nullable|array',
            'services.*.package_sizes.*.id'             => 'required|integer',
            'services.*.package_sizes.*.quantity'       => 'required|integer|min:1',
            'services.*.package_sizes.*.price'          => 'required|numeric|min:0',
        ];
    }
}
