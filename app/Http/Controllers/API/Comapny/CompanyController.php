<?php

namespace App\Http\Controllers\Api\Comapny;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Comapny\ApiComapnyResource;
use App\Models\Company;
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
}
