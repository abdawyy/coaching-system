<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\GuestMessageController;




Route::get('/', function () {
    return view('web.index');
});

Route::post('guest/messages', [GuestMessageController::class, 'store']); // guest sends message




Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');


    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create');
        Route::post('packages/store', [PackageController::class, 'store'])->name('packages.store');
        Route::get('packages/edit/{id}', [PackageController::class, 'edit'])->name('packages.edit');
        Route::post('packages/update/{id}', [PackageController::class, 'update'])->name('packages.update');
        Route::get('packages/delete/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');

        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.post');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('guest/messages', [GuestMessageController::class, 'index']); // list messages
        Route::delete('guest/messages/{id}', [GuestMessageController::class, 'destroy']); // delete

        Route::post('admin/guest/{id}/convert', [GuestMessageController::class, 'convertGuestToUser']);

    });
});
