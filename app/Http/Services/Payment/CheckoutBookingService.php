<?php

namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutBookingService
{


    public function createSession(
        string $amount,
        string $customerContact,
        string $transactionId,
    ): ?string {

        $queryParam = $customerContact;

        $payload = [
            'expireAt'           => now()->addMinutes(30)->toISOString(),
            'maxFailureAttempts' => 3,
            'amount'             => $amount,
            'currency'           => 'EGP',
            'order'              => $transactionId,
            'merchantId'         => 'MID-41016-213',
            'merchantRedirect' => config('app.url') . '/kashier/success/checkout?transaction_id=' . $transactionId,
            'failureRedirect'    => true,
            'serverWebhook'      => config('app.url') . '/kashier/webhook',
            'allowedMethods'     => 'card,wallet',
            'interactionSource'  => 'ECOMMERCE',
            'enable3DS'          => true,
            'customer' => [
                'email'     => $customerContact,
                'reference' => 'CUST-' . \Illuminate\Support\Str::uuid(),
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'df974d751303a6d76a5637d19ca9a0f7$2c9243f4284be65f2055d390c1185f2fac0619b8c7a4ffee04af37e48051409836beda2dd93ebb72988ef55ad0d8e4ea',
                'api-key'       => '9f78bd9d-fd4e-45fd-a7a6-93e3998b8712',
                'Content-Type'  => 'application/json',
            ])->post('https://test-api.kashier.io/v3/payment/sessions', $payload);

            if ($response->successful()) {
                $sessionUrl = $response->json('sessionUrl');

                if ($sessionUrl) {
                    Log::info('Kashier session created', ['url' => $sessionUrl]);
                    return $sessionUrl;
                }

                Log::error('Kashier sessionUrl missing in JSON');
            } else {
                Log::error('Kashier API failed', ['body' => $response->body()]);
            }

            return null;
        } catch (\Throwable $e) {
            Log::error('Kashier exception', ['msg' => $e->getMessage()]);

            return null;
        }
    }
}
