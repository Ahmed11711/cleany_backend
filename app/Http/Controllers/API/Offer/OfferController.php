<?php

namespace App\Http\Controllers\Api\Offer;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OfferController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request): JsonResponse
    {
        if ($request->has('category_id')) {
            $categoryId = $request->query('category_id');

            $offers = Offer::where('category_id', $categoryId)->get();
        } else {
            $offers = Offer::whereNull('category_id')->get();
        }

        return $this->successResponse($offers);
    }
}
