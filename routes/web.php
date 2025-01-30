<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [DashboardController::class, 'index']);

Route::get('/login', [AuthController::class, 'signin']);
Route::post('/login', [AuthController::class, 'signin_action']);

Route::get('/register', [AuthController::class, 'signup']);
Route::post('/register', [AuthController::class, 'signup_action'])->name('register.action');
