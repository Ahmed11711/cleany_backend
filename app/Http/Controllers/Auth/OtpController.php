<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\checkOtpRequest;
use App\Http\Requests\Auth\ForgetPassword;
use App\Http\Requests\SenOtpRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpController extends Controller
{
    use ApiResponseTrait;

    // 1. Send OTP
    public function sendOtp(SenOtpRequest $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);

        // Store OTP in cache for 10 minutes
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10));

        Mail::to($request->email)->send(new OtpMail($otp));


        return response()->json([
            'status'  => true,
            'message' => 'OTP sent successfully.',
            'code'    => $otp // Visible for testing purposes
        ], 200);
    }

    // 2. Check OTP
    public function checkOtp(checkOtpRequest $request)
    {
        $cachedOtp = Cache::get('otp_' . $request->email);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            return response()->json([
                'status'  => true,
                'message' => 'OTP is valid, you can proceed.'
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Invalid or expired OTP.'
        ], 422);
    }

    // 3. Reset Password
    public function resetPassword(ForgetPassword $request)
    {
        $cachedOtp = Cache::get('otp_' . $request->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid OTP, please request a new one.'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Clear cache after successful reset
        Cache::forget('otp_' . $request->email);

        return response()->json([
            'status'  => true,
            'message' => 'Password updated successfully.'
        ], 200);
    }
}
