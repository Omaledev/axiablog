<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentsController;


//landing page Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// student register, login & logout routes
Route::prefix('student')->group(function () {
        Route::get('/register', [AuthController::class, 'showregister'])->name('student.register');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::get('/login', [AuthController::class, 'showlogin'])->name('student.login');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware(['auth', 'student'])->group(function () {
            Route::get('/dashboard', [StudentsController::class, 'dashboard'])->name('student.dashboard');
   });
});


// admin register, login & logout routes routes
Route::prefix('admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showadminlogin'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'adminlogin']);

        Route::middleware(['auth','admin'])->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
            Route::get('/create', [AdminController::class, 'create'])->name('create');
   });
});

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');

