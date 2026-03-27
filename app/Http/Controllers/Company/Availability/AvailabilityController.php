<?php

namespace App\Http\Controllers\Company\Availability;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $availability = Availability::where('company_id', $request->company_id)->get();
        return $this->successResponse($availability, 'all date');
    }
    public function sync(Request $request, $serviceId)
    {
        $request->validate([
            'slots' => 'required|array',
            'slots.*.day_of_week' => 'required|integer|between:0,6',
            'slots.*.start_time' => 'required',
            'slots.*.end_time' => 'required',
            'slots.*.is_available' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $companyId = $request->company_id;

            Availability::where('service_id', $serviceId)
                ->where('company_id', $companyId)
                ->delete();

            $dataToInsert = [];
            foreach ($request->slots as $slot) {
                $dataToInsert[] = [
                    'company_id'   => $companyId,
                    'service_id'   => $serviceId,
                    'day_of_week'  => $slot['day_of_week'],
                    'start_time'   => $slot['start_time'],
                    'end_time'     => $slot['end_time'],
                    'is_available' => $slot['is_available'] ?? true,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }

            Availability::insert($dataToInsert);

            DB::commit();

            return $this->successResponse($serviceId, 'Availability updated successfully for service');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Something went wrong');
        }
    }
}
