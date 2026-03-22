<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Transaction\TransactionStoreRequest;
use App\Http\Requests\Admin\Transaction\TransactionUpdateRequest;
use App\Http\Resources\Admin\Transaction\TransactionResource;

class TransactionController extends BaseController
{
    public function __construct(TransactionRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Transaction'
        );

        $this->storeRequestClass = TransactionStoreRequest::class;
        $this->updateRequestClass = TransactionUpdateRequest::class;
        $this->resourceClass = TransactionResource::class;
    }
}
