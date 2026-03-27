<?php

namespace App\Http\Controllers\Company\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Booking\UpdateBookingRequest;
use App\Models\booking;
use App\Traits\ApiResponseTrait;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $bookings = booking::where('company_id', $request->company_id)
            ->with(['service', 'staff', 'user'])
            ->latest()
            ->get();
        return $this->successResponse($bookings, 'Bookings retrieved');
    }

    public function updateStatus(UpdateBookingRequest $request, $id)
    {
        $data = $request->validated();
        $booking = Booking::find($id);
        $booking->status = $request->status;
        $booking->staff_id = $request->staff_id ?? null;
        $booking->save();
        return $this->successResponse($booking->load('service'), 'Status updated successfully');
    }
}
