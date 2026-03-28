<?php

namespace App\Http\Controllers\Admin\booking;

use App\Repositories\booking\bookingRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\booking\bookingStoreRequest;
use App\Http\Requests\Admin\booking\bookingUpdateRequest;
use App\Http\Resources\Admin\booking\bookingResource;

class bookingController extends BaseController
{
    public function __construct(bookingRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'booking'
        );

        $this->withRelationships = ['user', 'company', 'staff', 'service'];

        $this->storeRequestClass = bookingStoreRequest::class;
        $this->updateRequestClass = bookingUpdateRequest::class;
        $this->resourceClass = bookingResource::class;
    }
}
