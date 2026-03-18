<?php

namespace App\Repositories\Company;

use App\Http\Requests\Admin\Company\CompanyStoreRequest;
use App\Models\Company;
use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\Company\CompanyRepositoryInterface;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }
}
