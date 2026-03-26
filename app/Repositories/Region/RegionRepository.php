<?php

namespace App\Repositories\Region;

use App\Repositories\Region\RegionRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Region;

class RegionRepository extends BaseRepository implements RegionRepositoryInterface
{
    public function __construct(Region $model)
    {
        parent::__construct($model);
    }
}
