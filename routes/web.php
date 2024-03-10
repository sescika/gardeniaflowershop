<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLogsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/filter/{query?}/{sortOrder?}/{filters?}', [ProductsController::class, 'filter'])->name('products.filter');
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');

Route::get('/register', [RegistrationController::class, 'getRegisterForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

Route::middleware(['auth'])->group(function () {
    //if admin
    Route::middleware('admin')->group(function () {
        //admin users
        Route::controller(UserController::class)->group(function () {
            Route::get('/admin/users', 'index')->name('admin.users');
            Route::post('/admin/users/store', 'store')->name('admin.users.store');
            Route::post('/admin/users/destroy/{id}', 'destroy')->name('admin.users.destroy');
            Route::put('/admin/users/update/{id}', 'update')->name('admin.users.update');
            //json
            Route::get('/admin/users/getAll', 'getAllUsersJson')->name('admin.users.getAll');
            Route::get('/admin/users/getRoles', 'getAllRolesJson')->name('admin.users.getRoles');
            Route::get('/admin/users/getUser/{id}', 'getUserJson')->name('admin.users.getUser');
        });
        //admin products
        Route::controller(ProductsController::class)->group(function () {
            Route::get('/admin/products', 'adminIndex')->name('admin.products');
            Route::post('/admin/products/store', 'store')->name('admin.products.store');
            Route::post('/admin/products/destroy/{id}', 'destroy')->name('admin.users.destroy');
            Route::put('/admin/products/update/{id}', 'update')->name('admin.users.update');
        });
        Route::controller(UserLogsController::class)->group(function () {
            Route::get('/admin/userLogs/{order?}', 'index')->name('admin.userLogs');
        });
    });
    //if user
    Route::middleware('profile')->group(function () {
        Route::get('/profile', [UserController::class, 'show'])->name('profile');
    });
    Route::put('/profile/update/{id}', [UserController::class, 'update'])->name('profile.update');
    //password reset    
    // Route::get('/profile/forgot-password', [UserController::class, 'resetPasswordSendEmailForm'])->name('user.resetPasswordSendEmailForm');
    // Route::post('/profile/forgot-password', [UserController::class, 'sendEmail'])->name('user.sendEmail');

    // Route::get('/profile/reset-password/{token}', [UserController::class, 'resetPasswordForm'])->name('password.reset');
    // Route::get('/profile/reset-password', [UserController::class, 'updatePassword'])->name('password.update');


    //logout
    Route::post('/logout', [AuthorizationController::class, 'performLogout'])->name('logout');
});

Route::middleware(['notauth'])->group(function () {
    Route::get('/login', [AuthorizationController::class, 'getLoginForm'])->name('login');
    Route::post('/login', [AuthorizationController::class, 'performLogin'])->name('performLogin');
});
