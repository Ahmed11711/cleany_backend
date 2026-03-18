<?php

namespace App\Http\Controllers\Admin\Region;

use App\Repositories\Region\RegionRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Region\RegionStoreRequest;
use App\Http\Requests\Admin\Region\RegionUpdateRequest;
use App\Http\Resources\Admin\Region\RegionResource;

class RegionController extends BaseController
{
    public function __construct(RegionRepositoryInterface $repository)
    {
        parent::__construct();
        $this->useCache = true;


        $this->initService(
            repository: $repository,
            collectionName: 'Region'
        );

        $this->storeRequestClass = RegionStoreRequest::class;
        $this->updateRequestClass = RegionUpdateRequest::class;
        $this->resourceClass = RegionResource::class;
    }
}
