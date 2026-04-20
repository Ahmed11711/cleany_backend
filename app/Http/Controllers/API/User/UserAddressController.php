<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddres;
use App\Traits\ApiResponseTrait; // استخدم الـ Trait اللي عندك
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $addresses = UserAddres::where('user_id', auth('api')->id())->get();
        return $this->successResponse($addresses, 'Addresses retrieved successfully', 200);
    }

    // تخزين عنوان جديد
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string',
            'address'      => 'required|string',
            'city'         => 'required|string',
            'country'      => 'required|string',
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            'state'        => 'nullable|string',
            'postal_code'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse("eroor", $validator->errors()->first(), 422);
        }

        $address = UserAddres::create([
            'user_id'     => auth('api')->id(),
            'name'        => $request->name,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'city'        => $request->city,
            'country'     => $request->country,
            'state'       => $request->state,
            'postal_code' => $request->postal_code,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
        ]);

        return $this->successResponse($address, 'Address stored successfully', 201);
    }
}
