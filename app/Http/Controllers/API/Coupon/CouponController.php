<?php

namespace App\Http\Controllers\Api\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // $coupon = Coupon::where('code', $request->code)
        //     ->where('is_active', 1)
        //     ->where(function ($q) {
        //         $q->whereNull('expires_at')
        //             ->orWhere('expires_at', '>', now());
        //     })
        //     ->first();

        // if (!$coupon) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'الكوبون غير صالح أو منتهي الصلاحية',
        //     ], 404);
        // }

        return response()->json([
            'success' => true,
            'data' => [
                'code'       => $request->code,
                'discount'   => 10,
                // 'expires_at' => $coupon->expires_at,
            ],
        ]);
    }
}
