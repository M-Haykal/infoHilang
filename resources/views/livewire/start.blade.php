<main>
    <!-- Hero Section -->
    <header class="bg-blue-600 py-20 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight" data-aos="fade-up">
                Menyatukan Kembali yang Hilang
            </h1>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto" data-aos="fade-up">
                Platform komunitas untuk melaporkan dan menemukan barang, hewan, atau orang tercinta. Mari saling membantu.
            </p>
            <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up">
                <a href="" class="bg-white text-blue-700 px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition">Cari Sesuatu</a>

                <a href="{{ route('list-missing') }}" class="bg-blue-800 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-900 transition border border-blue-400">Lihat Semua Laporan</a>
            </div>
        </div>
    </header>

    {{-- Laporan Terbaru --}}

    <section id="laporan" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 gap-4">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-extrabold text-slate-800 mb-2">Laporan Terbaru</h2>
                    <p class="text-slate-600 mt-2">Bantu tetangga kita menemukan apa yang hilang</p>
                </div>

                <div class="flex flex-wrap justify-center md:justify-end gap-2">
                    <button class="bg-orange-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-sm">Semua</button>
                    <button class="bg-white text-slate-600 px-4 py-2 rounded-full text-sm font-medium border hover:border-orange-500 transition shadow-sm">Orang</button>
                    <button class="bg-white text-slate-600 px-4 py-2 rounded-full text-sm font-medium border hover:border-orange-500 transition shadow-sm">Hewan</button>
                    <button class="bg-white text-slate-600 px-4 py-2 rounded-full text-sm font-medium border hover:border-orange-500 transition shadow-sm">Barang</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($orangHilang as $orang)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 border border-slate-200 group">
                    <div class="relative overflow-hidden">
                        @php
                        $fotoUrl = $orang->foto && count($orang->foto) > 0
                        ? $orang->foto[0]
                        : 'https://ui-avatars.com/api/?name=' . urlencode($orang->nama_orang) . '&background=random';
                        @endphp
                        <img src="{{ $fotoUrl }}" alt="{{ $orang->nama_orang }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">

                        <span class="absolute top-3 left-3 {{ $orang->status == 'Hilang' ? 'bg-red-600' : 'bg-green-600' }} text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            {{ $orang->status }}
                        </span>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-lg text-slate-800 truncate" title="{{ $orang->nama_orang }}">
                                {{ $orang->nama_orang }}
                            </h3>
                            <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap ml-2">
                                {{ $orang->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-slate-500 text-sm mb-4 line-clamp-2 h-10">
                            {{ $orang->deskripsi_orang ?? 'Tidak ada deskripsi tambahan.' }}
                        </p>

                        <div class="flex items-center text-xs text-slate-600 mb-4 bg-slate-50 p-2 rounded-lg border border-slate-100">
                            <i class="fa-solid fa-location-dot mr-2 text-red-500"></i>
                            <span class="truncate">{{ $orang->lokasi_terakhir_dilihat }}</span>
                        </div>

                        <a href="/laporan/{{ $orang->slug }}" class="block w-full text-center bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 rounded-lg transition-colors">
                            Detail Laporan
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-10 text-center">
                    <div class="text-slate-300 mb-3">
                        <i class="fa-solid fa-folder-open text-5xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada laporan orang hilang saat ini.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('list-missing') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-all border-b-2 border-transparent hover:border-blue-600">Lihat Semua 150+ Laporan <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </section>

    <!-- Jenis Laporan -->
    <section id="jenis-laporan" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-slate-800">
                    Apa yang Bisa Dilaporkan?
                </h2>
                <p class="text-slate-600 max-w-2xl mx-auto leading-relaxed mt-2">
                    InfoHilang mendukung berbagai jenis laporan kehilangan
                </p>
                <div class="w-20 h-1.5 bg-orange-600 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up">
                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-slate-200 hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="100">
                    <div class="mb-6 overflow-hidden rounded-2xl bg-blue-50 flex justify-center items-center h-48">
                        <img src="{{ asset('img/item.png') }}" alt="Barang Hilang" class="w-3/4 h-auto object-contain transform group-hover:scale-110 transition duration-500" loading="lazy">
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3 transition">Barang Berharga</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">
                        Dompet, ponsel, dokumen penting (KTP/STNK), kunci, atau barang elektronik lainnya.
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-slate-200 hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="200">
                    <div class="mb-6 overflow-hidden rounded-2xl bg-blue-50 flex justify-center items-center h-48">
                        <img src="{{ asset('img/people.png') }}" alt="Orang Hilang" class="w-3/4 h-auto object-contain transform group-hover:scale-110 transition duration-500" loading="lazy">
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3 transition">Orang Hilang</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">
                        Anak-anak, lansia dengan demensia, atau anggota keluarga yang belum kembali ke rumah.
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-slate-200 hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="300">
                    <div class="mb-6 overflow-hidden rounded-2xl bg-blue-50 flex justify-center items-center h-48">
                        <img src="{{ asset('img/animal.png') }}" alt="Hewan Hilang" class="w-3/4 h-auto object-contain transform group-hover:scale-110 transition duration-500" loading="lazy">
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3 transition">Hewan Peliharaan</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">
                        Kucing, anjing, burung kesayangan, atau hewan ternak yang terlepas dari pengawasan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section id="cara-kerja" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-slate-800">Bagaimana InfoHilang Bekerja?</h2>
            <div class="w-20 h-1.5 bg-orange-600 mx-auto rounded-full mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="100">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">1. Buat Laporan</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Unggah detail, foto, dan lokasi terakhir saat kehilangan terjadi.</p>
            </div>

            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-share-nodes"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">2. Sebarkan</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Komunitas kami akan membantu menyebarkan informasi ke berbagai kanal.</p>
            </div>

            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="300">
                <div class="w-16 h-16 bg-purple-200 text-purple-700 rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">3. Notifikasi</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Terima pembaruan waktu nyata saat ada petunjuk yang cocok.</p>
            </div>

            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="400">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">4. Temukan</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Hubungkan penemu dengan pemilik asli secara aman dan cepat.</p>
            </div>
        </div>

        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 dark:bg-background-dark/50 rounded-xl">
        <div class="flex flex-col items-center" data-aos="fade-up">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-slate-800">Kisah Sukses dari Komunitas Kami</h2>
                <div class="w-20 h-1.5 bg-orange-600 mx-auto rounded-full mt-4"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-slate-200 shadow-md hover:shadow-xl bg-white" data-aos="zoom-in" data-aos-delay="100">
                    <p class="italic">"Saya panik saat kucing saya,
                        Miko, hilang. Berkat laporan di InfoHilang, tetangga beberapa blok dari rumah menemukan dan
                        menghubungi saya. Terima kasih banyak!"</p>
                    <div class="flex items-center gap-4 mt-2">
                        <img class="size-12 rounded-full object-cover" data-alt="Photo of Sarah L." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXnNLy154HP3LSxudxvFADlHA73BxiJX0D-Rokecon-VQzjRAyTHz3JwQ5w0isXGLrPMDO2HFKJpiKgoZau-bNJh9FhTRiBFyqve05Jchsv8MVnlXnWRhxn3XeanftVLDFewP2UBQZYHF71zbbPE94O0TKkQXMIcy4UpB99knfYkQj2-HeR1KT33NbNZC48yVZxTQPwcjlwupLU76mzxjiGo2vxJQFDbVxo-uJnhcXrCN9R-LK5dPhBIudbgjnk9xdwssWRpWMOes" />
                        <div>
                            <p class="font-bold text-blue-600">Sarah L.</p>
                            <p class="text-sm text-slate-600">Pemilik Miko</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-slate-200 shadow-md hover:shadow-xl bg-white" data-aos="zoom-in" data-aos-delay="200">
                    <p class="italic">"Saya menemukan dompet di stasiun
                        kereta. Saya bingung harus bagaimana, lalu teman menyarankan lapor di sini. Dalam beberapa jam,
                        pemiliknya sudah menghubungi saya. Platform ini sangat efisien."</p>
                    <div class="flex items-center gap-4 mt-2">
                        <img class="size-12 rounded-full object-cover" data-alt="Photo of Budi S." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYY4Nd830QbuAgsPtMTeeWToGS25rVcV9WIpueu5IUQjDNyJv6V677oWt_C8ACh1WtjQYQWn9DRD3Dz0YPnjrPldmIQjiHqOvNkvrnYAejSBybbPrNr1c2UR9uur67UoqSgD1kULIy9ONc7XuqxqSoejRuzpH5HSRyETMagDW2I-_Zicj6ae-PBOk3J76MBcm67M-hieJqVQ1TO8Ubd71Ntg4RAHSGEzH0dREe7p59-wMaaEHKqj7fhLeD3vyCpHJA8uskzwhTu2Y" />
                        <div>
                            <p class="font-bold text-blue-600">Budi S.</p>
                            <p class="text-sm text-slate-600">Penemu Dompet</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-slate-200 shadow-md hover:shadow-xl bg-white" data-aos="zoom-in" data-aos-delay="300">
                    <p class="italic">"Kunci motor saya jatuh entah di
                        mana. Saya sudah pasrah, tapi iseng membuat laporan. Ternyata ada yang menemukannya dan
                        mengunggahnya ke InfoHilang. Sangat membantu!"</p>
                    <div class="flex items-center gap-4 mt-2">
                        <img class="size-12 rounded-full object-cover" data-alt="Photo of Rina A." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBVhs6uSvV8MzWxD3eCnA9SBsbpbst4ctdJZH9rL4aeqbN50wvflpzDlv-WUF6ffR5jbB7r1cCXQwhZiooag452niDzCPACiEaZ2j90vj3D_HrnaAoHDIBZypWofCUnv8rZCgHCLcUNdegjUohlngD9UJt5jyfp1nVbXcYM7Y8oFwT51IYdG0wUAFnVv4DZ-kAzqIQPFA_5IKIWnoaCjLGE6hRf97YbbtRB6QAQfZq62iRXU5jdK-HJGZ4cWYsaeR_dzPwANxA88Rs" />
                        <div>
                            <p class="font-bold text-blue-600">Rina A.</p>
                            <p class="text-sm text-slate-600">Pemilik Kunci</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-16 bg-slate-50 sm:py-24" id="faq" data-aos="fade-up">
        <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="max-w-2xl mx-auto text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-slate-800">
                    FAQ <span class="text-blue-600">-</span> Pertanyaan Umum
                </h2>
                <div class="w-20 h-1.5 bg-orange-600 mx-auto rounded-full mt-4"></div>
            </div>

            <div id="faq-list" class="max-w-3xl mx-auto space-y-4">
                <div class="animate-pulse bg-white h-16 rounded-2xl border border-slate-200"></div>
            </div>

            <p class="text-center text-slate-500 mt-12">
                Masih punya pertanyaan lain?
                <a href="#" class="font-bold text-blue-600 hover:text-blue-700 transition-all border-b-2 border-transparent hover:border-blue-600">
                    Hubungi Admin Kami
                </a>
            </p>
        </div>
    </section>

    <!-- CTA Section (Opsional) -->
    {{-- @if (!auth()->check() && !session()->has('registered'))
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
    @endif --}}
</main>

@push('style')
<style>

</style>
@endpush

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqs = [{
                question: "Apa itu InfoHilang?"
                , answer: "InfoHilang adalah platform komunitas untuk membantu menemukan orang, hewan, atau barang yang hilang melalui sistem laporan publik dan peta lokasi."
            }
            , {
                question: "Apakah saya harus login untuk membuat laporan?"
                , answer: "Tidak wajib, namun dengan akun Anda bisa mengedit laporan, menerima pesan langsung dari penemu, dan mendapatkan notifikasi perkembangan terbaru secara real-time."
            }
            , {
                question: "Apakah identitas saya aman?"
                , answer: "Sangat aman. Nomor HP dan email Anda tidak ditampilkan ke publik. Komunikasi dilakukan melalui sistem chat internal di dalam platform kami."
            }
            , {
                question: "Bagaimana cara melaporkan temuan?"
                , answer: "Klik tombol 'Buat Laporan' lalu pilih kategori 'Ditemukan'. Kami akan mencocokkan data Anda dengan laporan kehilangan yang ada di sistem kami."
            }
            , {
                question: "Apakah InfoHilang menarik biaya?"
                , answer: "Tidak ada biaya sama sekali (Gratis). Platform ini dibangun sebagai bentuk gotong royong antar sesama anggota masyarakat."
            }
        ];

        const faqList = document.getElementById('faq-list');

        faqList.innerHTML = faqs.map((faq, index) => `
            <div class="faq-item group transition-all duration-300 bg-white border brounded-2xl overflow-hidden hover:shadow-md">
                <button type="button"
                        class="faq-btn flex items-center justify-between w-full px-6 py-5 text-left outline-none focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-inset transition-all duration-300">
                    <span class="text-lg font-bold text-slate-700 group-hover:text-orange-600 transition-colors duration-300 tracking-tight">
                        ${faq.question}
                    </span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300 text-sm"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-6 text-slate-600 leading-relaxed">
                    <div class="pt-4 border-t border-slate-100">
                        ${faq.answer}
                    </div>
                </div>
            </div>
        `).join('');

        const buttons = document.querySelectorAll('.faq-btn');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const answer = btn.nextElementSibling;
                const parent = btn.parentElement;
                const questionText = btn.querySelector('span');

                // Cek apakah item ini sudah terbuka
                const isAlreadyOpen = !answer.classList.contains('hidden');

                // Tutup SEMUA FAQ yang lagi terbuka
                document.querySelectorAll('.faq-answer').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('.faq-btn span').forEach(span => {
                    span.classList.remove('text-orange-600');
                    span.classList.add('text-slate-700');
                });
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('border-orange-500', 'ring-1', 'ring-orange-500/20', 'shadow-md');
                });

                // Jika sebelumnya tertutup, buka yang diklik
                if (!isAlreadyOpen) {
                    answer.classList.remove('hidden');
                    parent.classList.add('border-orange-500', 'ring-1', 'ring-orange-500/20', 'shadow-md');
                    questionText.classList.remove('text-slate-700');
                    questionText.classList.add('text-orange-600');
                }
            });
        });
    });

</script>
@endpush
