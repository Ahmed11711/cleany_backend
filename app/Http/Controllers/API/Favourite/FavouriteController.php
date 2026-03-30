<?php

namespace App\Http\Controllers\API\Favourite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Favou\FavRequest;
use App\Models\Company;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    use ApiResponseTrait;
    /**
     * Toggle a company as a favourite for the authenticated user.
     */
    public function toggle(FavRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();


        $companyId = $data['company'];
        // تنفيذ الـ Toggle
        $status = $user->favouriteCompanies()->toggle($companyId);

        if (count($status['attached']) > 0) {
            return response()->json(['message' => 'Added to favourites'], 201);
        }

        return response()->json(['message' => 'Removed from favourites'], 200);
    }

    /**
     * Display a list of the user's favourite companies.
     */
    public function index()
    {
        $favourites = Auth::user()->favouriteCompanies()->get();

        return $this->successResponse($favourites, "list");
        return response()->json([
            'data' => $favourites
        ], 200);
    }
}
