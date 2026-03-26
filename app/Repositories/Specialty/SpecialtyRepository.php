<?php

namespace App\Repositories\Specialty;

use App\Repositories\Specialty\SpecialtyRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Specialty;

class SpecialtyRepository extends BaseRepository implements SpecialtyRepositoryInterface
{
    public function __construct(Specialty $model)
    {
        parent::__construct($model);
    }
}
