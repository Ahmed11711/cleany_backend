<?php

namespace App\Repositories\CategoryCompany;

use App\Repositories\CategoryCompany\CategoryCompanyRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\CategoryCompany;

class CategoryCompanyRepository extends BaseRepository implements CategoryCompanyRepositoryInterface
{
    public function __construct(CategoryCompany $model)
    {
        parent::__construct($model);
    }
}
