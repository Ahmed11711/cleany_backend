<?php

namespace App\Repositories\Offer;

use App\Repositories\Offer\OfferRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Offer;

class OfferRepository extends BaseRepository implements OfferRepositoryInterface
{
    public function __construct(Offer $model)
    {
        parent::__construct($model);
    }
}
