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
}
