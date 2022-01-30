<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyLogin'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(['throttle:3,1'])->post('/email/verify/resend', [AuthController::class, 'resendVerification'])->name('verification.resend');

    Route::get('/user', [UserController::class, 'whoAmI'])->name('user.details');
});
