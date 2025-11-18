<?php

use App\Http\Controllers\Dashboard\MissingStuffController;
use App\Livewire\Chat;
use App\Livewire\Profile;
use App\Livewire\Start;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\MissingsController;
use App\Http\Controllers\Dashboard\CommentarController;
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

Route::get('/', Start::class)->name('start');

Route::middleware('guest.redirect')->group(function () {
    // Google OAuth Routes
    Route::get('/oauth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/oauth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('showLogin');
    Route::post('/masuk', [AuthController::class, 'login'])->name('login');

    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('showRegister');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register');

    // Forgot Password Routes
    Route::get('/lupa-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password Routes
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat' , Chat::class)->name('chat');
    Route::prefix('user')->group(function () {
        Route::get('/profile', action: Profile::class)->name('profile');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/hilang', [MissingsController::class, 'index'])->name('missing');

        // Form laporan orang hilang
        Route::get('/form-orang-hilang', [MissingPersonController::class, 'index'])->name('form-orang-hilang');
        Route::post('/form-orang-hilang', [MissingPersonController::class, 'store'])->name('form-orang-hilang.store');
        Route::get('/detail-laporan-barang/{orangHilang}', [MissingPersonController::class, 'show'])->name('form-orang-hilang.detail');
        Route::get('/edit-laporan-orang/{orangHilang}', [MissingPersonController::class, 'edit'])->name('form-orang-hilang.edit');
        Route::put('/edit-laporan-orang/{orangHilang}', [MissingPersonController::class, 'update'])->name('form-orang-hilang.update');
        Route::get('/print-poster/{orangHilang}', [MissingPersonController::class, 'printPdf'])->name('form-orang-hilang.print-pdf');
        Route::delete('/orang-hilang/{orangHilang}', [MissingPersonController::class, 'destroy'])->name('form-orang-hilang.destroy');

        // Form laporan hilang barang
        Route::get('/form-barang-hilang', [MissingStuffController::class, 'index'])->name('form-barang-hilang');
        Route::post('/form-barang-hilang', [MissingStuffController::class, 'store'])->name('form-barang-hilang.store');
        Route::get('/detail-laporan-barang/{barangHilang}', [MissingStuffController::class, 'show'])->name('form-barang-hilang.detail');
        Route::get('/edit-laporan-barang/{barangHilang}', [MissingStuffController::class, 'edit'])->name('form-barang-hilang.edit');
        Route::put('/edit-laporan-barang/{barangHilang}', [MissingStuffController::class, 'update'])->name('form-barang-hilang.update');
        Route::get('/print-poster/{barangHilang}', [MissingStuffController::class, 'printPdf'])->name('form-barang-hilang.print-pdf');
        Route::delete('/barang-hilang/{barangHilang}', [MissingStuffController::class, 'destroy'])->name('form-barang-hilang.destroy');

        // Komentar routes
        Route::post('/commentar', [CommentarController::class, 'store'])->name('commentar.store');
        Route::put('/commentar/{comentar}', [CommentarController::class, 'update'])->name('commentar.update');
        Route::delete('/commentar/{comentar}', [CommentarController::class, 'delete'])->name('commentar.delete');
    });
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
