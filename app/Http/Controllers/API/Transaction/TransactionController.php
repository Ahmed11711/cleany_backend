<?php

namespace App\Http\Controllers\API\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Transaction\AllTransactionResource;
use App\Models\booking;
use App\Models\Transaction;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $userId = $request->user_id;

        $transactions = booking::with('service')
            ->where('user_id', $userId)
            ->get();

        $data = AllTransactionResource::collection($transactions);

        return $this->successResponse($data, "My Transaction List");
    }
}
