<?php

namespace App\Http\Requests\Api\Checkout;

use App\Http\Requests\BaseRequest\BaseRequest;

class CheckoutRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'booking_id'     => 'required|exists:bookings,id',
            'payment_method' => 'required|in:wallet,payment,cash_on_hand',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'booking_id.required' => 'The booking ID is mandatory to proceed.',
            'booking_id.exists'   => 'The selected booking does not exist in our records.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in'       => 'The payment method must be one of: wallet, payment, or cash_on_hand.',
        ];
    }
}
