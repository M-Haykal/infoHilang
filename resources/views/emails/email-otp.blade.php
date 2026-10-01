@component('mail::message')
    # Verifikasi Email Anda

    Halo **{{ $user->fullname ?? ($user->username ?? 'Pengguna') }}**,

    Terima kasih telah menggunakan InfoHilang. Gunakan kode OTP di bawah ini untuk memverifikasi alamat email Anda:

    <div style="text-align: center; margin: 28px 0;">
        <span
            style="display: inline-block; font-size: 32px; font-weight: 800; letter-spacing: 10px; color: #365CCE; background-color: #F1F5FF; padding: 14px 26px; border-radius: 10px;">
            {{ $otp }}
        </span>
    </div>

    Kode ini berlaku selama **{{ $ttl }} menit** dan hanya dapat digunakan satu kali.

    Demi keamanan, **jangan bagikan kode ini** kepada siapa pun, termasuk pihak yang mengaku dari tim InfoHilang.

    Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini.

    Terima kasih,<br>
    Tim {{ config('app.name') }}
@endcomponent
