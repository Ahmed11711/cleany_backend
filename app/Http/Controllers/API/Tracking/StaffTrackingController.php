<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Services\Tracking\TrackingService;
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
        $location = $this->trackingService->getStaffLocation($id);

        if (!$location) {
            return response()->json([
                'status' => 'offline',
                'lat' => null,
                'lng' => null
            ], 200); // رجع 200 عشان الـ React ميفضلش يصرخ Errors
        }

        // رجع الـ location مباشرة عشان الـ React يقرأها بسهولة
        return response()->json([
            'lat' => $location['lat'],
            'lng' => $location['lng'],
            'status' => 'online'
        ]);
    }
}
