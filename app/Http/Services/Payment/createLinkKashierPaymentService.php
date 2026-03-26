<?php

namespace App\Http\Services\Payment;

use App\Models\User;
use App\Repositories\Package\PackageRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\UserPackage\UserPackageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class CreateLinkKashierPaymentService
{
    public function __construct(
        private KashierPaymentService $kashierPaymentService,
        public TransactionRepositoryInterface $transactionRepo,

    ) {}


    public function createSession(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = $this->resolveUser($data);



            $transactionId = (string) Str::uuid();

            $contact = $user->email ?? $user->phone;

            $paymentLink = $this->kashierPaymentService->createSession(
                amount: $user->amount,
                customerContact: $contact,
                transactionId: $transactionId,
            );

            if (!$paymentLink) {
                throw new RuntimeException('Failed to create payment session.');
            }

            $this->transactionRepo->create([
                'user_id'        => $user->id,
                'transaction_id' => $transactionId,
                'amount'          => $user->amount,
                'status'         => 'pending',
                'type'           => 'deposit',
                'payment_method' => 'credit'
            ]);

            return [
                'payment_url'    => $paymentLink,
                'transaction_id' => $transactionId
            ];
        });
    }

    private function resolveUser(array $data)
    {
        $user = User::findOrFail($data['user_id']);

        $user->amount = $data['amount'];

        return $user;
    }
    public function updateTransaction(string $transactionId, string $status): void
    {
        $transaction = $this->transactionRepo->findByKey('transaction_id', $transactionId);

        if (!$transaction) {
            throw new \RuntimeException('Transaction not found: ' . $transactionId);
        }

        if ($transaction->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($transaction, $status) {
            if (strtoupper($status) === 'SUCCESS') {
                // 1. تحديث حالة العملية
                $transaction->update(['status' => 'success']);

                // 2. جلب المستخدم والتأكد من وجود محفظة (أو إنشائها)
                $user = User::find($transaction->user_id);

                if ($user) {
                    // استخدام firstOrCreate عشان لو ملوش محفظة نكريتها فوراً برصيد 0
                    $wallet = $user->wallet()->firstOrCreate(
                        ['user_id' => $user->id],
                        ['balance' => 0]
                    );

                    // 3. زيادة الرصيد
                    $wallet->increment('balance', $transaction->amount);

                    Log::info("Wallet updated/created for user: {$user->id}, Amount: {$transaction->amount}");
                } else {
                    throw new \RuntimeException('User not found during transaction update.');
                }
            } else {
                $transaction->update(['status' => 'failed']);
            }
        });
    }
    public function getTransactionStatus(string $transactionId): array
    {
        $transaction = $this->transactionRepo->findByKey('transaction_id', $transactionId);

        if (!$transaction) {
            throw new \RuntimeException('Transaction not found.');
        }

        $user = User::with('wallet')->find($transaction->user_id);

        return [
            'status'         => $transaction->status, // pending, success, failed
            'amount'         => $transaction->amount,
            'current_balance' => $user->wallet ? $user->wallet->balance : 0,
            'payment_method' => $transaction->payment_method,
        ];
    }
}
