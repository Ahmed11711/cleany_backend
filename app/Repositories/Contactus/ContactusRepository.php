<?php

namespace App\Repositories\Contactus;

use App\Repositories\Contactus\ContactusRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Contactus;

class ContactusRepository extends BaseRepository implements ContactusRepositoryInterface
{
    public function __construct(Contactus $model)
    {
        parent::__construct($model);
    }
}
