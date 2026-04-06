<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\checkOtpRequest;
use App\Http\Requests\Auth\ForgetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class OtpController extends Controller
{
    // 1. إرسال الرمز
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);

        // استخدام Cache::put لضمان الوضوح
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10)); // رفعتها لـ 10 دقائق منطقية أكثر

        // Mail::to($request->email)->send(new OtpMail($otp));

        return response()->json(['status' => true, 'message' => 'تم إرسال الرمز بنجاح.']);
    }

    // 2. التحقق من الرمز (بدون تغيير كلمة المرور بعد)
    public function checkOtp(checkOtpRequest $request)
    {


        $cachedOtp = Cache::get('otp_' . $request->email);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            return response()->json([
                'status' => true,
                'message' => 'الرمز صحيح، يمكنك المتابعة.'
            ]);
        }

        return response()->json(['status' => false, 'message' => 'الرمز غير صحيح أو منتهي الصلاحية.'], 422);
    }

    // 3. إعادة تعيين كلمة المرور
    public function resetPassword(ForgetPassword $request)
    {
        // الـ Validation يتم تلقائياً عبر الـ Form Request (ForgetPassword)

        $cachedOtp = Cache::get('otp_' . $request->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['status' => false, 'message' => 'الرمز غير صالح، اطلب رمزاً جديداً.'], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password) // استخدام Hash::make أفضل من bcrypt
        ]);

        Cache::forget('otp_' . $request->email);

        return response()->json(['status' => true, 'message' => 'تم تحديث كلمة المرور بنجاح.']);
    }
}
