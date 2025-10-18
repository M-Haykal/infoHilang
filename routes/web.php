<?php

use App\Livewire\Start;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\Auth\AuthController;

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

// Route::get('/', Start::class)->name('start');

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//get api wilayah indonesia
Route::prefix('wilayah')->group(function () {
    Route::get('/provinces', [WilayahController::class, 'getProvinces']);
    Route::get('/regencies/{province_code}', [WilayahController::class, 'getRegencies'])
        ->where('province_code', '[0-9.]+');
    Route::get('/districts/{regency_code}', [WilayahController::class, 'getDistricts'])
        ->where('regency_code', '[0-9.]+');
    Route::get('/villages/{district_code}', [WilayahController::class, 'getVillages'])
        ->where('district_code', '[0-9.]+');
});

