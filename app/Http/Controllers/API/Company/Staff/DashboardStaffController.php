<?php

namespace App\Http\Controllers\API\Company\Staff;

use App\Http\Controllers\Controller;
use App\Models\booking;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class DashboardStaffController extends Controller
{
    use ApiResponseTrait;
    public function getMyBookings(Request $request)
    {
        $staffId = $request->user_id;

        $bookings = booking::where('staff_id', $staffId)->get();

        return $this->successResponse($bookings, "List Of Booings");
    }

    // 2. تحديث الحالة
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:on_the_way,in_progress'
        ]);

        $booking = Booking::where('staff_id', $request->user_id)->findOrFail($id);
        $booking->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated successfully', 'booking' => $booking]);
    }

    // 3. إنهاء الحجز
    public function completeBooking(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
            'before_photo' => 'nullable|string', // أو file إذا كنت ترفع ملفات
            'after_photo' => 'nullable|string'
        ]);

        $booking = Booking::where('staff_id', $request->user_id)->findOrFail($id);

        $booking->update([
            'status' => 'completed',
            'notes' => $request->notes,
            'payment_status' => $booking->payment_status === 'cash_on_hand' ? 'paid' : $booking->payment_status
        ]);

        return response()->json(['message' => 'Booking completed successfully']);
    }
}
    // 4. تحديث الموقع
//     public function updateLocation(Request $request)
//     {
//         $request->validate([
//             'lat' => 'required|numeric',
//             'lng' => 'required|numeric'
//         ]);

//         // تحديث إحداثيات الموظف في جدول المستخدمين (users) أو جدول خاص بالمواقع
//         Auth::user()->update([
//             'current_lat' => $request->lat,
//             'current_lng' => $request->lng,
//             'last_location_update' => now()
//         ]);

//         return response()->json(['status' => 'Location updated']);
//     }
// }
