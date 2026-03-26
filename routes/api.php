<?php

use \App\Http\Controllers\API\Category\CategoryController;
use \App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\Comapny\BookingController;
use App\Http\Controllers\API\Comapny\CompanyController;
use App\Http\Controllers\API\Offer\OfferController;
use App\Http\Controllers\API\Payment\createLinkPaymentController;
use App\Http\Controllers\API\Region\RegionController;
use App\Http\Controllers\API\Transaction\TransactionController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;














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
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('companies/{id}/available-slots', [CompanyController::class, 'getAvailableSlots']);
    Route::post('booking', [BookingController::class, 'store'])->middleware(JwtMiddleware::class);
    Route::get('booking', [BookingController::class, 'index'])->middleware(JwtMiddleware::class);
    Route::get('booking/{id}', [BookingController::class, 'show'])->middleware(JwtMiddleware::class);
    Route::post('create-link-payment', [createLinkPaymentController::class, 'createLinkKashier'])->middleware(JwtMiddleware::class);
    Route::get('payment/check-status/{transaction_id}', [CreateLinkPaymentController::class, 'checkStatus']);
    Route::get('offers', [OfferController::class, 'index']);
    Route::get('regions', [RegionController::class, 'index']);
    // for transaction
    Route::get('transaction', [TransactionController::class, 'index'])->middleware(JwtMiddleware::class);
});

// 


require __DIR__ . '/admin.php';
