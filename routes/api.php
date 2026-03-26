<?php

use \App\Http\Controllers\API\Category\CategoryController;
use \App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\Comapny\BookingController;
use App\Http\Controllers\Api\Offer\OfferController;
use App\Http\Controllers\Api\Payment\createLinkPaymentController;
use App\Http\Controllers\Api\Region\regionController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Comapny\CompanyController;













Route::get('test22', function () {
    return response()->json(['message' => 'API is working']);
});
Route::prefix('v1/app/auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->middleware(JwtMiddleware::class);
    Route::get('me', [LoginController::class, 'me'])->middleware(JwtMiddleware::class);
});
// 

Route::prefix('v1/app')->name('app.')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'getCompaniesByCategory']);
    Route::get('companies/{id}', [CompanyController::class, 'show']);
    Route::get('companies/{id}/available-slots', [CompanyController::class, 'getAvailableSlots']);
    Route::post('booking', [BookingController::class, 'store'])->middleware(JwtMiddleware::class);
    Route::get('booking', [BookingController::class, 'index'])->middleware(JwtMiddleware::class);
    Route::post('create-link-payment', [createLinkPaymentController::class, 'createLinkKashier'])->middleware(JwtMiddleware::class);
    Route::get('payment/check-status/{transaction_id}', [CreateLinkPaymentController::class, 'checkStatus']);
    Route::get('offers', [OfferController::class, 'index']);
    Route::get('regions', [regionController::class, 'index']);
});



require __DIR__ . '/admin.php';
