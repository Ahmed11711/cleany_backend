<?php

namespace App\Http\Controllers\API\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Services\Tracking\TrackingService;
use App\Models\booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffTrackingController extends Controller
{
    protected $trackingService;

    // حقن السيرفس (Dependency Injection)
    public function __construct(TrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = $request->user_id;

        // تمرير البيانات في Array كما هو محدد في الـ Service
        $this->trackingService->updateSingleStaff($userId, [
            'lat' => $request->lat,
            'lng' => $request->lng
        ]);

        return response()->json(['message' => 'Location updated in Redis']);
    }

    /**
     * جلب موقع موظف معين للأدمن
     */
    public function show($id)
    {
        $booking = booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }


        $location = $this->trackingService->getStaffLocation($booking->staff_id ?? 1);



        if (!$location) {
            return response()->json([
                'tracking_status' => 'offline',
                'lat' => 30.0444, // إحداثيات القاهرة (Dummy Data) للتيست لو حابب
                'lng' => 31.2357,
                'note' => 'Showing default location for testing'
            ]);
        }

        // لو اللوكيشن موجود
        return response()->json([
            'lat' => $location['lat'],
            'lng' => $location['lng'],
            'tracking_status' => 'online'
        ]);
    }
}
