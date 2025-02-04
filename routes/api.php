<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\TestingController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ProfileController;





// Route API Disini

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/welcome', [TestingController::class, 'testing']);
Route::post('/request', [TestingController::class, 'request']);


Route::post('/register', [AuthenticationController::class, 'register']);
// unutk verifikasi otp
Route::post('/verify-otp', [AuthenticationController::class, 'verifyOtp']);
Route::post('/verify-register', [AuthenticationController::class, 'verifyRegister']);


// untuk resend otp
Route::post('/resend-otp', [AuthenticationController::class, 'resendOtp']);

// login
Route::post('/login', [AuthenticationController::class, 'login']);

// Route API untuk forgot password
Route::prefix('forgot-password')->group(function(){
    Route::post('/request', [ForgotPasswordController::class, 'request']);
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
    // untuk resend otp
    Route::post('/resend-otp', [ForgotPasswordController::class, 'resendOtp']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

});

// Rooute profile

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::patch('/profile', [ProfileController::class, 'updateProfile']);
});

