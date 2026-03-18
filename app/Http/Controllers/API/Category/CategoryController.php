<?php

namespace App\Http\Controllers\API\Category;

use \App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $categories = Category::get();
        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully');
    }
}
