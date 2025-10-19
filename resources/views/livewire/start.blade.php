<div class="min-h-screen flex flex-col bg-secondary">
    <!-- Hero Section -->
    <section id="home"
        class="py-28 md:py-36 bg-gradient-to-br from-primary to-blue-700 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-1/4 left-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/3 right-10 w-80 h-80 bg-blue-300 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Temukan yang Hilang,<br>
                <span class="font-extrabold">Pulihkan Harapan</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto opacity-90">
                Laporkan dan temukan <span class="font-semibold">barang</span>, <span
                    class="font-semibold">orang</span>, atau <span class="font-semibold">hewan</span> hilang dengan
                cepat dan aman.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#types"
                    class="bg-white text-primary font-bold px-8 py-3.5 rounded-full hover:bg-gray-100 transition shadow-lg hover:shadow-xl">
                    Laporkan Sekarang
                </a>
                <a href="#how"
                    class="bg-transparent border-2 border-white text-white font-bold px-8 py-3.5 rounded-full hover:bg-white/10 transition">
                    Cara Kerja
                </a>
            </div>
        </div>
    </section>

    <!-- Jenis Laporan -->
    <section id="types" class="py-20 bg-accent" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4" data-aos="fade-up">Apa yang Bisa
                Dilaporkan?</h2>
            <p class="text-gray-600 text-center mb-16 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                InfoHilang mendukung berbagai jenis laporan kehilangan — semua dengan privasi dan keamanan terjamin.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Barang Hilang -->
                <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition border border-transparent hover:border-primary/50"
                    data-aos="zoom-in" data-aos-delay="200">
                    <div class="text-5xl mb-5">🧳</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Barang Hilang</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dompet, ponsel, dokumen penting, kunci, atau barang berharga lainnya.
                    </p>
                </div>

                <!-- Orang Hilang -->
                <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition border border-transparent hover:border-danger/50"
                    data-aos="zoom-in" data-aos-delay="300">
                    <div class="text-5xl mb-5">👤</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Orang Hilang</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Anak, lansia, atau anggota keluarga yang belum kembali ke rumah.
                    </p>
                </div>

                <!-- Hewan Hilang -->
                <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition border border-transparent hover:border-highlight/50"
                    data-aos="zoom-in" data-aos-delay="400">
                    <div class="text-5xl mb-5">🐾</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Hewan Peliharaan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kucing, anjing, burung, atau hewan kesayangan yang hilang dari rumah.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section id="how" class="py-20 bg-white" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-16" data-aos="fade-up">
                Bagaimana InfoHilang Bekerja?
            </h2>

            <div class="grid md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                @php($steps = [['num' => 1, 'title' => 'Laporkan', 'desc' => 'Isi formulir dengan detail kehilangan dan lokasi terakhir.'], ['num' => 2, 'title' => 'Sebarkan', 'desc' => 'Laporan muncul di peta dan notifikasi warga sekitar.'], ['num' => 3, 'title' => 'Temukan', 'desc' => 'Warga bisa melaporkan temuan langsung ke sistem.'], ['num' => 4, 'title' => 'Pulangkan', 'desc' => 'Kami bantu verifikasi dan koordinasi pengembalian.']])
                @foreach ($steps as $index => $step)
                    <div class="text-center" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}">
                        <div
                            class="w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center mx-auto mb-5 font-bold text-lg">
                            {{ $step['num'] }}
                        </div>
                        <h3 class="font-bold text-gray-800 mb-3">{{ $step['title'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section (Opsional) -->
    <section class="py-16 bg-gradient-to-r from-primary to-blue-600 text-white text-center" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h3 class="text-2xl md:text-3xl font-bold mb-4">Siap Menemukan yang Hilang?</h3>
            <p class="max-w-2xl mx-auto mb-8 opacity-90">
                Bergabunglah dengan ribuan pengguna yang telah berhasil menemukan kembali barang, orang, atau hewan
                kesayangan mereka.
            </p>
            <a href="{{ route('showRegister') }}"
                class="inline-block bg-white text-primary font-bold px-8 py-3 rounded-full hover:bg-gray-100 transition shadow-lg">
                Buat Akun Sekarang
            </a>
        </div>
    </section>
</div>

@push('style')
    <style>

    </style>
@endpush
