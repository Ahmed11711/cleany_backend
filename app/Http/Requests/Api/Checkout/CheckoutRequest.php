<?php

namespace App\Http\Requests\Api\Checkout;

use App\Http\Requests\BaseRequest\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booking_id'     => 'required|exists:bookings,id',
            'payment_method' => 'required|in:wallet,payment,cash_on_hand',
        ];
    }
}
