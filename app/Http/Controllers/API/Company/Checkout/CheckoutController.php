<?php

namespace App\Http\Controllers\API\Company\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Checkout\CheckoutRequest;
use App\Models\booking;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    use ApiResponseTrait;
    public function checkout(CheckoutRequest $request)
    {
        $data = $request->validated();

        $booking = booking::with('user.wallet')->findOrFail($request->booking_id);

        if ($booking->payment_status === 'paid') {
            return $this->errorResponse('This booking is already paid.', 400);
        }

        switch ($request->payment_method) {
            case 'wallet':
                return $this->payViaWallet($booking);

            case 'payment':
                return $this->payViaOnline($booking);

            case 'cash_on_hand':
                return $this->payViaCash($booking);
        }
    }
    private function payViaWallet($booking)
    {
        $user = $booking->user;

        if (!$user->wallet || $user->wallet->balance < $booking->total_price) {
            return $this->errorResponse('Insufficient wallet balance.', 400);
        }

        DB::transaction(function () use ($user, $booking) {
            $user->wallet->decrement('balance', $booking->total_price);

            $booking->update([
                'payment_method' => 'wallet',
                'payment_status' => 'paid',
                'status'         => 'confirmed'
            ]);
        });

        return $this->successResponse($booking, 'Paid successfully from wallet.');
    }

    private function payViaCash($booking)
    {
        $booking->update([
            'payment_method' => 'cash_on_hand',
            'payment_status' => 'unpaid', // سيتم الدفع يدوياً لاحقاً
            'status'         => 'confirmed'
        ]);

        return $this->successResponse($booking, 'Booking confirmed with Cash on Hand.');
    }

    private function payViaOnline($booking)
    {
        // هنا تضع كود بوابة الدفع (Stripe/MyFatoorah)
        // كمثال: سنفترض أننا سنقوم بإنشاء Payment Link
        $paymentLink = "https://checkout.test/pay/" . $booking->id;

        return $this->successResponse([
            'booking_id'   => $booking->id,
            'payment_url'  => $paymentLink
        ], 'Redirect to payment gateway.');
    }
}
