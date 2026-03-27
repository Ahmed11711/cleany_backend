<?php

use App\Http\Controllers\API\Company\Checkout\CheckoutController;
use App\Http\Controllers\Api\Payment\createLinkPaymentController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/kashier/success', [createLinkPaymentController::class, 'success'])->name('kashier.success');
Route::get('/kashier/failure', [createLinkPaymentController::class, 'failure'])->name('kashier.failure');
Route::post('/kashier/webhook', [createLinkPaymentController::class, 'handle'])->name('kashier.webhook');


Route::get('kashier/success/checkout', [CheckoutController::class, 'handleSuccess']);
