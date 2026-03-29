<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Payment\AmountRequest;
use App\Http\Services\Payment\CreateLinkKashierPaymentService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateLinkPaymentController extends Controller
{
    use ApiResponseTrait;
    public function __construct(public CreateLinkKashierPaymentService $createLinkRepo) {}

    public function createLinkKashier(AmountRequest $request)
    {
        $data = [
            'user_id' =>  $request->user_id,
            'amount'  => $request->amount,
            'email'   => $request->email,
        ];

        try {
            $paymentLink = $this->createLinkRepo->createSession($data);
            return $this->successResponse([
                'payment_url' => $paymentLink
            ], 'Payment link generated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    public function success(Request $request)
    {
        $data = $request->all();
        $transactionId = $data['merchantOrderId'] ?? null;

        if ($data['paymentStatus'] == "FAILED") {
            return null;
        }

        if ($transactionId) {
            $this->createLinkRepo->updateTransaction($transactionId, $data['paymentStatus']);
        }
    }

    public function failure(Request $request)
    {
        Log::info("sss", [$request]);

        $data = $request->all();
        Log::info('Kashier Payment Failure Redirect:', $data);
        return redirect()->away(
            'http://darab.academy/'
        );
        return response()->json([
            'message' => 'Payment Failed (Redirect)',
            'data' => $data
        ]);
    }

    public function checkStatus($transaction_id)
    {
        try {
            $statusData = $this->createLinkRepo->getTransactionStatus($transaction_id);
            return $this->successResponse($statusData, 'success Payment');
        } catch (\Exception $e) {
            return $this->errorResponse('Payment Failed',);
        }
    }
}
