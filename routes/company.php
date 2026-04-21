<?php

use App\Http\Controllers\API\Comapny\Offers\OfferController;
use App\Http\Controllers\API\Company\DashboardCompanyController;
use App\Http\Controllers\API\Company\Staff\DashboardStaffController;
use App\Http\Controllers\Api\Tracking\StaffTrackingController;
use App\Http\Controllers\Company\Auth\AuthController;
use App\Http\Controllers\Company\Availability\AvailabilityController;
use App\Http\Controllers\Company\Booking\BookingController;
use App\Http\Controllers\Company\Dashboard\MyCompnayController;
use App\Http\Controllers\Company\Service\ServiceController;
use App\Http\Controllers\Company\Specialy\SpecialtyController;
use App\Http\Controllers\Company\Specialy\SpecialtysController;
use App\Http\Controllers\Company\Staff\StaffController;
use App\Http\Middleware\CheckIsCompany;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;











Route::prefix('v1/company/')->middleware(CheckIsCompany::class)->group(function () {
    // login


    Route::get('my-company', [MyCompnayController::class, 'index'])->name('company.my.index');
    Route::post('my-company', [MyCompnayController::class, 'store']); // للإنشاء
    Route::match(['post', 'put'], 'my-company', [MyCompnayController::class, 'update']);
    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::post('/', [ServiceController::class, 'store']);

        Route::get('items/{id}', [ServiceController::class, 'getServiceItems']);
        Route::post('items', [ServiceController::class, 'storeOrUpdate']);

        Route::put('/{id}', [ServiceController::class, 'update']);
        Route::delete('/{id}', [ServiceController::class, 'destroy']);
    });
    Route::apiResource('specialtiesComapny', SpecialtysController::class);
    Route::get('bookings', [BookingController::class, 'index']);
    Route::Put('/bookings/{id}/status', [BookingController::class, 'updateStatus']);
    Route::get('availability', [AvailabilityController::class, 'index']);
    Route::post('availability/sync/{serviceId}', [AvailabilityController::class, 'sync']);
    Route::resource('staff', StaffController::class);
    Route::get('/admin/stats', [DashboardCompanyController::class, 'index']);
    Route::get('/bookings/recent', [DashboardCompanyController::class, 'recentBookings']);
    Route::resource('offers', OfferController::class);
    Route::get('categories', [OfferController::class, 'categories']);
    Route::patch('offers/{id}/toggle', [OfferController::class, 'toggleStatus']);

    Route::prefix('staff/Dashbaord')->group(function () {
        Route::get('/bookings', [DashboardStaffController::class, 'getMyBookings']);

        // تحديث الحالة (on_the_way, in_progress)
        Route::patch('/bookings/{id}/status', [DashboardStaffController::class, 'updateStatus']);

        // إنهاء الطلب ورفع التقرير والصور
        Route::post('/bookings/{id}/complete', [DashboardStaffController::class, 'completeBooking']);

        // تحديث الموقع الجغرافي (GPS)
        Route::post('/update-location', [DashboardStaffController::class, 'updateLocation']);
    });


    Route::prefix('tracking')->group(function () {

        Route::post('/update', [StaffTrackingController::class, 'update']);

        Route::get('/staff/{id}', [StaffTrackingController::class, 'show']);
    });
});

Route::prefix('v1/company/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(CheckIsCompany::class);
    Route::get('me', [AuthController::class, 'me'])->middleware(CheckIsCompany::class);
});
