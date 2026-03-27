<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponseTrait;
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $user = Auth::guard('api')->user();

        $user->loadMissing('wallet');

        $user->balance = $user->wallet ? $user->wallet->balance : 0;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->successResponse('Successfully logged out');
    }
    public function me()
    {
        $user = Auth::guard('api')->user();

        $user->loadMissing('wallet');

        $user->balance = $user->wallet ? $user->wallet->balance : 0;

        return $this->successResponse($user);
    }
}
