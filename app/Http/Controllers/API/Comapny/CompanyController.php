<?php

namespace App\Http\Controllers\API\Comapny;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Comapny\ApiComapnyResource;
use App\Models\Company;
use App\Models\Service;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * @tags Mobile App
     */
    use ApiResponseTrait;
    public function show($companyId)
    {
        $company = Company::with(['services', 'specialties'])->find($companyId);
        return $this->successResponse(
            new ApiComapnyResource($company),
            'Company details retrieved successfully'
        );
    }

    public function index()
    {
        $companies = Company::with(['services', 'specialties'])->limit(5)->get();
        return $this->successResponse(

            ApiComapnyResource::collection($companies),
            'Company details retrieved successfully'
        );
    }

    public function getAvailableSlots($id)
    {
        $services = Service::with(['availabilities'])
            ->where('company_id', $id)
            ->get();

        if ($services->isEmpty()) {
            return $this->errorResponse('No services found for this company', 404);
        }

        return $this->successResponse($services, 'Available slots retrieved successfully');
    }
}
