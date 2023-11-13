<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(Request $request){
        // $pass = 12345;
        // echo Hash::make($pass);
    if (Auth::guard('pegawai')->attempt(['nik' => $request->nik, 'password' => $request->password])){
        return redirect('/dashboard');
    } else {
        return redirect('/')->with(['warning' => 'NIK / PASSWORD YANG DIMASUKKAN SALAH']);
    }
}
    public function proseslogout(){
        if (Auth::guard('pegawai')->check()){
            Auth::guard('pegawai')->logout();
            return redirect('/');
        }
    }
}  


