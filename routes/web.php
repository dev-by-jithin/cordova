<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ModeController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function() {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/create-user', [AuthController::class, 'store'])->name('auth.store');
});


Route::group(['middleware' => 'auth'], function(){

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/groups', [GroupController::class, 'index'])->name('group.index');
    Route::get('/modes', [ModeController::class, 'index'])->name('mode.index');
    Route::get('/tickets', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/rates', [RateController::class, 'index'])->name('rate.index');
    Route::get('/rates/{id}/edit', [RateController::class, 'edit'])->name('rate.edit');
    Route::put('/rates/update', [RateController::class, 'update'])->name('rate.update');

    Route::get('/scheme', [SchemeController::class, 'index'])->name('scheme.index');
    Route::get('/scheme/create', [SchemeController::class, 'create'])->name('scheme.create');
    Route::post('/scheme/store', [SchemeController::class, 'store'])->name('scheme.store');

    Route::get('/price', [PriceController::class, 'index'])->name('price.index');
    Route::get('/price/{id}/edit', [PriceController::class, 'edit'])->name('price.edit');
    Route::put('/price/update', [PriceController::class, 'update'])->name('price.update');

});


