<?php

namespace App\Http\Controllers\API\Comapny\Offers;

use \App\Models\CategoryCompany;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Traits\ApiResponseTrait;
use App\Traits\UploadImageTrait; // استدعاء التريت الخاص بك
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    use ApiResponseTrait, UploadImageTrait;


    public function index(Request $request)
    {
        $companyId = $request->company_id;

        $offers = Offer::where('company_id', $companyId)
            ->with('category:id,name')
            ->latest()
            ->get();

        return $this->successResponse($offers, "List Of Offers");
    }

    /**
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'        => 'required|string|max:255',
            'title_ar'        => 'nullable|string|max:255',
            'description'  => 'required|string',
            'description_ar'  => 'required|string',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        // 1. بدلاً من $request->all()، حدد فقط الحقول الموجودة في قاعدة البيانات
        $data = [
            'title'       => $request->title,
            'title_ar'       => $request->title_ar,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'category_id' => $request->category_id,
            'company_id'  => $request->company_id,
            'is_active'   => false, // أو true حسب رغبتك
        ];

        $data['image_path'] = $this->uploadManager($request, $data, 'Offers', ['image']);

        $offer = Offer::create($data);

        return $this->successResponse($offer->load('category'), "Offer Created Successfully", 201);
    }

    /**
     * تحديث حالة العرض (Active/Inactive)
     */
    public function toggleStatus(Request $request, $id)
    {

        $offer = Offer::where('company_id', $request->company_id)->findOrFail($id);
        $offer->update(['is_active' => 0]);

        return $this->successResponse($offer, "Offer status updated");
    }

    /**
     */
    public function destroy(Request $request, $id)
    {
        $offer = Offer::where('company_id', $request->company_id)->findOrFail($id);

        if (!empty($offer->image_path)) {
            $oldRelativePath = last(explode('/media/', $offer->image_path));
            $fullOldPath = public_path('media/' . $oldRelativePath);
            if (file_exists($fullOldPath)) {
                unlink($fullOldPath);
            }
        }

        $offer->delete();

        return $this->successResponse(null, "Offer Deleted Successfully");
    }

    /**
     */
    public function categories(Request $request)
    {
        $companyId = $request->company_id;

        $categoryIds = CategoryCompany::where('company_id', $companyId)
            ->pluck('category_id'); // تجلب مصفوفة تحتوي على [1, 2, 5] مثلاً

        $categories = Category::whereIn('id', $categoryIds)
            ->select('id', 'name')
            ->get();

        return $this->successResponse($categories, "Categories retrieved for company " . $companyId);
    }
}
