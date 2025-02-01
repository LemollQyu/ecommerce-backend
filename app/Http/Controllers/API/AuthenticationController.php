<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ResponseFormatter;
use App\Models\User;
use Validator;

class AuthenticationController extends Controller
{
    public function register()
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        do {
            $otp = rand(100000, 999999);
            $otpCount = User::where('otp_register', $otp)->count();
        } while ($otpCount > 0); // kalo otp sudah dipake make generate lagi

        $user = User::create([
            'email' => request()->email,
            'name' => request()->email,
            'otp_register' => $otp,
        ]);

        \Mail::to($user->email)->send(new \App\Mail\SendRegisterOTP($user));

        return ResponseFormatter::success([
            'is_sent' => true,
        ]);
    }

    public function verifyOtp()
    {
        // Implementasi untuk verifikasi OTP

        $validator = \Validator::make(request()->all(), [
            // cek email sudah ada di database
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|exists:users,otp_register',

        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $user = User::where('email', request()->email)->where('otp_register', request()->otp)->count();

        if($user > 0) {
            return ResponseFormatter::success([
                'is_correct' => true,
            ]);
        }

        return ResponseFormatter::error(400, 'Invalid OTP');
    }

    public function verifyRegister()
    {
        // Implementasi untuk verifikasi registrasi
        // finishing proses registrasi

        $validator = \Validator::make(request()->all(), [
            // cek email sudah ada di database
           'email' => 'required|email|exists:users,email',
            'otp' => 'required|exists:users,otp_register',
            'password' => 'required|min:6|confirmed' // password ini harus ada field password_confirmation

        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $user = User::where('email', request()->email)->where('otp_register', request()->otp)->first();

        if (!is_null($user)) {
            $user->update([
                'otp_register' => null,
                'email_verified_at' => now(),
                'password' => bcrypt(request()->password),
            ]);

            $token = $user->createToken(config('app.name'))->plainTextToken;

            return ResponseFormatter::success(['token' => $token]);
        }

        return ResponseFormatter::error(400, 'Invalid OTP');


    }
}

