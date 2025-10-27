<?php

use App\Livewire\Profile;
use App\Livewire\Start;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MissingsController;
use App\Http\Controllers\Dashboard\MissingPersonController;

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
    Route::get('/hilang', [MissingsController::class, 'index'])->name('missing');

    // Form laporan orang hilang
    Route::get('/form-orang-hilang', [MissingPersonController::class, 'index'])->name('form-orang-hilang');
    Route::post('/form-orang-hilang', [MissingPersonController::class, 'store'])->name('form-orang-hilang.store');
    Route::get('/form-orang-hilang/{orangHilang}/edit', [MissingPersonController::class, 'edit'])->name('form-orang-hilang.edit');
    Route::put('/form-orang-hilang/{orangHilang}', [MissingPersonController::class, 'update'])->name('form-orang-hilang.update');
    Route::get('/{orangHilang}/print-pdf', [MissingPersonController::class, 'printPdf'])->name('form-orang-hilang.print-pdf');
    // Route::delete('/form-orang-hilang/{orangHilang}', [MissingPersonController::class, 'destroy'])->name('form-orang-hilang.destroy');
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

