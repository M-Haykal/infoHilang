{{-- <x-mail::message>
Selamat Datang di Info Hilang

Halo {{ $user->username ?? 'Pengguna' }},
Terima kasih telah bergabung dengan Info Hilang. Kami sangat senang bahwa Anda telah bergabung dengan kami.

Silakan klik tombol di bawah ini untuk membuat laporan hilang Anda:
<x-mail::button :url="route('dashboard')">
    Buat Laporan
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message> --}}

@component('mail::message')
    {{-- Greeting --}}
    Selamat Datang di Info Hilang, {{ $user->username ?? 'Pengguna' }}!

    {{-- Body --}}
    Terima kasih telah bergabung dengan Info Hilang. Kami sangat senang bahwa Anda telah bergabung dengan kami.

    {{-- Action Button --}}
    @component('mail::button', ['url' => route('dashboard')])
        Buat Laporan
    @endcomponent

    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent