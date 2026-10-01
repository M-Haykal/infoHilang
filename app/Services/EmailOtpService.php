<?php

namespace App\Services;

use App\Jobs\SendEmailOtpJob;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * EmailOtpService
 *
 * Mengelola kode OTP untuk verifikasi email pengguna:
 * pembuatan + pengiriman, pembatasan spam (cooldown), pembatasan percobaan,
 * serta verifikasi kode.
 */
class EmailOtpService
{
    /** Masa berlaku kode OTP (menit). */
    public const TTL_MINUTES = 10;

    /** Jeda minimum sebelum pengguna boleh meminta kode baru (detik). */
    public const RESEND_COOLDOWN_SECONDS = 60;

    /** Jumlah maksimal percobaan salah sebelum kode dibatalkan. */
    public const MAX_ATTEMPTS = 5;

    /**
     * Buat kode OTP baru, simpan dalam bentuk hash, lalu kirim via queue.
     *
     * @return string kode OTP mentah (6 digit)
     */
    public function send(User $user): string
    {
        $otp = (string) random_int(100000, 999999);

        $user->forceFill([
            'email_otp_code' => Hash::make($otp),
            'email_otp_expires_at' => now()->addMinutes(self::TTL_MINUTES),
            'email_otp_sent_at' => now(),
            'email_otp_attempts' => 0,
        ])->save();

        dispatch(new SendEmailOtpJob($user, $otp));

        return $otp;
    }

    /**
     * Sisa waktu tunggu (detik) sebelum pengguna boleh meminta kode lagi.
     */
    public function cooldownLeft(User $user): int
    {
        if (! $user->email_otp_sent_at) {
            return 0;
        }

        $availableAt = $user->email_otp_sent_at->copy()->addSeconds(self::RESEND_COOLDOWN_SECONDS);

        return $availableAt->isFuture() ? (int) ceil(now()->diffInSeconds($availableAt)) : 0;
    }

    /**
     * Verifikasi kode OTP milik pengguna.
     *
     * @return array{ok: bool, message: string}
     */
    public function verify(User $user, string $code): array
    {
        if ($user->hasVerifiedEmail()) {
            return ['ok' => true, 'message' => 'Email Anda sudah terverifikasi sebelumnya.'];
        }

        if (! $user->email_otp_code || ! $user->email_otp_expires_at) {
            return ['ok' => false, 'message' => 'Belum ada kode OTP aktif. Silakan minta kode baru.'];
        }

        if ($user->email_otp_expires_at->isPast()) {
            $this->clear($user);

            return ['ok' => false, 'message' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.'];
        }

        if ((int) $user->email_otp_attempts >= self::MAX_ATTEMPTS) {
            $this->clear($user);

            return ['ok' => false, 'message' => 'Terlalu banyak percobaan salah. Silakan minta kode baru.'];
        }

        if (! Hash::check($code, $user->email_otp_code)) {
            $user->increment('email_otp_attempts');
            $remaining = max(self::MAX_ATTEMPTS - (int) $user->email_otp_attempts, 0);

            return ['ok' => false, 'message' => "Kode OTP salah. Sisa percobaan: {$remaining}."];
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'email_otp_code' => null,
            'email_otp_expires_at' => null,
            'email_otp_sent_at' => null,
            'email_otp_attempts' => 0,
        ])->save();

        return ['ok' => true, 'message' => 'Email berhasil diverifikasi!'];
    }

    /**
     * Hapus kode OTP yang tersimpan (dipakai saat kode kedaluwarsa/gagal,
     * atau ketika email pengguna diubah).
     */
    public function clear(User $user): void
    {
        $user->forceFill([
            'email_otp_code' => null,
            'email_otp_expires_at' => null,
            'email_otp_sent_at' => null,
            'email_otp_attempts' => 0,
        ])->save();
    }
}
