<?php

use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Company\CompanyController;
use App\Http\Controllers\Admin\Region\RegionController;
use App\Http\Controllers\Admin\Specialty\SpecialtyController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Company\Dashboard\MyCompnayController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryCompany\CategoryCompanyController;



Route::prefix('v1/admin')->group(function () {
    Route::apiResource('users', UserController::class)->names('user');
    Route::apiResource('categories', CategoryController::class)->names('category');
    Route::apiResource('regions', RegionController::class)->names('region');


    Route::apiResource('companies', CompanyController::class)->names('company');
    Route::apiResource('specialties', SpecialtyController::class)->names('specialty');
    Route::apiResource('category_companies', CategoryCompanyController::class)->names('category_company');
});

Route::prefix('v1/company')->middleware(JwtMiddleware::class)->group(function () {
    Route::get('my-company', [MyCompnayController::class, 'index'])->name('company.my.index');
    Route::post('my-company', [MyCompnayController::class, 'store'])->name('company.my.store');
    Route::put('my-company', [MyCompnayController::class, 'update'])->name('company.my.update');
});
