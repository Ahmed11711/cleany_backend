<?php

namespace App\Repositories\booking;

use App\Repositories\booking\bookingRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\booking;

class bookingRepository extends BaseRepository implements bookingRepositoryInterface
{
    public function __construct(booking $model)
    {
        parent::__construct($model);
    }
}
