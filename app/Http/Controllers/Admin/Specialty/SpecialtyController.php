<?php

namespace App\Http\Controllers\Admin\Specialty;

use App\Repositories\Specialty\SpecialtyRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Specialty\SpecialtyStoreRequest;
use App\Http\Requests\Admin\Specialty\SpecialtyUpdateRequest;
use App\Http\Resources\Admin\Specialty\SpecialtyResource;

class SpecialtyController extends BaseController
{
    public function __construct(SpecialtyRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Specialty'
        );

        $this->storeRequestClass = SpecialtyStoreRequest::class;
        $this->updateRequestClass = SpecialtyUpdateRequest::class;
        $this->resourceClass = SpecialtyResource::class;
    }
}
