<?php

use \App\Http\Controllers\API\Category\CategoryController;
use \App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\Comapny\BookingController;
use App\Http\Controllers\API\Comapny\CompanyController;
use App\Http\Controllers\API\Company\Checkout\CheckoutController;
use App\Http\Controllers\API\Favourite\FavouriteController;
use App\Http\Controllers\API\Notfication\NotficationController;
use App\Http\Controllers\API\Offer\OfferController;
use App\Http\Controllers\API\Payment\CreateLinkPaymentController;
use App\Http\Controllers\API\Region\RegionController;
use App\Http\Controllers\API\Tracking\StaffTrackingController;
use App\Http\Controllers\API\Transaction\TransactionController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;



















Route::get('test22', function () {
    return response()->json(['message' => 'API is working']);
});
Route::prefix('v1/app/auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('create-account', [LoginController::class, 'createAccount']);
    Route::post('update-fcm-token', [LoginController::class, 'updateToken'])->middleware(JwtMiddleware::class);
    Route::post('update-account', [LoginController::class, 'updateAccount'])->middleware(JwtMiddleware::class);
    Route::post('update-password', [LoginController::class, 'updatePassword'])->middleware(JwtMiddleware::class);

    Route::post('logout', [LoginController::class, 'logout'])->middleware(JwtMiddleware::class);
    Route::get('me', [LoginController::class, 'me'])->middleware(JwtMiddleware::class);

    Route::post('/send-otp', [OtpController::class, 'sendOtp']);

    Route::post('/check-otp', [OtpController::class, 'checkOtp']);

    Route::post('/reset-password', [OtpController::class, 'resetPassword']);
});


Route::prefix('v1/app')->name('app.')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'getCompaniesByCategory']);
    Route::get('companies/{id}', [CompanyController::class, 'show']);
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('companies/{id}/available-slots', [CompanyController::class, 'getAvailableSlots']);
    Route::post('booking', [BookingController::class, 'store'])->middleware(JwtMiddleware::class);
    Route::get('booking', [BookingController::class, 'index'])->middleware(JwtMiddleware::class);
    Route::get('booking/{id}', [BookingController::class, 'show'])->middleware(JwtMiddleware::class);

    Route::post('checkout', [CheckoutController::class, 'checkout'])->middleware(JwtMiddleware::class);


    Route::post('create-link-payment', [CreateLinkPaymentController::class, 'createLinkKashier'])->middleware(JwtMiddleware::class);
    Route::get('payment/check-status/{transaction_id}', [CreateLinkPaymentController::class, 'checkStatus']);
    Route::get('offers', [OfferController::class, 'index']);
    Route::get('regions', [RegionController::class, 'index']);
    // for transaction
    Route::get('transaction', [TransactionController::class, 'index'])->middleware(JwtMiddleware::class);

    // tracking
    Route::get('/tracking/{id}', [StaffTrackingController::class, 'show'])->middleware(JwtMiddleware::class);

    Route::prefix('tracking')->group(function () {

        Route::post('/update', [StaffTrackingController::class, 'update']);
    });


    Route::get('/notifications', [NotficationController::class, 'index'])->middleware(JwtMiddleware::class);
    Route::patch('/notifications/{id}/read', [NotficationController::class, 'markAsRead'])->middleware(JwtMiddleware::class);
    Route::post('/notifications/read-all', [NotficationController::class, 'markAllAsRead'])->middleware(JwtMiddleware::class);
    Route::delete('/notifications/{id}', [NotficationController::class, 'destroy'])->middleware(JwtMiddleware::class);
    Route::get('/favourites', [FavouriteController::class, 'index'])->middleware(JwtMiddleware::class);
    Route::post('/favourites/toggle', [FavouriteController::class, 'toggle'])->middleware(JwtMiddleware::class);
});

// 


require __DIR__ . '/admin.php';
require __DIR__ . '/company.php';
