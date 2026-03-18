<?php

use \App\Http\Controllers\API\Category\CategoryController;
use \App\Http\Controllers\Api\Comapny\CompanyController;
use \App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;







Route::get('test2', function () {
    return response()->json(['message' => 'API is working']);
});
Route::prefix('v1/auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('me', [LoginController::class, 'me'])->middleware(JwtMiddleware::class);
});

Route::prefix('v1')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}/companies', [CategoryController::class, 'getCompaniesByCategory']);
    Route::get('companies/{id}', [CompanyController::class, 'show']);
});




require __DIR__ . '/admin.php';
