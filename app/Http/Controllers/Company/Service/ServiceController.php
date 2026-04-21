<?php

namespace App\Http\Controllers\Company\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Service\CreateServiceRequest;
use App\Http\Requests\Company\Service\UpdateServiceRequest;
use App\Http\Requests\Company\ServiceItems\ServiceItemsRequest;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Traits\ApiResponseTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponseTrait, UploadImageTrait;

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
            $data['image'] = $this->uploadManager($request, $data, 'services', ['image']);
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
            // بتمرر الـ $service عشان الـ trait يحذف الصورة القديمة تلقائياً
            $data['image'] = $this->uploadManager($request, $data, 'services', ['image'], $service);
        }

        $service->update($data);
        return $this->successResponse($service->fresh(), 'Service updated successfully');
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

        // حذف الصورة يدوياً لأن الـ trait مش بيتعامل مع الحذف بدون request
        if ($service->image) {
            $oldRelativePath = last(explode('/media/', $service->image));
            $fullOldPath = public_path('media/' . $oldRelativePath);
            if (file_exists($fullOldPath)) {
                unlink($fullOldPath);
            }
        }

        $service->delete();
        return $this->successResponse(null, 'Service deleted successfully');
    }



    public function storeOrUpdate(ServiceItemsRequest $request)
    {
        $data = $request->validated();

        $item = $request->id
            ? ServiceItem::findOrFail($request->id)
            : new ServiceItem();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadManager($request, $data, 'service_items', ['image'], $item);
        }

        $item->fill($data);
        $item->save();

        return $this->successResponse($item, 'Service item saved successfully');
    }
}
