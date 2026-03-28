<?php

namespace App\Http\Requests\Admin\booking;
use App\Http\Requests\BaseRequest\BaseRequest;
class bookingStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'company_id' => 'required|integer|exists:companies,id',
            'service_id' => 'required|integer|exists:services,id',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'hours' => 'required|integer',
            'end_time' => 'required',
            'unit_price' => 'required|numeric',
            'discount_applied' => 'required|integer',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,confirmed,completed,cancelled,on_the_way,in_progress',
            'payment_status' => 'required|in:unpaid,paid,cash_on_hand',
            'payment_method' => 'nullable|in:wallet,cash_on_hand,payment',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'staff_id' => 'nullable|integer',
            'transaction_id' => 'nullable|string|max:255|exists:transactions,id',
        ];
    }
}
