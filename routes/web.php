<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('detail/{slug}', [HomeController::class, 'detail'])->name('detail');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::get('contact/{slug}', [HomeController::class, 'contact'])->name('contacta');
Route::post('contact', [HomeController::class, 'contactStore'])->name('contact.store');
Route::get('profile', [HomeController::class, 'profile'])->name('profile');
Route::post('profile', [HomeController::class, 'updateprofile'])->name('updateprofile');
Route::get('my-rentals', [HomeController::class, 'myRentals'])->name('myrentals');

// Auth routes (Supabase Auth)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::group(['middleware' => 'is_admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('cars', \App\Http\Controllers\Admin\CarController::class);
    Route::put('cars/update-image/{id}', [\App\Http\Controllers\Admin\CarController::class, 'updateImage'])->name('cars.updateImage');

    Route::resource('drivers', \App\Http\Controllers\Admin\DriverController::class);
    Route::put('drivers/update-image/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'updateImage'])->name('drivers.updateImage');

    Route::resource('bayars', \App\Http\Controllers\Admin\BayarController::class);
    Route::put('bayars/update-image/{id}', [\App\Http\Controllers\Admin\BayarController::class, 'updateImage'])->name('bayars.updateImage');


    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});
