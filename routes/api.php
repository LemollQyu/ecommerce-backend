<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\TestingController;





// Route API Disini

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/welcome', [TestingController::class, 'testing']);


Route::post('/register', [AuthenticationController::class, 'register']);
// unutk verifikasi otp
Route::post('/verify-otp', [AuthenticationController::class, 'verifyOtp']);
Route::post('/verify-register', [AuthenticationController::class, 'verifyRegister']);


// untuk resend otp
Route::post('/resend-otp', [AuthenticationController::class, 'resendOtp']);

// login
Route::post('/login', [AuthenticationController::class, 'login']);

