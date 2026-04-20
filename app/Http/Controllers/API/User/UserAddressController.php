<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddressResource;
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

    public function store(AddressResource $request)
    {
        $validator = $request->validated();



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
