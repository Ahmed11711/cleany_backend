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
    public function index(Request $request)
    {
        $categories = Category::query()

            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->get();

        return $this->successResponse(
            CategoryResource::collection($categories),
            'Categories retrieved successfully'
        );
    }
    public function getCompaniesByCategory(Request $request, $categoryId)
    {
        $regionId = $request->query('region_id');
        $search = $request->query('search'); // استلام كلمة البحث

        $companies = Company::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            // 2. الفلترة بالقسم والمنطقة
            ->whereHas('categories', function ($query) use ($categoryId, $regionId) {
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
