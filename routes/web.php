<?php

use App\Http\Controllers\PresensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/proseslogin', [AuthController::class, 'proseslogin']);

Route::middleware(['auth:pegawai'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']); 
    Route::get('/absensi/create', [PresensiController::class, 'create']);
    Route::post('/absensi/store', [PresensiController::class, 'store']);
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('absensi/{nik}/updateprofile', [PresensiController::class,'updateprofile']);
    Route::get('/absensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);
    Route::get('/absensi/izin', [PresensiController::class, 'izin']);
    Route::get('/absensi/izinn', [PresensiController::class, 'izinn']);
    Route::post('/absensi/storeizin', [PresensiController::class, 'storeizin']);
});
