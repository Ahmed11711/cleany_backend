<?php

namespace App\Http\Controllers\Company\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Service\CreateServiceRequest;
use App\Http\Requests\Company\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $companyId = $request->company_id;
        $services = Service::where('company_id', $companyId)->get();

        return $this->successResponse($services, 'List Of Service');
    }

    public function store(CreateServiceRequest $request)
    {

        $data = $request->validated();

        $data['company_id'] = $request->company_id;
        $services = Service::create($data);
        return $this->successResponse($services, 'created succfull');
    }
    // تحديث خدمة موجودة
    public function update(UpdateServiceRequest $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return $this->errorResponse('Service not found', 404);
        }

        if ($service->company_id != $request->company_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $data = $request->validated();

        $service->update($data);

        return $this->successResponse($service, 'Service updated successfully');
    }

    // حذف خدمة
    public function destroy(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return $this->errorResponse('Service not found', 404);
        }

        // التأكد من الصلاحية قبل الحذف
        if ($service->company_id != $request->company_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $service->delete();

        return $this->successResponse(null, 'Service deleted successfully');
    }
}
