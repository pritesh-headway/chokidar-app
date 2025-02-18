<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\backend\ContactUsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SuperAdminController;
use App\Http\Controllers\Backend\AllSocietyController;
use App\Http\Controllers\backend\HouseController;
use App\Http\Middleware\WebMiddleware;

Route::get("/", function () {
    return view("login");
})->name("backend.login");

Route::get('logout', [SuperAdminController::class, 'logout'])->name('backend.logout');
Route::get('/societyregister', function () {
    return view('societyregister');
})->name('societyregister');

Route::post('/login', [SuperAdminController::class, 'login'])->name('auth.login');

// Route::group(['middleware' => ['web'], 'prefix' => 'admin'], function () {
//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// });



Route::middleware([WebMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::middleware([WebMiddleware::class])->group(function () {
    Route::get('/admin/societies', [AllSocietyController::class, 'index'])->name('societies.index');
    Route::get('/admin/societies/{id}', [AllSocietyController::class, 'show'])->name('societies.show');
    Route::get('/admin/societies/{id}/edit', [AllSocietyController::class, 'edit'])->name('societies.edit');
    Route::post('/admin/societies/{id}/update', [AllSocietyController::class, 'update'])->name('societies.update');
    Route::delete('/admin/societies/{id}', [AllSocietyController::class, 'destroy'])->name('societies.destroy');


    Route::resource('contactus', App\Http\Controllers\backend\ContactUsController::class)->names([
        'index' => 'contactus.index',
        'create' => 'contactus.create',
        'store' => 'contactus.store',
        'show' => 'contactus.show',
        'edit' => 'contactus.edit',
        'update' => 'contactus.update',
        'destroy' => 'contactus.destroy',
    ]);

    Route::resource('houses', HouseController::class)->names([
        'index' => 'houses.index',
        'create' => 'houses.create',
        'store' => 'houses.store',
        'show' => 'houses.show',
        'edit' => 'houses.edit',
        'update' => 'houses.update',
        'destroy' => 'houses.destroy',
    ]);

    // Route::post('/admin/societies/create', [AllSocietyController::class, 'create'])->name('societies.create');
    // Route::post('/admin/societies', [AllSocietyController::class, 'store'])->name('societies.store');
});
