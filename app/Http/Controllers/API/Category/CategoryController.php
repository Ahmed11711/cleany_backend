<?php

namespace App\Http\Controllers\API\Category;

use \App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Http\Resources\Api\Company\ApiCompanyResource;
use App\Models\Company;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @tags Mobile App
     */
    use ApiResponseTrait;
    public function index()
    {
        $categories = Category::get();
        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully');
    }
    public function getCompaniesByCategory(Request $request, $categoryId)
    {
        $regionId = $request->query('region_id');

        $companies = Company::whereHas('categories', function ($query) use ($categoryId, $regionId) {
            $query->where('categories.id', $categoryId);

            if ($regionId) {
                $query->where('category_company.region_id', $regionId);
            } else {
                $query->whereNull('category_company.region_id');
            }
        })
            ->with(['services', 'specialties', 'categories' => function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            }])
            ->get();

        return $this->successResponse(
            ApiCompanyResource::collection($companies),
            'Companies retrieved successfully'
        );
    }
}
