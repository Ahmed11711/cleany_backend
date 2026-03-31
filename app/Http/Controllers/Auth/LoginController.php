<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccount\CreateAccountRequest;
use App\Http\Requests\Auth\CreateAccount\UpdateAccountRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function updatePassword(UpdatePasswordRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = auth('api')->user();

        // 1. Verify if the current password matches the database record
        if (!Hash::check($request->old_password, $user->password)) {
            return $this->errorResponse('The current password you entered is incorrect.', 400);
        }

        // 2. Update and encrypt the new password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return $this->successResponse(null, 'Password updated successfully.');
    }

    public function updateToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);
        $user = Auth::guard('api')->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();


        // تحديث التوكن للمستخدم المسجل

        return response()->json(['message' => 'Token updated successfully']);
    }
}
