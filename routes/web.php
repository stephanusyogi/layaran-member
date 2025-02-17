<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'signin'])->name('login');
    Route::post('/login', [AuthController::class, 'signin_action'])->name('login.action');
    
    Route::get('/register', [AuthController::class, 'signup'])->name('register');
    Route::post('/register', [AuthController::class, 'signup_action'])->name('register.action');
});


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Account Details
    Route::get('/account-details/{id}', [UserController::class, 'account_details'])->name('account_details');
    Route::post('/account-details/update/{id}', [UserController::class, 'update'])->name('account_details.update');
    Route::post('/account-details/deactivate/{id}', [UserController::class, 'deactivate'])->name('account_details.deactivate');
    
});
