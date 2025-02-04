<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ResponseFormatter;
use App\Models\User;

class ProfileController extends Controller
{
    //

    public function getProfile(){
        // ini mendapatkan data user yang sedang login
        $user = auth()->user();

        return ResponseFormatter::success($user->api_response, ['data user login']);
    }

    public function updateProfile(){

        $validator = \Validator::make(request()->all(), [
            'name' => 'required|string|max:100|min:3',
            'email' => 'required|email|max:100|unique:users,email,' . auth()->id(),
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'username' => 'required|string|min:3|max:30|unique:users|regex:/^[a-zA-Z0-9_.]+$/',
            'phone' => 'required|numeric|digits_between:8,15',
            'store_name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan,Lainnya',
            'birth_day' => 'required|date_format:Y-m-d|before:today',
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, titik dan underscore',
            'birth_date.date_format' => 'Format tanggal harus YYYY-MM-DD',
            'phone.digits_between' => 'Nomor telepon harus antara 8-15 digit',
            'email.unique' => 'Alamat email sudah terdaftar',
            'gender.in' => 'Jenis kelamin tidak valid',

        ]);

        if($validator->fails()){
            return ResponseFormatter::error(400, $validator->errors());
        }

        $payload = $validator->validated();
        if(!is_null(request()->photo)){
            $payload['photo'] = request()->file('photo')->store(
                'user-photo', 'public'
            );
        }

        // dd(request()->all());

        $user = auth()->user();
        $user->update($payload);

        return ResponseFormatter::success($user->api_response);

    }
}
