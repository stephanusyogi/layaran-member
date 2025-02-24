<?php

use App\Http\Controllers\AnnounceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembershipController;
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

Route::middleware(['auth', 'role:member|admin'])->group(function () {
    Route::get('/account-details/{id}', [UserController::class, 'account_details'])->name('account_details');
    Route::post('/account-details/deactivate/{id}', [UserController::class, 'deactivate'])->name('account_details.deactivate');
    Route::post('/account-details/update/{id}', [UserController::class, 'update'])->name('account_details.update');
    Route::get('/account-details/change-password/{id}', [UserController::class, 'change_password'])->name('account_details.change-password');
    Route::post('/account-details/change-password/{id}', [UserController::class, 'change_password_action'])->name('account_details.change-password-action');

    Route::middleware(['check.subscription'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/manage-subscriptions', [MembershipController::class, 'manage_subscription'])->name('manage_subscriptions');

        Route::get('/billings', [BillingController::class, 'billings'])->name('billings');

        Route::get('/events', [BillingController::class, 'index'])->name('events');
    });
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/members/', [UserController::class, 'members'])->name('members'); 
    Route::get('/administrators/', [UserController::class, 'administrators'])->name('administrators');
    Route::get('/administrators/add', [UserController::class, 'administrators_add'])->name('administrators.add');
    Route::post('/administrators/create', [UserController::class, 'administrators_create'])->name('administrators.create');
    Route::get('/user/details/{id}', [UserController::class, 'details'])->name('user.details');

    
    Route::get('/announcements/', [AnnounceController::class, 'index'])->name('announcements');
    Route::get('/announcements/add', [AnnounceController::class, 'add'])->name('announcements.add');
    Route::post('/announcements/add', [AnnounceController::class, 'create'])->name('announcements.create');
    Route::get('/announcements/{id}', [AnnounceController::class, 'details'])->name('announcements.details');
    Route::post('/announcements/update/{id}', [AnnounceController::class, 'update'])->name('announcements.update');
    Route::post('/announcements/delete/{id}', [AnnounceController::class, 'delete'])->name('announcements.delete');
});
