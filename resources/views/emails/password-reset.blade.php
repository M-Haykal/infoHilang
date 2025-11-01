@component('mail::message')
    {{-- Greeting --}}
    Halo {{ $user->name ?? 'Pengguna' }},

    {{-- Body --}}
    Kami menerima permintaan untuk mengatur ulang password Anda.

    {{-- Action Button --}}
    @component('mail::button', ['url' => $url])
        Reset Password
    @endcomponent

    Jika Anda tidak meminta reset password, abaikan email ini.

    {{-- Salam --}}
    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent
