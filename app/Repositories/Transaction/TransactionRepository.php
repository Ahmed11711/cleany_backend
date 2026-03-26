<?php

namespace App\Repositories\Transaction;

use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Transaction;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }
}
