<?php

use App\Http\Controllers\API\Company\Checkout\CheckoutController;
use App\Http\Controllers\API\Payment\CreateLinkPaymentController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/kashier/success', [CreateLinkPaymentController::class, 'success'])->name('kashier.success');
Route::get('/kashier/failure', [CreateLinkPaymentController::class, 'failure'])->name('kashier.failure');
Route::post('/kashier/webhook', [CreateLinkPaymentController::class, 'handle'])->name('kashier.webhook');


Route::get('kashier/success/checkout', [CheckoutController::class, 'handleSuccess']);
