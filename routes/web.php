<?php

use App\Livewire\Profile;
use App\Livewire\Start;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;

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

Route::get('/', Start::class)->name('start');

Route::get('/masuk', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/masuk', [AuthController::class, 'login'])->name('login');

Route::get('/daftar', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/daftar', [AuthController::class, 'register'])->name('register');

Route::prefix('user')->group(function () {
    Route::get('/home', [AuthController::class, 'showHome'])->name('home');
    Route::get('/profile', action: Profile::class)->name('profile');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


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

