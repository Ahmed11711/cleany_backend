<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccount\CreateAccountRequest;
use App\Http\Requests\Auth\CreateAccount\UpdateAccountRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponseTrait, UploadImageTrait;
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

    public function createAccount(CreateAccountRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($request->password);



        $data['profile_photo'] = $this->uploadManager($request, $data, 'Users', ['profile_photo']);
        $data['role'] = 'user';


        $user = User::create($data);

        if (method_exists($user, 'wallet')) {
            $user->wallet()->create(['balance' => 0]);
        }

        return $this->successResponse([
            'user' => $user,
        ], 'Account created successfully');
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $user = auth('api')->user();

        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $data['profile_photo'] = $this->uploadManager(
            $request,
            $data,
            'Users',
            ['profile_photo'],
        );

        $user->update($data);

        $user->loadMissing('wallet');
        $user->balance = $user->wallet ? $user->wallet->balance : 0;

        return $this->successResponse($user, 'Account updated successfully');
    }
}
