<?php

namespace App\Http\Controllers\Admin\CategoryCompany;

use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\CategoryCompany\CategoryCompanyStoreRequest;
use App\Http\Requests\Admin\CategoryCompany\CategoryCompanyUpdateRequest;
use App\Http\Resources\Admin\CategoryCompany\CategoryCompanyResource;
use App\Repositories\CategoryCompany\CategoryCompanyRepositoryInterface;

class CategoryCompanyController extends BaseController
{
    public function __construct(CategoryCompanyRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'CategoryCompany'
        );

        $this->storeRequestClass = CategoryCompanyStoreRequest::class;
        $this->updateRequestClass = CategoryCompanyUpdateRequest::class;
        $this->resourceClass = CategoryCompanyResource::class;
    }
}
