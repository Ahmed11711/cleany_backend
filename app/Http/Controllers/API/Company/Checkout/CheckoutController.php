<?php

namespace App\Http\Controllers\API\Company\Checkout;

use \App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Checkout\CheckoutRequest;
use App\Http\Services\Payment\CheckoutBookingService;
use App\Models\booking;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        if ($booking->payment_status === 'paid') {
            return $this->errorResponse('This booking has already been paid.', 400);
        }
        if (!$user->wallet || $user->wallet->balance < $booking->total_price) {
            return $this->errorResponse('Insufficient wallet balance.', 400);
        }

        try {
            DB::transaction(function () use ($user, $booking) {

                $user->wallet->decrement('balance', $booking->total_price);
                $transactionId = (string) Str::uuid();
                Transaction::create([
                    'user_id'        => $user->id,
                    'order_id'       => $booking->id,
                    'amount'         => $booking->total_price,
                    'type'           => 'payment',
                    'payment_method' => 'wallet',
                    'status'         => 'success',
                    'notes'          => 'Payment for booking #' . $booking->id,
                    'transaction_id'  => $transactionId,
                ]);

                $booking->update([
                    'payment_method' => 'wallet',
                    'payment_status' => 'paid',
                    'status'         => 'confirmed'
                ]);
            });

            return $this->successResponse($booking, 'Paid successfully from wallet and transaction recorded.');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong during payment: ' . $e->getMessage(), 500);
        }
    }

    private function payViaCash($booking)
    {
        $booking->update([
            'payment_method' => 'cash_on_hand',
            'payment_status' => 'unpaid',
            'status'         => 'confirmed'
        ]);

        return $this->successResponse($booking, 'Booking confirmed with Cash on Hand.');
    }

    private function payViaOnline($booking)
    {
        $createLink = new CheckoutBookingService();
        $paymentLink = $createLink->createSession($booking->total_price, $booking->user->email, $booking->transaction_id,);

        $booking->update([
            'payment_method' => 'payment',
            'payment_status' => 'unpaid',
            'status'         => 'pending'
        ]);

        return $this->successResponse([
            'booking_id'   => $booking->id,
            'payment_url'  => $paymentLink
        ], 'Redirect to payment gateway.');
    }

    public function handleSuccess(Request $request)
    {
        $transactionId = $request->query('transaction_id');

        if (!$transactionId) {
            return $this->errorResponse('Transaction ID missing', 400);
        }

        $booking = Booking::where('transaction_id', $transactionId)->first();

        if (!$booking) {
            return $this->errorResponse('Booking not found', 404);
        }

        $status = $request->query('paymentStatus'); // كاشير بيبعت الحالة تلقائياً

        if ($status === 'SUCCESS') {
            $booking->update(['payment_status' => 'paid', 'status' => 'confirmed']);

            return $this->successResponse($booking, 'Payment verified successfully');
        }

        return $this->errorResponse('Payment was not successful', 400);
    }
}
