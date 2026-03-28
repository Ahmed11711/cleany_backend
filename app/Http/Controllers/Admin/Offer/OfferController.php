<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Repositories\Offer\OfferRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Offer\OfferStoreRequest;
use App\Http\Requests\Admin\Offer\OfferUpdateRequest;
use App\Http\Resources\Admin\Offer\OfferResource;

class OfferController extends BaseController
{
    public function __construct(OfferRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Offer',
            fileFields: ['image_path']
        );

        $this->withRelationships = ['category', 'company'];
        $this->storeRequestClass = OfferStoreRequest::class;
        $this->updateRequestClass = OfferUpdateRequest::class;
        $this->resourceClass = OfferResource::class;
    }
}
