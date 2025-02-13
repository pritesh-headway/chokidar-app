<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocietySubscriptionController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\backend\ContactUsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SuperAdminController;
use App\Http\Controllers\Backend\AllSocietyController;
use App\Http\Controllers\backend\HouseController;
use App\Http\Controllers\backend\SubscriptionPlanController;
use App\Http\Controllers\backend\PaymentController;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\WebMiddleware;

Route::get("/", function () {
    return view("login");
})->name("backend.login");

Route::get('logout', [SuperAdminController::class, 'logout'])->name('backend.logout');
Route::get('/societyregister', function () {
    return view('societyregister');
})->name('societyregister');

Route::post('/login', [SuperAdminController::class, 'login'])->name('auth.login');
Route::middleware([SuperAdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::middleware([SuperAdminMiddleware::class])->group(function () {
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

    Route::resource('houses', App\Http\Controllers\backend\HouseController::class)->names([
        'index' => 'houses.index',
        'create' => 'houses.create',
        'store' => 'houses.store',
        'show' => 'houses.show',
        'edit' => 'houses.edit',
        'update' => 'houses.update',
        'destroy' => 'houses.destroy',
    ]);
    Route::resource('subscription_plans', App\Http\Controllers\backend\SubscriptionPlanController::class);

    Route::post('/society-subscription/store', [SocietySubscriptionController::class, 'store']);
    Route::post('/society-subscription/update', [SocietySubscriptionController::class, 'update']);
    Route::post('/society-subscription/delete', [SocietySubscriptionController::class, 'destroy']);
    Route::post('/society-subscription/show', [SocietySubscriptionController::class, 'show']);
    Route::post('/society-subscription/list', [SocietySubscriptionController::class, 'list']);

    Route::resource('payments', PaymentController::class);
});
