<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\GuestMessageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\UserController as WebUserController;
use App\Http\Controllers\User\AuthController as UserAuthController;


use App\Http\Controllers\Web\PageController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Web\GuestMessageController as WebGuestMessage;

Route::post('/guest-messages', [WebGuestMessage::class, 'store'])
    ->name('guest-messages.store');


// 🌍 Default route
Route::get('/', function () {
    return view('web.index');
});

// 🌐 Language switcher
Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        Session::put('locale', $lang);
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('lang.switch');

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/courses', 'courses')->name('courses');
    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/contact', 'contact')->name('contact');

});

// ✉️ Guest sends message
Route::post('guest/messages', [GuestMessageController::class, 'store'])->name('guest.messages.store');

// ============================
// 🔐 Admin Routes
// ============================
Route::prefix('admin')->group(function () {

    // 🧩 Auth
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AuthController::class, 'register'])->name('admin.register.post');

    // Protected routes
    Route::middleware('auth:admin')->group(function () {

        // 🏠 Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Admin CRUD
        Route::get('/admins', [AdminController::class, 'index'])->name('admin.admin.index');
        Route::get('/admins/data', [AdminController::class, 'data'])->name('admin.admin.data'); // for DataTables
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admin.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admin.admin.store');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.admin.edit');
        Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admin.admin.update');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admin.admin.destroy');


        // 📦 Packages
        Route::get('/packages', [PackageController::class, 'index'])->name('admin.packages.index');
        Route::get('/packages/create', [PackageController::class, 'create'])->name('admin.packages.create');
        Route::post('/packages/store', [PackageController::class, 'store'])->name('admin.packages.store');
        Route::get('/packages/edit/{id}', [PackageController::class, 'edit'])->name('admin.packages.edit');
        Route::post('/packages/update/{id}', [PackageController::class, 'update'])->name('admin.packages.update');
        Route::get('/packages/delete/{id}', [PackageController::class, 'destroy'])->name('admin.packages.destroy');
        Route::get('/packages/data', [PackageController::class, 'data'])->name('admin.packages.data'); // for DataTables


        // 👤 Users
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/users/data', [UserController::class, 'data'])->name('admin.users.data'); // for DataTables
        // routes/web.php or routes/admin.php
        Route::delete('admin/users/files/{file}', [UserController::class, 'deleteFile'])
            ->name('admin.users.deleteFile');



        // 🧑‍💻 Guest Users
        Route::get('/guests', [GuestMessageController::class, 'index'])->name('admin.guests.index');
        Route::get('/guests/data', [GuestMessageController::class, 'data'])->name('admin.guests.data');

        Route::get('/guests/{id}/convert', [GuestMessageController::class, 'convertGuestToUser'])->name('admin.guests.convert');

        // ⚙️ Settings (optional)
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');

        // 🚪 Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
});

// ============================
// 👤 User Routes (normal users)
// ============================
// Login
Route::get('/user/login', [UserAuthController::class, 'showLoginForm'])
    ->name('user.login');

Route::post('/user/login', [UserAuthController::class, 'login'])
    ->name('user.login.submit');

// Register
Route::get('/user/register', [UserAuthController::class, 'showRegisterForm'])
    ->name('user.register');

Route::post('/user/register', [UserAuthController::class, 'register'])
    ->name('user.register.submit');

// Logout
Route::post('/user/logout', [UserAuthController::class, 'logout'])
    ->name('user.logout');

// ====================================
// Protected Routes (User must be logged in)
// ====================================
Route::middleware(['auth:web'])->prefix('user')->name('user.')->group(function () {

    // Dashboard
    // Route::get('/dashboard', [DashboardController::class, 'index'])
    //     ->name('dashboard');

    // Profile
    Route::get('/profile', [WebUserController::class, 'profile'])
        ->name('profile');

    Route::post('/profile/update', [WebUserController::class, 'updateProfile'])
        ->name('updateProfile');

    // File Manager
    Route::post('/file/upload', [WebUserController::class, 'uploadFile'])
        ->name('uploadFiles');

    Route::get('/files', [WebUserController::class, 'myFiles'])
        ->name('files');

    Route::delete('/file/{id}', [WebUserController::class, 'deleteFile'])
        ->name('file.delete');

    // Workouts
    Route::get('/workouts', [WebUserController::class, 'myWorkouts'])
        ->name('workouts');
});
