<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ResponseFormatter;

class TestingController extends Controller
{
    //



    public function testing() {
        return ResponseFormatter::success('hallo' , ['pesan' => 'Hallo Selamat datang di API Belalbali']);
    }

    public function request() {
        \DB::table('password_reset_tokens')->insert([
            'email' => request()->email,
            'token' => 123456,
        ]);
    }
}
