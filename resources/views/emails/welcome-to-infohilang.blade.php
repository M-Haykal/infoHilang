@component('mail::message')
    # Selamat Datang di Info Hilang!

    Halo **{{ $user->fullname ?? ($user->username ?? 'Pengguna') }}**,

    Kami sangat senang Anda bergabung dengan komunitas Info Hilang! Kami percaya setiap orang berhak mendapatkan kembali apa
    yang hilang. Di sini, Anda dapat:

    * **Melaporkan barang, orang, atau hewan yang hilang** dengan mudah dan cepat.
    * **Membantu sesama** dengan menemukan dan mengembalikan apa yang hilang.
    * **Berinteraksi dengan pengguna lain** untuk memperluas jaringan pencarian.

    Mari mulai membantu dan ditemukan!

    @component('mail::button', ['url' => route('dashboard')])
        Jelajahi Dashboard Anda
    @endcomponent

    Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami.

    Terima kasih,<br>
    Tim {{ config('app.name') }}
@endcomponent
