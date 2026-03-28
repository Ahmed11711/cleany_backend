<?php

namespace App\Http\Requests\Admin\booking;
use App\Http\Requests\BaseRequest\BaseRequest;
class bookingUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'company_id' => 'sometimes|required|integer|exists:companies,id',
            'service_id' => 'sometimes|required|integer|exists:services,id',
            'booking_date' => 'sometimes|required|date',
            'start_time' => 'sometimes|required',
            'hours' => 'sometimes|required|integer',
            'end_time' => 'sometimes|required',
            'unit_price' => 'sometimes|required|numeric',
            'discount_applied' => 'sometimes|required|integer',
            'total_price' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|in:pending,confirmed,completed,cancelled,on_the_way,in_progress',
            'payment_status' => 'sometimes|required|in:unpaid,paid,cash_on_hand',
            'payment_method' => 'nullable|sometimes|in:wallet,cash_on_hand,payment',
            'address' => 'nullable|sometimes|string|max:255',
            'notes' => 'nullable|sometimes|string',
            'staff_id' => 'nullable|sometimes|integer',
            'transaction_id' => 'nullable|sometimes|string|max:255|exists:transactions,id',
        ];
    }
}
