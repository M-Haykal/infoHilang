<div class="min-h-screen flex flex-col bg-secondary">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-purple-600 to-blue-600 h-screen text-white overflow-hidden"
        id="beranda">
        <div class="absolute inset-0">
            <img src="{{ asset('img/home-bg.jpg') }}" alt="Background Image"
                class="object-cover object-center w-full h-full" loading="lazy" />
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>

        <div class="relative z-10 flex flex-col justify-center items-center h-full text-center" data-aos="fade-up">
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
                <a href="#jenis-laporan"
                    class="bg-white text-primary font-bold px-8 py-3.5 rounded-full hover:bg-gray-100 transition shadow-lg hover:shadow-xl">
                    Laporkan Sekarang
                </a>
                <a href="#cara-kerja"
                    class="bg-transparent border-2 border-white text-white font-bold px-8 py-3.5 rounded-full hover:bg-white/10 transition">
                    Cara Kerja
                </a>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="about" class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                    fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100"></polygon>
                </svg>

                <div class="pt-1"></div>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h2 class="my-6 text-2xl tracking-tight font-extrabold text-gray-800 sm:text-4xl md:text-4xl">
                            Tentang Kami
                        </h2>

                        <p>
                            InfoHilang adalah platform digital yang didedikasikan untuk membantu masyarakat dalam
                            melaporkan, mencari, dan menemukan segala hal yang hilang—baik itu manusia, hewan
                            peliharaan, maupun benda berharga. Kami percaya bahwa setiap kehilangan adalah panggilan
                            untuk bertindak, dan setiap laporan adalah harapan yang layak diperjuangkan.
                        </p>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover object-top sm:h-72 md:h-96 lg:w-full lg:h-full"
                src="{{ asset('img/img-about.png') }}" alt="" loading="lazy">
        </div>
    </section>

    <!-- Jenis Laporan -->
    <section id="jenis-laporan" class="py-20 bg-accent" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4" data-aos="fade-up">Apa yang Bisa
                Dilaporkan?</h2>
            <p class="text-gray-600 text-center mb-16 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                InfoHilang mendukung berbagai jenis laporan kehilangan — semua dengan privasi dan keamanan terjamin.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Barang Hilang -->
                <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition border border-transparent hover:border-highlight/50"
                    data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('img/item.png') }}" alt="Barang Hilang" srcset="" class="object-fill"
                        loading="lazy">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Barang Hilang</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dompet, ponsel, dokumen penting, kunci, atau barang berharga lainnya.
                    </p>
                </div>

                <!-- Orang Hilang -->
                <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition border border-transparent hover:border-success/50"
                    data-aos="zoom-in" data-aos-delay="300">
                    <img src="{{ asset('img/people.png') }}" alt="Orang Hilang" srcset="" class="object-fill"
                        loading="lazy">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Orang Hilang</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Anak, lansia, atau anggota keluarga yang belum kembali ke rumah.
                    </p>
                </div>

                <!-- Hewan Hilang -->
                <div class="bg-white p-7 rounded-2xl shadow-sm hover:shadow-md transition border border-transparent hover:border-danger/50"
                    data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('img/animal.png') }}" alt="Hewan Hilang" srcset="" class="object-fill"
                        loading="lazy">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Hewan Peliharaan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kucing, anjing, burung, atau hewan kesayangan yang hilang dari rumah.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section id="cara-kerja" class="py-20 bg-white" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-16" data-aos="fade-up">
                Bagaimana InfoHilang Bekerja?
            </h2>

            <!-- Wrapper dengan relative agar garis bisa diposisikan secara absolute -->
            <div class="relative max-w-5xl mx-auto">
                <!-- Grid langkah-langkah -->
                <div class="grid md:grid-cols-4 gap-6">
                    @php($steps = [['num' => 1, 'title' => 'Laporkan', 'desc' => 'Isi formulir dengan detail kehilangan dan lokasi terakhir.'], ['num' => 2, 'title' => 'Sebarkan', 'desc' => 'Laporan muncul di peta dan notifikasi warga sekitar.'], ['num' => 3, 'title' => 'Temukan', 'desc' => 'Warga bisa melaporkan temuan langsung ke sistem.'], ['num' => 4, 'title' => 'Pulangkan', 'desc' => 'Kami bantu verifikasi dan koordinasi pengembalian.']])
                    @foreach ($steps as $index => $step)
                        <div class="text-center relative" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}">
                            <!-- Lingkaran nomor -->
                            <div
                                class="w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center mx-auto mb-5 font-bold text-lg z-10 relative">
                                {{ $step['num'] }}
                            </div>
                            <h3 class="font-bold text-gray-800 mb-3">{{ $step['title'] }}</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Garis putus-putus penghubung (hanya muncul di md+) -->
                <div class="hidden md:block absolute top-7 left-0 right-0 h-0.5 pointer-events-none">
                    <svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-dasharray="6,8">
                        <line x1="12%" y1="0" x2="88%" y2="0"
                            class="text-primary/30" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section (Opsional) -->
    @if (!auth()->check() && !session()->has('registered'))
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
    @endif
</div>

@push('style')
    <style>

    </style>
@endpush
