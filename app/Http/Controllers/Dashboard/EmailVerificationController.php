<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\EmailOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Verifikasi email pengguna menggunakan kode OTP.
 * Setiap endpoint bisa dipanggil sebagai form biasa (redirect + flash)
 * maupun sebagai AJAX (respons JSON).
 */
class EmailVerificationController extends Controller
{
    public function __construct(private EmailOtpService $otpService)
    {
    }

    /**
     * Kirim (atau kirim ulang) kode OTP ke email pengguna.
     */
    public function send(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return $this->respond($request, true, 'Email Anda sudah terverifikasi.', 200, [
                'verified' => true,
            ], false);
        }

        $cooldown = $this->otpService->cooldownLeft($user);

        if ($cooldown > 0) {
            return $this->respond(
                $request,
                false,
                "Mohon tunggu {$cooldown} detik lagi sebelum meminta kode baru.",
                429,
                ['cooldown' => $cooldown]
            );
        }

        $this->otpService->send($user);

        return $this->respond(
            $request,
            true,
            'Kode OTP telah dikirim ke ' . $user->email . '. Kode berlaku ' . EmailOtpService::TTL_MINUTES . ' menit.',
            200,
            ['cooldown' => EmailOtpService::RESEND_COOLDOWN_SECONDS]
        );
    }

    /**
     * Verifikasi kode OTP yang dimasukkan pengguna.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Masukkan kode OTP yang dikirim ke email Anda.',
            'otp.digits' => 'Kode OTP harus terdiri dari 6 angka.',
        ]);

        $result = $this->otpService->verify(Auth::user(), (string) $request->input('otp'));

        return $this->respond(
            $request,
            $result['ok'],
            $result['message'],
            $result['ok'] ? 200 : 422,
            $result['ok'] ? ['verified' => true] : []
        );
    }

    /**
     * Kembalikan JSON untuk request AJAX, atau redirect + flash untuk form biasa.
     */
    private function respond(
        Request $request,
        bool $success,
        string $message,
        int $status = 200,
        array $extra = [],
        bool $openModal = true
    ) {
        if ($request->expectsJson()) {
            return response()->json(array_merge([
                'success' => $success,
                'message' => $message,
            ], $extra), $status);
        }

        return $success
            ? back()->with('success', $message)->with('otp_sent', $openModal)
            : back()->withErrors(['otp' => $message])->with('otp_sent', $openModal);
    }
}
