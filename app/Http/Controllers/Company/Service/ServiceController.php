<?php

namespace App\Http\Controllers\Company\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Service\CreateServiceRequest;
use App\Http\Requests\Company\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($data);
        return $this->successResponse($service, 'Created successfully');
    }

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

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة لو موجودة
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);
        return $this->successResponse($service, 'Service updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return $this->errorResponse('Service not found', 404);
        }
        if ($service->company_id != $request->company_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        // حذف الصورة من الـ storage
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        return $this->successResponse(null, 'Service deleted successfully');
    }
}
