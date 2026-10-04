<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\CommentarController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DuplicateCheckController;
use App\Http\Controllers\Dashboard\MissingAnimalController;
use App\Http\Controllers\Dashboard\MissingPersonController;
use App\Http\Controllers\Dashboard\MissingsController;
use App\Http\Controllers\Dashboard\MissingStuffController;
use App\Http\Controllers\Dashboard\SSEController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\EmailVerificationController;
use App\Http\Controllers\Dashboard\ReportFoundController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\ChatBotController;
use App\Http\Middleware\CheckRole;
use App\Livewire\Chat;
use App\Livewire\DetailBlog;
use App\Livewire\DetailMissing;
use App\Livewire\ListBlog;
use App\Livewire\ListMissing;
use App\Livewire\Profile;
use App\Livewire\Start;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteMapController;


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

// Route::view('/', 'home');
Route::get('/test-401', function () {
    return view('errors.401');
});
// Route::get('/test-402', function () {
//     return view('errors.402');
// });
// Route::get('/test-403', function () {
//     return view('errors.403');
// });
// Route::get('/test-404', function () {
//     return view('errors.404');
// });
// Route::get('/test-419', function () {
//     return view('errors.419');
// });
// Route::get('/test-429', function () {
//     return view('errors.429');
// });
// Route::get('/test-500', function () {
//     return view('errors.500');
// });
// Route::get('/test-503', function () {
//     return view('errors.503');
// });
Route::get('/generate-sitemap', [SiteMapController::class, 'generate']);
Route::get('/test-sitemap', function () {
    $url = config('app.url');
    $path = public_path('sitemap.xml');

    \Illuminate\Support\Facades\Log::info('URL: ' . $url);
    \Illuminate\Support\Facades\Log::info('Path: ' . $path);

    try {
        \Spatie\Sitemap\SitemapGenerator::create($url)
            ->writeToFile($path);

        return 'Success! Check public folder.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/sitemap.xml', function () {
    $path = public_path('sitemap.xml');

    if (!file_exists($path)) {
        abort(404, 'Sitemap not found');
    }

    return response()->file($path, [
        'Content-Type' => 'application/xml'
    ]);
})->name('sitemap');

Route::get('/daftar-laporan', ListMissing::class)->name('list-missing');
Route::get('/', Start::class)->name('start');
Route::get('/laporan-{type}/{slug}', DetailMissing::class)->name('detail-missing');
Route::get('/artikel', ListBlog::class)->name('list-blog');
Route::get('/artikel/{slug}', DetailBlog::class)->name('detail-blog');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

Route::middleware('guest.redirect')->group(function () {
    // Google OAuth Routes
    Route::get('/oauth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/oauth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

    // Route::view('/login', 'auth/masuk');
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('showLogin');
    Route::post('/masuk', [AuthController::class, 'login'])->name('login');

    // Route::view('/signup', 'auth/signup');
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
    Route::get('/chat', Chat::class)->name('chat');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // SSE endpoint untuk real-time dashboard updates
    Route::get('/sse/dashboard-counts', [SSEController::class, 'stream'])->name('sse.dashboard');
    
    Route::middleware(CheckRole::class.':user')->prefix('user')->group(function () {
        Route::get('/profile', action: Profile::class)->name('profile');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/hilang', [MissingsController::class, 'index'])->name('missing');
        Route::post('/check-duplicate/{type}', [DuplicateCheckController::class, 'check'])->name('check-duplicate');

        // Settins
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::put('/settings/profil', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');

        // Verifikasi email via OTP
        Route::post('/settings/email/otp', [EmailVerificationController::class, 'send'])->name('settings.email.send-otp');
        Route::post('/settings/email/verify', [EmailVerificationController::class, 'verify'])->name('settings.email.verify');

        // Form laporan orang hilang
        Route::get('/form-orang-hilang', [MissingPersonController::class, 'index'])->name('form-orang-hilang');
        Route::post('/form-orang-hilang', [MissingPersonController::class, 'store'])->name('form-orang-hilang.store');
        Route::get('/detail-laporan-orang/{orangHilang}', [MissingPersonController::class, 'show'])->name('form-orang-hilang.detail');
        Route::get('/edit-laporan-orang/{orangHilang}', [MissingPersonController::class, 'edit'])->name('form-orang-hilang.edit');
        Route::put('/edit-laporan-orang/{orangHilang}', [MissingPersonController::class, 'update'])->name('form-orang-hilang.update');
        Route::get('/print-poster/orang/{orangHilang}', [MissingPersonController::class, 'printPdf'])->name('form-orang-hilang.print-pdf');
        Route::delete('/orang-hilang/{orangHilang}', [MissingPersonController::class, 'destroy'])->name('form-orang-hilang.destroy');

        // Form laporan hilang barang
        Route::get('/form-barang-hilang', [MissingStuffController::class, 'index'])->name('form-barang-hilang');
        Route::post('/form-barang-hilang', [MissingStuffController::class, 'store'])->name('form-barang-hilang.store');
        Route::get('/detail-laporan-barang/{barangHilang}', [MissingStuffController::class, 'show'])->name('form-barang-hilang.detail');
        Route::get('/edit-laporan-barang/{barangHilang}', [MissingStuffController::class, 'edit'])->name('form-barang-hilang.edit');
        Route::put('/edit-laporan-barang/{barangHilang}', [MissingStuffController::class, 'update'])->name('form-barang-hilang.update');
        Route::get('/print-poster/barang/{barangHilang}', [MissingStuffController::class, 'printPdf'])->name('form-barang-hilang.print-pdf');
        Route::delete('/barang-hilang/{barangHilang}', [MissingStuffController::class, 'destroy'])->name('form-barang-hilang.destroy');

        // Form laporan hewan hilang
        Route::get('/getAnimal', [MissingAnimalController::class, 'getAnimal'])->name('get-hewan-hilang');
        Route::get('/form-hewan-hilang', [MissingAnimalController::class, 'index'])->name('form-hewan-hilang');
        Route::post('/form-hewan-hilang', [MissingAnimalController::class, 'store'])->name('form-hewan-hilang.store');
        Route::post('/hewan/tambah-jenis', [MissingAnimalController::class, 'tambahJenis'])
            ->name('hewan.tambah-jenis');
        Route::post('/hewan/tambah-ras', [MissingAnimalController::class, 'tambahRas'])
            ->name('hewan.tambah-ras');
        Route::get('/detail-laporan-hewan/{hewanHilang}', [MissingAnimalController::class, 'show'])->name('form-hewan-hilang.detail');
        Route::get('/edit-laporan-hewan/{hewanHilang}', [MissingAnimalController::class, 'edit'])->name('form-hewan-hilang.edit');
        Route::put('/edit-laporan-hewan/{hewanHilang}', [MissingAnimalController::class, 'update'])->name('form-hewan-hilang.update');
        Route::get('/print-poster/hewan/{hewanHilang}', [MissingAnimalController::class, 'printPdf'])->name('form-hewan-hilang.print-pdf');
        Route::delete('/hewan-hilang/{hewanHilang}', [MissingAnimalController::class, 'destroy'])->name('form-hewan-hilang.destroy');

        // Komentar routes
        Route::post('/commentar', [CommentarController::class, 'store'])->name('commentar.store');
        Route::put('/commentar/{comentar}', [CommentarController::class, 'update'])->name('commentar.update');
        Route::delete('/commentar/{comentar}', [CommentarController::class, 'delete'])->name('commentar.delete');

        Route::get('/artikel', [BlogController::class, 'index'])->name('artikel');
        Route::get('/artikel/tulis', [BlogController::class, 'create'])->name('artikel.create');
        Route::post('/artikel/simpan', [BlogController::class, 'store'])->name('artikel.store');
        Route::get('/artikel/{slug}', [BlogController::class, 'show'])->name('artikel.show');
        Route::get('/artikel/{slug}/edit', [BlogController::class, 'edit'])->name('artikel.edit');
        Route::patch('/artikel/{slug}/update', [BlogController::class, 'update'])->name('artikel.update');
        Route::delete('/artikel/{slug}/hapus', [BlogController::class, 'destroy'])->name('artikel.destroy');

        // Report Found
        Route::get('/ditemukan', [ReportFoundController::class, 'index'])->name('found');
        Route::patch('/ditemukan/{id}/konfirmasi', [ReportFoundController::class, 'toggleConfirm'])
            ->name('report-found.confirm');
    });

    Route::middleware(CheckRole::class.':admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/dashboard/filter-chart', [AdminDashboardController::class, 'filterChart'])->name('admin.dashboard.filter-chart');
        Route::get('/laporan', [ReportController::class, 'index'])->name('admin.report');
        Route::post('/laporan/ajax', [ReportController::class, 'ajax'])->name('admin.report.ajax');
        
        // Route Detail Laporan Admin
        Route::get('/detail-laporan-barang/{slug}', [ReportController::class, 'showBarang'])->name('admin.report.detail.barang');
        Route::get('/detail-laporan-orang/{slug}', [ReportController::class, 'showOrang'])->name('admin.report.detail.orang');
        Route::get('/detail-laporan-hewan/{slug}', [ReportController::class, 'showHewan'])->name('admin.report.detail.hewan');
        
        // Route Manajemen User Admin
        Route::get('/user', [\App\Http\Controllers\Admin\ManageUserController::class, 'index'])->name('admin.user');
        Route::post('/user/ajax', [\App\Http\Controllers\Admin\ManageUserController::class, 'ajax'])->name('admin.user.ajax');
        
         // Route Manajemen Chat Admin (Chatbot)
        Route::get('/chat', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chat');
        Route::get('/chat/list', [\App\Http\Controllers\Admin\ChatController::class, 'list'])->name('admin.chat.list');
        Route::get('/chat/session/{userId}', [\App\Http\Controllers\Admin\ChatController::class, 'getSession']);
        Route::post('/chat/reply/{userId}', [\App\Http\Controllers\Admin\ChatController::class, 'sendReply']);
        Route::post('/chat/handled/{userId}', [\App\Http\Controllers\Admin\ChatController::class, 'markHandled']);

        // Route Customer Service Chat (Real-time)
        Route::get('/customer-chats', [\App\Http\Controllers\Admin\CustomerChatController::class, 'index'])->name('admin.customer-chats.index');
        Route::get('/customer-chats/{identifier}', [\App\Http\Controllers\Admin\CustomerChatController::class, 'show'])->name('admin.customer-chats.show');
        Route::post('/customer-chats/{identifier}/reply', [\App\Http\Controllers\Admin\CustomerChatController::class, 'reply'])->name('admin.customer-chats.reply');
    });

    Route::middleware(CheckRole::class.':developer')->prefix('developer')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Dashboard\DeveloperController::class, 'index'])->name('developer.dashboard');
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

