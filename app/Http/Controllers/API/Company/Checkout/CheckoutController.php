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

        $firstBooking = Booking::findOrFail($request->booking_id);

        if ($firstBooking->payment_status === 'paid') {
            return $this->errorResponse('This booking is already paid.', 400);
        }

        $bookings = Booking::with('user.wallet')
            ->where('transaction_id', $firstBooking->transaction_id)
            ->get();

        $totalPrice = $bookings->sum('total_price');
        $user = $firstBooking->user;

        switch ($request->payment_method) {
            case 'wallet':
                return $this->payViaWallet($bookings, $user, $totalPrice);
            case 'payment':
                return $this->payViaOnline($bookings, $totalPrice, $user);
            case 'cash_on_hand':
                return $this->payViaCash($bookings);
        }
    }

    private function payViaWallet($bookings, $user, $totalPrice)
    {
        if (!$user->wallet || $user->wallet->balance < $totalPrice) {
            return $this->errorResponse('Insufficient wallet balance.', 400);
        }

        try {
            DB::transaction(function () use ($user, $bookings, $totalPrice) {
                $user->wallet->decrement('balance', $totalPrice);

                $transactionId = (string) Str::uuid();

                foreach ($bookings as $booking) {
                    Transaction::create([
                        'user_id'        => $user->id,
                        'order_id'       => $booking->id,
                        'amount'         => $booking->total_price,
                        'type'           => 'payment',
                        'payment_method' => 'wallet',
                        'status'         => 'success',
                        'notes'          => 'Payment for booking #' . $booking->id,
                        'transaction_id' => $transactionId,
                    ]);

                    $booking->update([
                        'payment_method' => 'wallet',
                        'payment_status' => 'paid',
                        'status'         => 'pending',
                    ]);
                }
            });

            return $this->successResponse($bookings, 'Paid successfully from wallet.');
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    private function payViaCash($bookings)
    {
        foreach ($bookings as $booking) {
            $booking->update([
                'payment_method' => 'cash_on_hand',
                'payment_status' => 'unpaid',
                'status'         => 'confirmed',
            ]);
        }

        return $this->successResponse($bookings, 'Booking confirmed with Cash on Hand.');
    }

    private function payViaOnline($bookings, $totalPrice, $user)
    {
        $firstBooking = $bookings->first();

        $createLink = new CheckoutBookingService();
        $paymentLink = $createLink->createSession(
            $totalPrice,
            $user->email,
            $firstBooking->transaction_id,
        );

        foreach ($bookings as $booking) {
            $booking->update([
                'payment_method' => 'payment',
                'payment_status' => 'unpaid',
                'status'         => 'pending',
            ]);
        }

        return $this->successResponse([
            'booking_id'  => $firstBooking->id,
            'payment_url' => $paymentLink,
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
