<?php

namespace App\Http\Controllers\API\Region;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {

        $regions = Region::get();
        return $this->successResponse($regions, "List Of Regions");
    }
}
