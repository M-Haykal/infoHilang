<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    @vite(['resources/css/app.css'])
    @stack('style')
</head>

<body class="bg-netral-50 font-sans min-h-screen">
    @include('components.loading')
    <div class="flex min-h-screen relative">
        <div class="lg:hidden fixed left-0 top-0 z-40 p-4 w-fit pointer-events-none">
            <button onclick="toggleSidebar()"
                class="pointer-events-auto flex items-center justify-center w-12 h-12 bg-white backdrop-blur shadow-2xl rounded-2xl text-primary border border-slate-100 active:scale-95 transition-all">
                <i class="fa-solid fa-bars-staggered text-xl"></i>
            </button>
        </div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="flex flex-col fixed inset-y-0 left-0 z-[1000] w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 lg:static lg:translate-x-0 lg:w-64 lg:z-auto pointer-events-none lg:pointer-events-auto overflow-hidden">
            <div class="flex flex-col h-full w-full pointer-events-auto bg-white">
                <div class="p-4 flex items-center justify-between border-b">
                    <a href="{{ route('start') }}" class="flex items-center gap-2 group">
                        <div class="bg-primary p-2 rounded-xl">
                            <i class="fa-solid fa-magnifying-glass text-white"></i>
                        </div>
                        <span class="text-2xl font-black text-dark tracking-tight">Info<span
                                class="text-primary">Hilang</span></span>
                    </a>
                    <div class="button-action">
                        <button class="p-2 rounded-full hover:bg-netral-200 lg:block hidden"
                            onclick="toggleFullScreen()" id="fullscreen-button" title="Memperluas Tampilan"><i
                                class="fa-solid fa-expand text-dark"></i></button>
                        <button class="lg:hidden p-2 rounded-full hover:bg-netral-200" onclick="toggleSidebar()">
                            <i class="fa-solid fa-angle-left text-dark"></i>
                        </button>
                    </div>
                </div>
                <nav class="py-4 overflow-y-auto flex-1">
                    <ul class="space-y-2 px-2">

                        @if(auth()->user()->hasRole('admin'))
                            {{-- Menu Sidebar Untuk Admin --}}
                            @php
                                $adminMenus = [
                                    ['route' => 'admin.dashboard', 'icon' => 'fa-solid fa-gauge-high', 'label' => 'Dashboard Admin'],
                                    ['route' => 'admin.report', 'icon' => 'fa-solid fa-list-check', 'label' => 'Kelola Laporan'],
                                    ['route' => 'admin.users', 'icon' => 'fa-solid fa-users', 'label' => 'Manajemen User'],
                                    ['route' => 'admin.settings', 'icon' => 'fa-solid fa-gear', 'label' => 'Pengaturan Sistem'],
                                ];
                            @endphp

                            @foreach ($adminMenus as $menu)
                                @php
                                    $isActive = request()->routeIs($menu['route'] . '*');
                                @endphp

                                <li>
                                    <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#!' }}"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group relative {{ $isActive ? 'text-primary font-bold' : 'text-dark hover:text-primary hover:bg-slate-50' }}">

                                        <i
                                            class="{{ $menu['icon'] }} text-lg transition-all duration-200 {{ $isActive ? 'text-primary' : 'text-dark group-hover:text-primary' }}">
                                        </i>

                                        <span class="tracking-wide">{{ $menu['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach

                        @else
                            {{-- Menu Sidebar Untuk User Biasa --}}
                            @php
                                $menus = [
                                    ['route' => 'dashboard', 'icon' => 'fa-solid fa-gauge-high', 'label' => 'Dashboard'],
                                    ['route' => 'missing', 'icon' => 'fa-solid fa-archive', 'label' => 'Daftar Laporan'],
                                    ['route' => 'found', 'icon' => 'fa-regular fa-flag', 'label' => 'Penemu'],
                                    ['route' => 'artikel', 'icon' => 'fa-regular fa-newspaper', 'label' => 'Artikel'],
                                    ['route' => 'settings', 'icon' => 'fa-solid fa-gear', 'label' => 'Pengaturan'],
                                ];
                            @endphp

                            @foreach ($menus as $menu)
                                @php
                                    $isActive = false;

                                    // pengecekan URL aktif
                                    if ($menu['route'] == 'dashboard') {
                                        $isActive = request()->is('user/dashboard*') || request()->is('user/form-*');
                                    } elseif ($menu['route'] == 'missing') {
                                        $isActive =
                                            request()->is('user/hilang*') ||
                                            request()->is('user/edit-laporan*') ||
                                            request()->is('user/detail-laporan*');
                                    } elseif ($menu['route'] == 'artikel') {
                                        $isActive = request()->is('user/artikel*');
                                    } elseif ($menu['route'] == 'found') {
                                        $isActive = request()->is('user/laporan-penemuan*');
                                    } else {
                                        $isActive = request()->routeIs($menu['route'] . '*');
                                    }
                                @endphp

                                <li>
                                    <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#!' }}"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group relative {{ $isActive ? 'text-primary font-bold' : 'text-dark hover:text-primary hover:bg-slate-50' }}">

                                        <i
                                            class="{{ $menu['icon'] }} text-lg transition-all duration-200 {{ $isActive ? 'text-primary' : 'text-dark group-hover:text-primary' }}">
                                        </i>

                                        <span class="tracking-wide">{{ $menu['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </nav>
                <div class="p-4 border-t border-netral-100 relative group">
                    <div id="user-dropdown"
                        class="absolute bottom-[calc(100%-0.3rem)] left-4 right-4 mb-3 w-[calc(100%-2rem)] bg-white rounded-2xl shadow-xl border border-netral-100 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 z-[9999] overflow-hidden">

                        <div class="p-2">
                            <a href="{{ route('start') }}"
                                class="flex items-center gap-3 px-3 py-2 text-sm text-dark hover:bg-primary-light hover:text-primary rounded-xl transition-all duration-200">
                                <i class="fa-solid fa-house"></i>
                                Ke Halaman Utama
                            </a>
                            <div class="my-2 border-t border-netral-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full gap-3 px-3 py-2 font-bold text-sm text-danger hover:bg-danger-light rounded-xl transition-all duration-200">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                    <button
                        class="flex items-center w-full gap-3 p-2 rounded-xl hover:bg-netral-50 transition-all duration-200">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->fullname) . '&background=ea580c&color=fff' }}"
                            class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" alt="Avatar">

                        <div class="flex-1 text-left min-w-0">
                            <p class="text-sm font-bold text-dark truncate">{{ Auth::user()->fullname }}</p>
                            <p class="text-[10px] text-netral-400 font-medium uppercase">{{ Auth::user()->role }}</p>
                        </div>

                        <i
                            class="fa-solid fa-chevron-up text-[10px] text-netral-400 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                </div>
            </div>
        </aside>

        <div id="sidebar-overlay" onclick="toggleSidebar()"
            class="fixed inset-0 bg-black/50 z-[999] hidden lg:hidden transition-opacity duration-300">
        </div>

        <!-- Main Content -->
        <main class="flex-1 h-screen overflow-y-auto" id="main-content">
            <section class="p-6 pt-7">
                @yield('content')
            </section>
        </main>
    </div>
    @include('dashboard.components.alerts')

    @vite(['resources/js/app.js'])

    <!-- Pusher Real-time Notification -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- Leaflet Maps -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer src="{{ asset('js/dashboard/sidebar.js') }}"></script>
    <script defer src="{{ asset('js/dashboard/dashboard.js') }}"></script>
    <script defer src="{{ asset('js/contact-selector.js') }}"></script>

    <script>
        // expose current authenticated user info for selector logic
        window.currentUserId = {{ auth()->id() ?? 'null' }};
        window.currentUserName = @json(optional(auth()->user())->name);
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.2/dist/cdn.min.js"></script>

    @stack('script')

    <script>
        document.querySelectorAll('#check-duplicate-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const type = this.dataset.type;
                const resultDiv = document.getElementById('duplicate-result');
                const form = this.closest('form');

                resultDiv.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                        <span class="font-medium text-netral-600">AI Gemini sedang menganalisis data...</span>
                    </div>
                `;
                resultDiv.className =
                'mt-8 p-6 bg-white border border-netral-200 rounded-2xl shadow-sm';
                resultDiv.classList.remove('hidden');

                this.disabled = true;
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Mengecek...';

                const formData = new FormData(form);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content');

                try {
                    const response = await fetch(`/user/check-duplicate/${type}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.isDuplicate) {
                        resultDiv.className =
                            'mt-8 p-6 bg-red-50 border border-red-200 rounded-2xl shadow-sm';
                        let html = `
                            <div class="flex items-start gap-4">
                                <div class="bg-red-500 p-3 rounded-xl text-white">
                                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-red-900 font-bold text-lg">Waspada! Laporan Duplikat Terdeteksi</h4>
                                    <p class="text-red-700 mt-1">Kami menemukan laporan yang sangat mirip (<strong>${data.similarity}%</strong>) dengan data yang baru saja kamu masukkan.</p>
                                    <p class="text-red-800 mt-3 italic text-sm font-medium">" ${data.reason} "</p>
                        `;

                        if (data.existing_report) {
                            html += `
                                <div class="mt-4 pt-4 border-t border-red-200">
                                    <p class="text-sm text-red-600 mb-2">Laporan yang mirip:</p>
                                    <a href="${data.existing_report.url}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors font-bold text-sm">
                                        <i class="fa-solid fa-eye"></i>
                                        Lihat Laporan: ${data.existing_report.name}
                                    </a>
                                </div>
                            `;
                        }

                        html += `</div></div>`;
                        resultDiv.innerHTML = html;
                    } else if (data.similarity >= 50) {
                        resultDiv.className =
                            'mt-8 p-6 bg-yellow-50 border border-yellow-200 rounded-2xl shadow-sm';
                        resultDiv.innerHTML = `
                            <div class="flex items-start gap-4">
                                <div class="bg-yellow-500 p-3 rounded-xl text-white">
                                    <i class="fa-solid fa-circle-info text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-yellow-900 font-bold text-lg">Ditemukan Sedikit Kemiripan</h4>
                                    <p class="text-yellow-700 mt-1">Kemiripan terdeteksi sekitar <strong>${data.similarity}%</strong>. Pastikan data kamu akurat.</p>
                                    <p class="text-yellow-800 mt-2 text-sm italic">" ${data.reason} "</p>
                                </div>
                            </div>
                        `;
                    } else {
                        resultDiv.className =
                            'mt-8 p-6 bg-green-50 border border-green-200 rounded-2xl shadow-sm';
                        resultDiv.innerHTML = `
                            <div class="flex items-start gap-4">
                                <div class="bg-green-500 p-3 rounded-xl text-white">
                                    <i class="fa-solid fa-circle-check text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-green-900 font-bold text-lg">Data Aman!</h4>
                                    <p class="text-green-700 mt-1">Gemini AI tidak mencatat adanya kemiripan signifikan dengan laporan lain.</p>
                                    <p class="text-green-600 text-xs mt-2 uppercase font-bold tracking-wider">Skor Kemiripan: ${data.similarity}%</p>
                                </div>
                            </div>
                        `;
                    }
                } catch (err) {
                    console.error(err);
                    resultDiv.className =
                        'mt-8 p-6 bg-red-50 border border-red-200 rounded-2xl shadow-sm text-red-700';
                    resultDiv.innerHTML =
                        `<i class="fa-solid fa-circle-xmark mr-2"></i>Terjadi kesalahan sistem saat menghubungi AI Gemini.`;
                } finally {
                    this.disabled = false;
                    this.innerHTML = originalText;
                    resultDiv.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });
    </script>
</body>

</html>
