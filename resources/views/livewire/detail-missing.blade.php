<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav class="flex mb-6 text-sm text-netral-500" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="/" class="hover:text-primary transition">Beranda</a></li>
            <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i></li>
            <li><a href="{{ route('list-missing') }}" class="hover:text-primary transition">Daftar Hilang</a></li>
            <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i></li>
            <li class="font-semibold text-dark italic">{{ $data['title'] }}</li>
        </ol>
    </nav>

    <div x-data="{ showContactRow: false, showReportModal: false }"
        x-effect="showReportModal ? document.body.classList.add('overflow-hidden') : document.body.classList.remove('overflow-hidden')">
        <div class="flex flex-col lg:flex-row gap-3 mb-3">
            {{-- Foto & Kontak --}}
            <div class="w-full lg:w-5/12">
                <div class="lg:sticky lg:top-24 space-y-3 overflow-hidden">

                    {{-- Media --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-netral-100 overflow-hidden p-3"
                        data-aos="fade-right">
                        @if (is_array($data['image']) && count($data['image']) > 0)
                            <div x-data="{ activeImage: '{{ asset('storage/' . $data['image'][0]) }}' }">
                                <div
                                    class="relative group aspect-square rounded-2xl overflow-hidden bg-netral-100 mb-4">
                                    <img :src="activeImage"
                                        class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    </div>
                                </div>

                                <div class="flex gap-2 px-1 overflow-x-auto pb-2 no-scrollbar">
                                    @foreach ($data['image'] as $foto)
                                        <button @click="activeImage = '{{ asset('storage/' . $foto) }}'"
                                            class="relative flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition-all"
                                            :class="activeImage === '{{ asset('storage/' . $foto) }}' ?
                                                'border-primary ring-2 ring-blue-100' :
                                                'border-transparent opacity-70 hover:opacity-100'">
                                            <img src="{{ asset('storage/' . $foto) }}"
                                                class="w-full h-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div
                                class="aspect-square bg-netral-50 rounded-2xl flex flex-col items-center justify-center border-2 border-dashed border-netral-200">
                                <i class="fa-solid fa-image text-4xl text-netral-300 mb-2"></i>
                                <span class="text-netral-400 text-sm italic">Foto tidak tersedia</span>
                            </div>
                        @endif
                    </div>

                    {{-- Kontak Pelapor --}}
                    <div class="flex items-center gap-3" data-aos="fade-up">
                        @php
                            $kontak = $data['raw']->kontak;

                            // Fungsi helper untuk cek apakah data ada dan bukan "-" atau kosong
                            $isValid = function ($key) use ($kontak) {
                                return isset($kontak[$key]) && $kontak[$key] !== '-' && trim($kontak[$key]) !== '';
                            };

                            // Prioritasin 3 Kontak Utama
                            if ($isValid('Nomor WhatsApp')) {
                                $label = 'WhatsApp';
                                $icon = 'fa-brands fa-whatsapp';
                                $color = 'bg-success';
                                $val = preg_replace('/[^0-9]/', '', $kontak['Nomor WhatsApp']);
                                // 08xxx ke 628xxx
                                $val = str_starts_with($val, '0') ? '62' . substr($val, 1) : $val;
                                $href = 'https://wa.me/' . $val;
                            } elseif ($isValid('Nomor Telepon')) {
                                $label = 'Telepon';
                                $icon = 'fa-solid fa-phone-flip';
                                $color = 'bg-purple-700';
                                $val = preg_replace('/[^0-9]/', '', $kontak['Nomor Telepon']);
                                $href = 'tel:' . $val;
                            } elseif ($isValid('Alamat Email')) {
                                $label = 'Email';
                                $icon = 'fa-solid fa-envelope';
                                $color = 'bg-danger-dark';
                                $href = 'mailto:' . $kontak['Alamat Email'];
                            } else {
                                // Fallback kalau ketiganya tidak ada
                                $label = 'Lihat Kontak';
                                $icon = 'fa-solid fa-address-book';
                                $color = 'bg-accent';
                                $href = '#'; // Diarahkan untuk buka row kontak
                            }
                        @endphp

                        {{-- Kontak prioritas --}}
                        <a href="{{ $href }}" @if ($href !== '#') target="_blank" @endif
                            @if ($href === '#') @click.prevent="
                                    showContactRow = true;
                                    $nextTick(() => {
                                        const el = $refs.contactSection;
                                        if (el) {
                                            const offset = 90;
                                            const elementPosition = el.getBoundingClientRect().top + window.pageYOffset;
                                            const offsetPosition = elementPosition - offset;

                                            window.scrollTo({
                                                top: offsetPosition,
                                                behavior: 'smooth'
                                            });
                                        }
                                    })" @endif
                            class="h-14 flex-1 flex items-center justify-center gap-2 {{ $color }} text-white py-3 rounded-2xl font-bold hover:shadow-lg transition-all active:scale-95">
                            <i class="{{ $icon }} text-lg"></i> {{ $label }}
                        </a>

                        {{-- Print PDF --}}
                        <a href="" target="_blank"
                            class="w-14 h-14 flex items-center justify-center bg-danger text-white rounded-2xl hover:shadow-lg transition-all active:scale-95">
                            <i class="fa-solid fa-file-pdf text-base"></i>
                        </a>

                        {{-- Bagikan --}}
                        <button
                            @click="if (navigator.share) { navigator.share({ title: '{{ $data['title'] }}', url: window.location.href }) }"
                            class="w-14 h-14 flex items-center justify-center bg-dark text-white rounded-2xl hover:shadow-lg transition-all active:scale-95">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>

                    {{-- CTA --}}
                    <div class="p-6 bg-primary rounded-3xl text-white flex flex-col md:flex-row items-center justify-between gap-3"
                        data-aos="fade-up">
                        <div class="text-center md:text-left">
                            <h4 class="text-xl font-bold mb-2">Punya Informasi?</h4>
                            <p class="text-sm">Bantu temukan {{ $data['title'] }} dengan menghubungi
                                pemilik segera.</p>
                        </div>
                        <button
                            @click="
                            showContactRow = true;
                            $nextTick(() => {
                                const el = $refs.contactSection;
                                const offset = 90;
                                const bodyRect = document.body.getBoundingClientRect().top;
                                const elementRect = el.getBoundingClientRect().top;
                                const elementPosition = elementRect - bodyRect;
                                const offsetPosition = elementPosition - offset;

                                window.scrollTo({
                                    top: offsetPosition,
                                    behavior: 'smooth'
                                });
                            })"
                            class="px-3 py-3 bg-white text-primary rounded-2xl font-black shadow-lg hover:scale-105 transition-transform flex items-center justify-center gap-2">
                            <i class="fa-solid fa-phone-flip"></i> Hubungi Pemilik
                        </button>
                    </div>
                </div>
            </div>

            {{-- Detail Informasi --}}
            <div class="w-full lg:w-7/12 space-y-3 overflow-hidden">

                {{-- Informasi atas --}}
                <div class="bg-white rounded-3xl shadow-sm border border-netral-100 p-6" data-aos="fade-left">
                    <div class="mb-0">
                        <div class="flex items-center gap-2 mb-4">
                            {{-- Status menggunakan $data['status'] --}}
                            <span
                                class="px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-full shadow-sm {{ $data['status'] === 'Hilang' ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                {{ $data['status'] }}
                            </span>
                            <span class="text-xs text-netral-400">
                                <i class="fa-regular fa-calendar-check mr-1"></i>
                                Terakhir terlihat:
                                {{ \Carbon\Carbon::parse($data['date'])->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-extrabold text-dark tracking-tight">{{ $data['title'] }}</h1>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 py-6 mb-0">
                        @foreach ($data['grid_info'] as $info)
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-primary">
                                    <i class="fa-solid {{ $info['icon'] }}"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-netral-400 uppercase font-bold tracking-tighter">
                                        {{ $info['label'] }}
                                    </p>
                                    <p class="text-sm font-bold text-dark">
                                        {{ $info['value'] ?? '–' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="">
                        <h3 class="text-sm font-bold text-dark mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-quote-left text-primary"></i> Deskripsi & Kronologi
                        </h3>
                        <div
                            class="prose prose-sm max-w-none text-netral-600 leading-relaxed bg-netral-50 p-5 rounded-2xl border-l-4 border-primary">
                            {!! $data['description'] ?:
                                '<span class="italic text-netral-400">Deskripsi tidak
                                                            dicantumkan.</span>' !!}
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-stretch gap-3">

                    {{-- Detail Khusus --}}
                    <div class="w-full md:w-[40%] bg-white rounded-3xl shadow-sm border border-netral-100 p-6"
                        data-aos="fade-up">
                        <h3 class="font-bold text-dark mb-4 flex items-center gap-2 uppercase text-xs tracking-widest">
                            <i class="fa-solid fa-fingerprint text-primary text-base"></i> Detail Khusus
                        </h3>
                        <div class="space-y-4">
                            @forelse ($data['raw']->ciri_ciri ?? [] as $key => $value)
                                <div class="flex flex-col">
                                    <span
                                        class="text-[10px] text-netral-400 uppercase font-bold">{{ str_replace('_', ' ', $key) }}</span>
                                    <span
                                        class="text-sm text-dark font-medium border-b border-netral-50 pb-1">{{ $value }}</span>
                                </div>
                            @empty
                                <p class="text-xs italic text-netral-400">Informasi tambahan tidak tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Laporan Jejak --}}
                    <div class="w-full md:w-[60%] bg-white rounded-3xl shadow-sm border border-netral-100 p-6 flex flex-col max-h-[540px] h-fit"
                        data-aos="fade-up" data-aos-delay="100">
                        <h3 class="font-bold text-dark mb-4 flex items-center gap-2 uppercase text-xs tracking-widest">
                            <i class="fa-solid fa-map-location-dot text-primary text-base"></i> Laporan Jejak
                        </h3>

                        <div class="relative flex-1 overflow-y-auto mb-4 pr-3 no-scrollbar scroll-smooth">
                            <div class="relative">
                                <div class="absolute left-[19px] top-2 bottom-2 w-0.5 bg-netral-100 -z-0"></div>

                                {{-- Data Dummy --}}
                                @php
                                $riwayatPenemuan = [
                                        (object) [
                                            'nama_pelapor' => 'Rizky Amalia',
                                            'created_at' => '2026-02-10 14:30:00',
                                            'lokasi_detail' => 'Taman Ganesha',
                                            'deskripsi' => 'Ciri-ciri sama.',
                                            'link_bukti' => '#',
                                            'is_verified' => true,
                                        ],
                                        (object) [
                                            'nama_pelapor' => 'Anonim',
                                            'created_at' => '2026-02-11 09:15:00',
                                            'lokasi_detail' => 'Stasiun UI',
                                            'deskripsi' =>
                                                'Dapat kabar dari grup komunitas, katanya ada yang melihat di peron 2. Sudah saya lampirkan foto dari kejauhan.',
                                            'link_bukti' => '#',
                                            'is_verified' => false,
                                        ],
                                        (object) [
                                            'nama_pelapor' => 'Citra',
                                            'created_at' => '2026-02-11 09:15:00',
                                            'lokasi_detail' => 'Stasiun Pondok Cina',
                                            'deskripsi' =>
                                                'Dapat kabar dari grup komunitas, katanya ada yang melihat di peron 2. Sudah saya lampirkan foto dari kejauhan.',
                                            'link_bukti' => '#',
                                            'is_verified' => false,
                                        ],
                                ]; @endphp

                                @forelse ($riwayatPenemuan as $item)
                                    <div class="relative pl-12 group mb-3 last:mb-2">
                                        <div
                                            class="absolute left-0 top-0 w-10 h-10 bg-white border-2 {{ $item->is_verified ? 'border-success shadow-[0_0_15px_rgba(34,197,94,0.3)]' : 'border-netral-100 shadow-sm' }} rounded-2xl shadow-sm flex items-center justify-center z-10 transition-all">
                                            <i
                                                class="text-sm fa-solid {{ $item->is_verified ? 'fa-check-double text-success' : 'fa-location-crosshairs text-primary' }}"></i>
                                        </div>
                                        <div
                                            class="{{ $item->is_verified ? 'bg-success-light' : 'bg-white' }} p-4 rounded-2xl border border-netral-100 shadow-sm hover:shadow-md transition-all">
                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="text-xs font-black text-dark">{{ $item->nama_pelapor }}</span>
                                                    <span class="w-1 h-1 bg-netral-300 rounded-full"></span>
                                                    <span class="text-[10px] text-netral-400 font-bold uppercase">
                                                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                    </span>
                                                </div>

                                                @if ($item->is_verified)
                                                    <div
                                                        class="flex items-center gap-2 px-3 py-1 bg-success text-white text-xs rounded-full shadow-sm shadow-success animate-pulse-slow">
                                                        <i class="fa-solid fa-certificate"></i>
                                                        <span
                                                            class="font-black uppercase tracking-widest">Terkonfirmasi</span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Lokasi Box --}}
                                            <div
                                                class="{{ $item->is_verified ? 'bg-white border-success' : 'bg-netral-50 border-netral-200' }} p-3 rounded-xl border border-dashed mb-3">
                                                <p
                                                    class="text-[10px] {{ $item->is_verified ? 'text-success' : 'text-netral-400' }} uppercase font-bold tracking-tighter mb-1">
                                                    Lokasi Temuan</p>
                                                <p class="text-sm font-bold text-dark italic leading-tight">
                                                    {{ $item->lokasi_detail }}</p>
                                            </div>

                                            {{-- Deskripsi --}}
                                            <p
                                                class="text-xs {{ $item->is_verified ? 'text-dark font-medium' : 'text-netral-500' }} leading-relaxed mb-3">
                                                {{ $item->deskripsi }}
                                            </p>
                                            {{-- Action Buttons --}}
                                            <div class="border-t border-netral-50 flex flex-wrap items-center gap-2">
                                                <a href="{{ $item->link_bukti }}"
                                                    class="inline-flex items-center gap-1 px-2 py-1 {{ $item->is_verified ? 'bg-success hover:bg-success-dark' : 'bg-dark hover:bg-primary' }} text-white text-[10px] font-bold rounded-md transition-all">
                                                    <i class="fa-solid fa-image"></i> Lihat Bukti
                                                </a>

                                                <button
                                                    class="px-2 py-1 bg-netral-100 text-netral-500 text-[10px] font-bold rounded-md hover:bg-danger hover:text-white transition-all">
                                                    <i class="fa-solid fa-flag"></i> Laporkan Hoax
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs italic text-netral-400">Belum ada laporan jejak yang masuk.</p>
                                @endforelse
                            </div>
                        </div>

                        <button @click="showReportModal = true"
                            class="w-full py-4 border-2 border-dashed border-primary bg-primary-light rounded-3xl text-primary font-bold text-sm transition-all flex items-center justify-center gap-3 group">
                            <div
                                class="w-8 h-8 bg-primary text-white rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            Punya Informasi? Laporkan di Sini
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Breakdown Informasi Kontak --}}
        <div x-show="showContactRow" x-ref="contactSection" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0" class="mb-3">
            <div class="bg-white rounded-3xl shadow-sm border border-netral-100 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-dark flex items-center gap-2 uppercase text-xs tracking-widest">
                        <i class="fa-solid fa-address-book text-primary text-base"></i> Opsi Kontak Pemilik
                    </h3>
                    <button @click="showContactRow = false" class="text-netral-400 hover:text-danger">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($data['raw']->kontak as $platform => $value)
                        {{-- Abaikan kalau data kosong atau hanya strip --}}
                        @php
                            if ($value === '-' || empty($value)) {
                                continue;
                            }
                        @endphp

                        <div x-data="{ copied: false }" class="relative">
                            <button
                                @click="
                            navigator.clipboard.writeText('{{ $value }}');
                            copied = true;
                            setTimeout(() => copied = false, 2000);"
                                class="w-full flex items-center gap-4 p-4 bg-white border border-netral-100 rounded-2xl hover:border-primary hover:shadow-md transition-all group overflow-hidden cursor-pointer text-left">
                                {{-- Feedback kalau berhasil copy --}}
                                <div x-show="copied" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    class="absolute inset-0 bg-primary flex items-center justify-center z-20 text-white font-bold text-xs gap-2 rounded-2xl">
                                    <i class="fa-solid fa-copy animate-bounce"></i> Berhasil Disalin!
                                </div>

                                {{-- Icon section --}}
                                <div
                                    class="w-12 h-12 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                    @php
                                        $p = strtolower($platform);
                                        $icon = match (true) {
                                            str_contains($p, 'whatsapp') => 'fa-brands fa-whatsapp',
                                            str_contains($p, 'instagram') => 'fa-brands fa-instagram',
                                            str_contains($p, 'facebook') => 'fa-brands fa-facebook',
                                            str_contains($p, 'twitter') => 'fa-brands fa-x-twitter',
                                            str_contains($p, 'email') => 'fa-solid fa-envelope',
                                            default => 'fa-solid fa-phone',
                                        };
                                    @endphp
                                    <i class="{{ $icon }} text-xl"></i>
                                </div>

                                {{-- Info section --}}
                                <div class="flex-1 overflow-hidden">
                                    <div class="flex items-center justify-between">
                                        <p class="text-[10px] text-netral-400 uppercase font-black tracking-widest">
                                            {{ $platform }}</p>
                                        <i
                                            class="fa-solid fa-clone text-[10px] text-netral-300 group-hover:text-primary transition-colors"></i>
                                    </div>
                                    <p class="text-sm font-bold text-dark truncate">{{ $value }}</p>
                                </div>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Diskusi / Komentar --}}
        <div class="bg-white rounded-3xl shadow-sm border border-netral-100 p-6 md:p-8" data-aos="fade-up">
            <h3 class="font-bold text-dark mb-8 flex items-center gap-2">
                <i class="fa-solid fa-comments text-primary text-xl"></i> Diskusi Laporan
            </h3>
            {{-- Mengarahkan komentar ke model asli melalui $data['raw'] --}}
            @include('dashboard.components.commentars', [
                'model' => $data['raw'],
                'modelName' => get_class($data['raw']),
            ])
        </div>

        {{-- Modal tambah hasil penemuan --}}
        <div x-show="showReportModal"
            class="fixed inset-0 z-[9999] flex items-center justify-center backdrop-blur-md p-4 sm:p-6" x-cloak>

            <div x-show="showReportModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" class="absolute inset-0 backdrop-blur-md"></div>

            <div x-show="showReportModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" @click.away="showReportModal = false"
                class="relative bg-white w-full max-w-4xl max-h-[calc(100dvh-40px)] shadow-2xl flex flex-col border border-netral-100 rounded-xl overflow-hidden">

                {{-- Header --}}
                <div
                    class="p-6 border-b border-netral-50 flex justify-between items-center bg-white sticky top-0 z-10">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-primary-light rounded-2xl flex items-center justify-center text-primary">
                            <i class="fa-solid fa-bullhorn text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl md:text-2xl font-bold text-dark">Kontribusi Informasi Temuan</h2>
                            <p class="text-xs font-medium text-netral-400">Bantu perkuat jejak pencarian untuk
                                {{ $data['title'] }}</p>
                        </div>
                    </div>
                    <button @click="showReportModal = false"
                        class="w-12 h-12 rounded-full hover:bg-netral-100 flex items-center justify-center text-netral-400 transition-all">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                {{-- Body/Form --}}
                <div class="p-6 overflow-y-auto no-scrollbar flex-1 bg-netral-50">
                    <form action="#" class="grid grid-cols-1 md:grid-cols-2 gap-5 items-stretch"
                        x-data="{
                            images: [],
                            handleFiles(event) {
                                const files = Array.from(event.target.files);
                                if (this.images.length + files.length > 3) {
                                    alert('Maksimal hanya 3 gambar yang diperbolehkan.');
                                    return;
                                }
                                files.forEach(file => {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.images.push(e.target.result);
                                    };
                                    reader.readAsDataURL(file);
                                });
                            },
                            removeImage(index) {
                                this.images.splice(index, 1);
                            }
                        }">

                        {{-- Nama & Kontak Penemu --}}
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-dark mb-2">
                                    Nama Penemu <span class="text-danger">*</span>
                                </label>
                                <input type="text" required name="nama_penemu"
                                    placeholder="Masukkan nama lengkap Anda"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-white text-sm transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-dark mb-2">
                                    Kontak Penemu (WhatsApp/No. HP) <span class="text-danger">*</span>
                                </label>
                                <input type="text" required name="kontak_penemu" placeholder="Contoh: 08123456789"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-white text-sm transition-all outline-none">
                            </div>
                        </div>

                        {{-- Informasi Lokasi & Detail/Deksripsi --}}
                        <div class="flex flex-col h-full space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-dark mb-2">
                                    Informasi Lokasi <span class="text-danger">*</span>
                                </label>
                                <div class="relative group">
                                    <input type="text"
                                        placeholder="Di mana kamu melihatnya? (Misal: Lobby Utama Mall X)"
                                        class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-white text-sm transition-all outline-none">
                                </div>
                            </div>

                            <div class="flex-1 flex flex-col">
                                <label class="block text-xs font-bold text-dark mb-2">Detail Kronologi &
                                    Deskripsi</label>
                                <textarea rows="5"
                                    placeholder="Jelaskan kondisi terakhir yang terlihat (pakaian, arah pergi, atau kondisi barang)..."
                                    class="flex-1 w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-white text-sm transition-all outline-none"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col h-full space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-dark mb-2">
                                    Unggah Bukti Foto (Maks. 3) (Opsional) <span class="text-netral-400 font-normal"
                                        x-text="`(${images.length}/3)`"></span>
                                </label>

                                {{-- Dropzone Area --}}
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed rounded-xl transition-all group"
                                        :class="images.length >= 3 ?
                                            'bg-netral-100 border-netral-200 cursor-not-allowed' :
                                            'bg-white border-netral-200 cursor-pointer hover:border-primary'">
                                        <div class="flex items-center gap-3">
                                            {{-- Container Icon --}}
                                            <div class="rounded-2xl flex items-center justify-center transition-all shrink-0"
                                                :class="images.length < 3 ? 'group-hover:scale-110' : ''">
                                                <i class="fa-solid fa-cloud-arrow-up text-2xl transition-colors"
                                                    :class="images.length >= 3 ? 'text-netral-300 group-hover:text-netral-300' :
                                                        'text-netral-400 group-hover:text-primary'"></i>
                                            </div>

                                            {{-- Text section --}}
                                            <div class="flex flex-col">
                                                {{-- Teks Utama --}}
                                                <p class="text-xs font-bold tracking-tight transition-colors"
                                                    :class="images.length >= 3 ? 'text-netral-400' : 'text-netral-500'">
                                                    <span
                                                        x-text="images.length >= 3 ? 'Batas maksimal foto tercapai' : 'Klik untuk unggah atau seret foto'"></span>
                                                </p>
                                                {{-- Teks Format --}}
                                                <p class="text-[10px] mt-0.5 uppercase font-bold transition-colors"
                                                    :class="images.length >= 3 ? 'text-netral-300' : 'text-netral-400'">
                                                    PNG, JPG (Max. 5MB)
                                                </p>
                                            </div>
                                        </div>
                                        <input type="file" class="hidden" accept="image/*" multiple
                                            @change="handleFiles($event)" :disabled="images.length >= 3" />
                                    </label>
                                </div>

                                {{-- Preview Container --}}
                                <div class="flex flex-wrap gap-2 mt-3" x-show="images.length > 0">
                                    <template x-for="(img, index) in images" :key="index">
                                        <div
                                            class="relative w-14 h-14 rounded-lg overflow-hidden group border border-netral-100 shadow-sm shrink-0">
                                            <img :src="img" class="w-full h-full object-cover">

                                            {{-- Tombol Hapus --}}
                                            <button @click.prevent="removeImage(index)"
                                                class="absolute inset-0 bg-danger-light text-white opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="px-5 py-3 rounded-2xl border bg-white">
                                <div class="flex gap-3 items-start text-primary">
                                    <i class="fa-solid fa-circle-info mt-1"></i>
                                    <p class="text-[10px] font-bold leading-relaxed">
                                        Informasi yang kamu kirim akan muncul di timeline publik setelah divalidasi oleh
                                        pemilik atau admin.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit"
                                class="w-full py-3 bg-primary text-white rounded-xl font-bold shadow-xl hover:bg-primary-dark hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3">
                                Kirim Laporan Temuan <i class="fa-solid fa-paper-plane"></i>
                            </button>
                            <p class="text-center text-[10px] text-netral-400 mt-4 font-medium italic">
                                *Dengan mengirim, kamu setuju untuk memberikan informasi yang jujur dan bertanggung
                                jawab.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
