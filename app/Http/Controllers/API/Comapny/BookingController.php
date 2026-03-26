<?php

namespace App\Http\Controllers\API\Comapny;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Booking\CreateBookingRequest;
use App\Http\Resources\Api\Booking\AllBookingResource;
use App\Models\booking;
use App\Models\Service;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    use ApiResponseTrait;
    public function store(CreateBookingRequest $request)
    {
        $data = $request->validated();
        $userId = $request->user_id;

        $service = Service::find($request->service_id);
        $bookingDate = Carbon::parse($request->booking_date);
        $isToday = $bookingDate->isToday();

        $unitPrice = ($isToday && $service->price_today) ? $service->price_today : $service->price;

        $subTotal = $unitPrice * $request->hours;
        $totalPrice = $subTotal - ($subTotal * ($service->discount / 100));

        // --- الحل هنا ---
        try {
            // لو الـ start_time مجرد رقم (ساعة)
            if (is_numeric($request->start_time)) {
                $startTime = Carbon::createFromFormat('H', $request->start_time)->startOfHour();
            } else {
                // لو باعت وقت كامل زي 09:30
                $startTime = Carbon::parse($request->start_time);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid time format. Use hour (e.g. 9) or HH:mm'], 422);
        }

        $endTime = $startTime->copy()->addHours((int) $request->hours);
        $booking = Booking::create([
            'user_id' => $userId,
            'company_id' => $service->company_id,
            'service_id' => $service->id,
            'booking_date' => $request->booking_date,
            'start_time' => $startTime->format('H:i:s'), // هيتخزن 09:00:00
            'hours' => $request->hours,
            'end_time' => $endTime->format('H:i:s'),
            'unit_price' => $unitPrice,
            'discount_applied' => $service->discount,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return $this->successResponse($booking, 'Booking created successfully');
    }

    public function index(Request $request)
    {
        $userId = $request->user_id; // أو auth()->id() للأمان

        // 1. جلب الطلبات الحالية (Pending فقط)
        $currentOrders = booking::with('service')
            ->where('user_id', $userId)
            ->where('status', 'pending') // تأكد من اسم العمود والحالة عندك
            ->latest()->first();

        // 2. جلب كل الطلبات (أو الطلبات المنتهية فقط حسب رغبتك)
        $allOrders = booking::with('service')
            ->where('user_id', $userId)
            ->get();

        // 3. تجميع البيانات في الرد
        $data = [
            'current_orders' => AllBookingResource::collection($currentOrders),
            'all_orders'     => AllBookingResource::collection($allOrders),
        ];

        return $this->successResponse($data, "List Of Orders");
    }
}
