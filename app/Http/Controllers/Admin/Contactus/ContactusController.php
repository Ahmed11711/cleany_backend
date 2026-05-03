<?php

namespace App\Http\Controllers\Admin\Contactus;

use App\Repositories\Contactus\ContactusRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Contactus\ContactusStoreRequest;
use App\Http\Requests\Admin\Contactus\ContactusUpdateRequest;
use App\Http\Resources\Admin\Contactus\ContactusResource;

class ContactusController extends BaseController
{
    public function __construct(ContactusRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Contactus'
        );

        $this->storeRequestClass = ContactusStoreRequest::class;
        $this->updateRequestClass = ContactusUpdateRequest::class;
        $this->resourceClass = ContactusResource::class;
    }
}
