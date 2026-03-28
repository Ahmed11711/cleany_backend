<?php

use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Company\CompanyController;
use App\Http\Controllers\Admin\Region\RegionController;
use App\Http\Controllers\Admin\Specialty\SpecialtyController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Company\Dashboard\MyCompnayController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\booking\bookingController;
use App\Http\Controllers\Admin\Offer\OfferController;
use App\Http\Controllers\Admin\Transaction\TransactionController;
use App\Http\Controllers\Admin\CategoryCompany\CategoryCompanyController;



Route::prefix('v1/admin')->group(function () {
    Route::apiResource('users', UserController::class)->names('user');
    Route::apiResource('categories', CategoryController::class)->names('category');
    Route::apiResource('regions', RegionController::class)->names('region');


    Route::apiResource('companies', CompanyController::class)->names('company');
    Route::apiResource('specialties', SpecialtyController::class)->names('specialty');
    Route::apiResource('category_companies', CategoryCompanyController::class)->names('category_company');
    Route::apiResource('offers', OfferController::class)->names('offer');
    Route::apiResource('transactions', TransactionController::class)->names('transaction');
    Route::apiResource('bookings', bookingController::class)->names('booking');
});



Route::prefix('v1')->group(function () {
    // Route::apiResource('transactions', TransactionController::class)->names('transaction');
    // Route::apiResource('offers', OfferController::class)->names('offer');
});
