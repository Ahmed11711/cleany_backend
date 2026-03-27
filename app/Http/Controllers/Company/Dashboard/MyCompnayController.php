<?php

namespace App\Http\Controllers\Company\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company\CompanyStoreRequest;
use App\Http\Requests\Admin\Company\CompanyUpdateRequest;
use App\Http\Requests\Comapny\StoreCompanyRequest;
use App\Http\Requests\Comapny\UpdateCompanyRequest;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Traits\ApiResponseTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class MyCompnayController extends Controller
{
    use ApiResponseTrait, UploadImageTrait;

    public function __construct(public CompanyRepositoryInterface $companyRepo) {}

    public function index(Request $request)
    {
        return $this->successResponse($this->companyRepo->findBYKey('admin_id', $request->user_id), 'Company retrieved successfully');
    }

    public function store(StoreCompanyRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->user_id;
        if ($this->companyRepo->findBYKey('admin_id', $request->user_id)) {
            return $this->errorResponse('Company already exists for this user', 400);
        }
        $data['logo'] = $this->uploadManager($request, $data, 'Company', ['logo']);

        $company = $this->companyRepo->create($data);
        return $this->successResponse($company, 'Company created successfully');
    }

    public function update(UpdateCompanyRequest $request)
    {
        $data = $request->validated();

        // تأكد من تحويل free_delivery لـ integer إذا كان جاي نص من الـ FormData
        if ($request->has('free_delivery')) {
            $data['free_delivery'] = filter_var($request->free_delivery, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        $company = $this->companyRepo->findBYKey('admin_id', $request->user_id);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadManager($request, $data, 'Company', ['logo'], $company);
        }

        $company->update($data);
        return $this->successResponse($company->refresh(), 'Company updated successfully');
    }
}
