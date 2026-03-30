<?php

namespace App\Http\Controllers\API\Favourite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    use ApiResponseTrait;
    /**
     * Toggle a company as a favourite for the authenticated user.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $user = Auth::user();
        $companyId = $request->company_id;

        // toggle() is a magic method for many-to-many relationships.
        // It inserts the record if it doesn't exist, and deletes it if it does.
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
