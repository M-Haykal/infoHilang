<main>
    <!-- Hero Section -->
    <header class="bg-primary py-20 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight" data-aos="fade-up">
                Menyatukan Kembali yang Hilang
            </h1>
            <p class="text-primary-light text-lg mb-8 max-w-2xl mx-auto" data-aos="fade-up">
                Platform komunitas untuk melaporkan dan menemukan barang, hewan, atau orang tercinta. Mari saling membantu.
            </p>
            <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up">
                <a href="" class="bg-white text-primary px-8 py-3 rounded-xl font-bold htransition-all duration-300 hover:scale-105 hover:shadow-[0_20px_40px_rgba(255,255,255,0.2)]">Cari Sesuatu</a>

                <a href="{{ route('list-missing') }}" class="bg-primary-dark text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-darker transition border border-blue-400">Lihat Semua Laporan</a>
            </div>
        </div>
    </header>

    {{-- Laporan Terbaru --}}

    <section id="laporan" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10 gap-4">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-extrabold text-dark mb-2">Laporan Terbaru</h2>
                    <p class="text-netral-500 mt-2">Bantu tetangga kita menemukan apa yang hilang</p>
                </div>

                <div class="flex flex-wrap justify-center md:justify-end gap-2">
                    @foreach(['Semua', 'Orang', 'Hewan', 'Barang'] as $item)
                    <button wire:click="setKategori('{{ $item }}')" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 shadow-sm border {{ $kategori === $item ? 'bg-primary text-white border-primary' : 'bg-white text-netral-500 hover:border-primary' }}">
                        {{ $item }}
                    </button>
                    @endforeach

                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($reports as $report)
                <div wire:key="report-{{ $report->tipe }}-{{ $report->id }}" class="bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 border border-netral-200 group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset($report->foto[0] ?? 'default.jpg') }}" alt="{{ $report->display_name }}" class="w-full max-h-70 md:h-48 object-cover group-hover:scale-105 transition-transform duration-500">

                        <span class="absolute top-3 left-3 {{ $report->status == 'Hilang' ? 'bg-danger' : 'bg-success' }} text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">

                            {{ $report->status }}

                        </span>
                    </div>

                    <div class="p-5">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-bold text-dark truncate" title="{{ $report->display_name }}">
                                {{ $report->display_name }}
                            </h3>
                            <span class="text-[10px] text-netral-400 font-medium whitespace-nowrap ml-2">
                                {{ $report->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-netral-500 text-sm mb-2 line-clamp-2 h-10">
                            {{ $report->display_desc ?? 'Tidak ada deskripsi tambahan.' }}
                        </p>

                        <div class="flex items-center text-xs text-netral-500 mb-4 bg-netral-50 p-2 rounded-lg border border-netral-100">
                            <i class="fa-solid fa-location-dot mr-2 text-accent"></i>
                            <span class="truncate">{{ $report->lokasi_terakhir_dilihat ?? $report->lokasi }}</span>
                        </div>

                        <a href="/laporan/{{ strtolower($report->tipe) }}/{{ $report->slug }}" class="block w-full text-center bg-dark hover:bg-dark-hover text-white font-bold text-sm py-2 rounded-lg transition-colors">
                            Detail Laporan
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-10 text-center">
                    <div class="text-netral-300 mb-3">
                        <i class="fa-solid fa-search text-4xl"></i>
                    </div>
                    <p class="text-netral-500 font-medium">Belum ada laporan {{ $kategori !== 'Semua' ? strtolower($kategori) : '' }} hilang ditemukan.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('list-missing') }}" class="font-bold text-primary hover:text-primary-dark transition-all border-b-2 border-transparent hover:border-primary-dark">Lihat Semua {{ $totalLaporan-5 }}+ Laporan <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </section>

    <!-- Jenis Laporan -->
    <section id="jenis-laporan" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-dark">
                    Apa yang Bisa Dilaporkan?
                </h2>
                <p class="text-netral-500 max-w-2xl mx-auto leading-relaxed mt-2">
                    InfoHilang mendukung berbagai jenis laporan kehilangan
                </p>
                <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up">
                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-netral-200 hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="100">
                    <div class="mb-6 overflow-hidden rounded-2xl bg-primary-light flex justify-center items-center h-48">
                        <img src="{{ asset('img/item.png') }}" alt="Barang Hilang" class="w-3/4 h-auto object-contain transform group-hover:scale-110 transition duration-500" loading="lazy">
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3 transition">Barang Berharga</h3>
                    <p class="text-netral-500 leading-relaxed text-sm">
                        Dompet, ponsel, dokumen penting (KTP/STNK), kunci, atau barang elektronik lainnya.
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-netral-200 hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="200">
                    <div class="mb-6 overflow-hidden rounded-2xl bg-primary-light flex justify-center items-center h-48">
                        <img src="{{ asset('img/people.png') }}" alt="Orang Hilang" class="w-3/4 h-auto object-contain transform group-hover:scale-110 transition duration-500" loading="lazy">
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3 transition">Orang Hilang</h3>
                    <p class="text-netral-500 leading-relaxed text-sm">
                        Anak-anak, lansia dengan demensia, atau anggota keluarga yang belum kembali ke rumah.
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-netral-200 hover:-translate-y-2" data-aos="zoom-in" data-aos-delay="300">
                    <div class="mb-6 overflow-hidden rounded-2xl bg-primary-light flex justify-center items-center h-48">
                        <img src="{{ asset('img/animal.png') }}" alt="Hewan Hilang" class="w-3/4 h-auto object-contain transform group-hover:scale-110 transition duration-500" loading="lazy">
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-3 transition">Hewan Peliharaan</h3>
                    <p class="text-netral-500 leading-relaxed text-sm">
                        Kucing, anjing, burung kesayangan, atau hewan ternak yang terlepas dari pengawasan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section id="cara-kerja" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-dark">Bagaimana InfoHilang Bekerja?</h2>
            <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="100">
                <div class="w-16 h-16 bg-blue-100 text-primary rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-dark">1. Buat Laporan</h3>
                <p class="text-netral-500 text-sm leading-relaxed">Unggah detail, foto, dan lokasi terakhir saat kehilangan terjadi.</p>
            </div>

            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="200">
                <div class="w-16 h-16 bg-orange-100 text-accent rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-share-nodes"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-dark">2. Sebarkan</h3>
                <p class="text-netral-500 text-sm leading-relaxed">Komunitas kami akan membantu menyebarkan informasi ke berbagai kanal.</p>
            </div>

            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="300">
                <div class="w-16 h-16 bg-purple-200 text-purple-700 rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-dark">3. Notifikasi</h3>
                <p class="text-netral-500 text-sm leading-relaxed">Terima pembaruan waktu nyata saat ada petunjuk yang cocok.</p>
            </div>

            <div class="p-6 flex flex-col items-center group" data-aos="zoom-in" data-aos-delay="400">
                <div class="w-16 h-16 bg-green-100 text-success rounded-full flex items-center justify-center mb-6 text-2xl shrink-0 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-dark">4. Temukan</h3>
                <p class="text-netral-500 text-sm leading-relaxed">Hubungkan penemu dengan pemilik asli secara aman dan cepat.</p>
            </div>
        </div>

        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 dark:bg-background-dark/50 rounded-xl">
        <div class="flex flex-col items-center" data-aos="fade-up">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-dark">Kisah Sukses dari Komunitas Kami</h2>
                <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-netral-200 shadow-md hover:shadow-xl bg-white" data-aos="zoom-in" data-aos-delay="100">
                    <p class="italic text-dark">"Saya panik saat kucing saya,
                        Miko, hilang. Berkat laporan di InfoHilang, tetangga beberapa blok dari rumah menemukan dan
                        menghubungi saya. Terima kasih banyak!"</p>
                    <div class="flex items-center gap-4 mt-2">
                        <img class="size-12 rounded-full object-cover" data-alt="Photo of Sarah L." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXnNLy154HP3LSxudxvFADlHA73BxiJX0D-Rokecon-VQzjRAyTHz3JwQ5w0isXGLrPMDO2HFKJpiKgoZau-bNJh9FhTRiBFyqve05Jchsv8MVnlXnWRhxn3XeanftVLDFewP2UBQZYHF71zbbPE94O0TKkQXMIcy4UpB99knfYkQj2-HeR1KT33NbNZC48yVZxTQPwcjlwupLU76mzxjiGo2vxJQFDbVxo-uJnhcXrCN9R-LK5dPhBIudbgjnk9xdwssWRpWMOes" />
                        <div>
                            <p class="font-bold text-primary">Sarah L.</p>
                            <p class="text-sm text-netral-500">Pemilik Miko</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-netral-200 shadow-md hover:shadow-xl bg-white" data-aos="zoom-in" data-aos-delay="200">
                    <p class="italic text-dark">"Saya menemukan dompet di stasiun
                        kereta. Saya bingung harus bagaimana, lalu teman menyarankan lapor di sini. Dalam beberapa jam,
                        pemiliknya sudah menghubungi saya. Platform ini sangat efisien."</p>
                    <div class="flex items-center gap-4 mt-2">
                        <img class="size-12 rounded-full object-cover" data-alt="Photo of Budi S." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYY4Nd830QbuAgsPtMTeeWToGS25rVcV9WIpueu5IUQjDNyJv6V677oWt_C8ACh1WtjQYQWn9DRD3Dz0YPnjrPldmIQjiHqOvNkvrnYAejSBybbPrNr1c2UR9uur67UoqSgD1kULIy9ONc7XuqxqSoejRuzpH5HSRyETMagDW2I-_Zicj6ae-PBOk3J76MBcm67M-hieJqVQ1TO8Ubd71Ntg4RAHSGEzH0dREe7p59-wMaaEHKqj7fhLeD3vyCpHJA8uskzwhTu2Y" />
                        <div>
                            <p class="font-bold text-primary">Budi S.</p>
                            <p class="text-sm text-netral-500">Penemu Dompet</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4 p-6 rounded-xl border border-netral-200 shadow-md hover:shadow-xl bg-white" data-aos="zoom-in" data-aos-delay="300">
                    <p class="italic text-dark">"Kunci motor saya jatuh entah di
                        mana. Saya sudah pasrah, tapi iseng membuat laporan. Ternyata ada yang menemukannya dan
                        mengunggahnya ke InfoHilang. Sangat membantu!"</p>
                    <div class="flex items-center gap-4 mt-2">
                        <img class="size-12 rounded-full object-cover" data-alt="Photo of Rina A." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBVhs6uSvV8MzWxD3eCnA9SBsbpbst4ctdJZH9rL4aeqbN50wvflpzDlv-WUF6ffR5jbB7r1cCXQwhZiooag452niDzCPACiEaZ2j90vj3D_HrnaAoHDIBZypWofCUnv8rZCgHCLcUNdegjUohlngD9UJt5jyfp1nVbXcYM7Y8oFwT51IYdG0wUAFnVv4DZ-kAzqIQPFA_5IKIWnoaCjLGE6hRf97YbbtRB6QAQfZq62iRXU5jdK-HJGZ4cWYsaeR_dzPwANxA88Rs" />
                        <div>
                            <p class="font-bold text-primary">Rina A.</p>
                            <p class="text-sm text-netral-500">Pemilik Kunci</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-16 bg-netral-50 sm:py-24" id="faq" data-aos="fade-up">
        <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="max-w-2xl mx-auto text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight text-dark">
                    FAQ <span class="text-primary">-</span> Pertanyaan Umum
                </h2>
                <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mt-4"></div>
            </div>

            <div id="faq-list" class="max-w-3xl mx-auto space-y-4">
                <div class="animate-pulse bg-white h-16 rounded-2xl border border-netral-200"></div>
            </div>

            <p class="text-center text-netral-500 mt-12">
                Masih punya pertanyaan lain?
                <a href="#" class="font-bold text-primary hover:text-primary-dark transition-all border-b-2 border-transparent hover:border-primary-dark">
                    Hubungi Admin Kami
                </a>
            </p>
        </div>
    </section>

    <!-- CTA Section (Opsional) -->
    @if (!auth()->check() && !session()->has('registered'))
    <section class="relative py-20 overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0 bg-primary"></div>

        <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-black/10 rounded-full translate-x-1/4 translate-y-1/4 blur-3xl"></div>

        <div class="container relative mx-auto px-4 text-center text-white">
            <div class="max-w-3xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl mb-6 border border-white/30 shadow-xl">
                    <i class="fa-solid fa-users-rays text-2xl"></i>
                </div>

                <h3 class="text-3xl md:text-4xl lg:text-5xl font-black mb-6 tracking-tight leading-tight">
                    Mari Saling Membantu <br class="hidden md:block"> Menemukan Kembali.
                </h3>

                <p class="text-lg md:text-xl mb-10 text-white/90 leading-relaxed">
                    Bergabunglah dengan komunitas <span class="text-white font-bold border-b-2 border-white/40">InfoHilang</span>. Ribuan orang telah terbantu menemukan kembali apa yang paling berharga bagi mereka.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('showRegister') }}" class="group relative inline-flex items-center justify-center bg-white text-primary font-bold px-10 py-4 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-[0_20px_40px_rgba(255,255,255,0.2)]">
                        <span class="mr-2">Mulai Buat Laporan</span>
                        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                    </a>

                    <a href="{{ route('start') }}#cara-kerja" class="inline-flex items-center justify-center backdrop-blur-sm text-white font-bold px-8 py-4 rounded-xl bg-primary-dark hover:bg-primary-darker transition border border-blue-400">
                        Pelajari Prosedur
                    </a>
                </div>

                <div class="mt-12 pt-8 border-t border-white/20 flex flex-wrap justify-center items-center gap-6 opacity-80 text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i> 100% Gratis
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> Privasi Terjaga
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
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
                        class="faq-btn flex items-center justify-between w-full px-6 py-5 text-left outline-none focus:outline-none focus-visible:ring-2 focus-visible:ring-inset transition-all duration-300">
                    <span class="text-lg font-bold text-dark group-hover:text-accent transition-colors duration-300 tracking-tight">
                        ${faq.question}
                    </span>
                    <i class="fa-solid fa-chevron-down text-netral-400 transition-transform duration-300 text-sm"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-6 text-netral-500 leading-relaxed">
                    <div class="pt-4 border-t border-netral-100">
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
                    span.classList.remove('text-accent');
                    span.classList.add('text-dark');
                });
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('border-accent', 'ring-1', 'ring-accent', 'shadow-md');
                });

                // Jika sebelumnya tertutup, buka yang diklik
                if (!isAlreadyOpen) {
                    answer.classList.remove('hidden');
                    parent.classList.add('border-accent', 'ring-1', 'ring-accent', 'shadow-md');
                    questionText.classList.remove('text-dark');
                    questionText.classList.add('text-accent');
                }
            });
        });
    });

</script>
@endpush
