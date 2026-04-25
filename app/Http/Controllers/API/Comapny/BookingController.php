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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    use ApiResponseTrait;
    public function store(CreateBookingRequest $request)
    {
        $data = $request->validated();
        $userId = $request->user()->id;

        // Key مشترك لكل الـ bookings في نفس العملية
        $groupTransactionId = 'TRX-' . strtoupper(Str::random(10));

        $bookings = [];

        DB::beginTransaction();

        try {
            foreach ($data['services'] as $serviceData) {

                $service = Service::findOrFail($serviceData['service_id']);
                $bookingDate = Carbon::parse($serviceData['booking_date']);
                $isToday = $bookingDate->isToday();

                $unitPrice = ($isToday && $service->price_today)
                    ? $service->price_today
                    : $service->price;

                $subTotal   = $unitPrice * $serviceData['hours'];
                $totalPrice = $subTotal - ($subTotal * ($service->discount / 100));

                try {
                    $startTime = is_numeric($serviceData['start_time'])
                        ? Carbon::createFromFormat('H', $serviceData['start_time'])->startOfHour()
                        : Carbon::parse($serviceData['start_time']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'message' => 'Invalid time format for service_id ' . $serviceData['service_id']
                    ], 422);
                }

                $endTime = $startTime->copy()->addHours((int) $serviceData['hours']);

                $booking = Booking::create([
                    'user_id'          => $userId,
                    'company_id'       => $service->company_id,
                    'service_id'       => $service->id,
                    'booking_date'     => $serviceData['booking_date'],
                    'start_time'       => $startTime->format('H:i:s'),
                    'end_time'         => $endTime->format('H:i:s'),
                    'hours'            => $serviceData['hours'],
                    'unit_price'       => $unitPrice,
                    'discount_applied' => $service->discount,
                    'total_price'      => $totalPrice,
                    'status'           => 'pending',
                    'transaction_id'   => $groupTransactionId, // نفس الـ ID لكل الـ bookings
                ]);

                if (!empty($serviceData['package_sizes'])) {
                    foreach ($serviceData['package_sizes'] as $pkg) {
                        $booking->packageSizes()->create([
                            'package_size_id' => $pkg['id'],
                            'quantity'        => $pkg['quantity'],
                            'price'           => $pkg['price'],
                        ]);
                    }
                }

                $bookings[] = $booking->load('packageSizes');
            }

            DB::commit();

            return $this->successResponse([
                'transaction_id' => $groupTransactionId,
                'bookings'       => $bookings,
            ], 'Bookings created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    public function index(Request $request)
    {
        $userId = $request->user_id;

        // 1. جلب أحدث طلب Pending
        $currentOrder = booking::with('service')
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        // 2. جلب كل الطلبات كـ Collection
        $allOrders = booking::with('service')
            ->where('user_id', $userId)
            ->get(); // الـ get() دائماً بترجع Collection حتى لو فاضية

        // 3. التجميع
        $data = [
            // للـ Single Object بنستخدم new
            'current_order' => $currentOrder ? new AllBookingResource($currentOrder) : null,

            // للـ Collection بنستخدم ::collection
            'all_orders'    => AllBookingResource::collection($allOrders),
        ];

        return $this->successResponse($data, "List Of Orders");
    }

    public function show($id)
    {
        $order = booking::with(['service'])->find($id);

        if (!$order) {
            return $this->errorResponse("Order not found", 404);
        }

        $data = new AllBookingResource($order);

        return $this->successResponse($data, "Booking details retrieved successfully");
    }
}
