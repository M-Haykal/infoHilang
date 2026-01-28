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
        <div class="lg:hidden fixed inset-x-0 top-0 z-40 p-4">
            <button onclick="toggleSidebar()" class="flex items-center justify-center w-12 h-12 bg-white backdrop-blur shadow-2xl rounded-2xl text-primary border border-slate-100 active:scale-95 transition-all">
                <i class="fa-solid fa-bars-staggered text-xl"></i>
            </button>
        </div>

        <!-- Sidebar -->
        <aside id="sidebar" class="flex flex-col overflow-visible fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 lg:static lg:translate-x-0 lg:w-64 lg:z-auto">
            <div class="p-4 flex items-center justify-between border-b">
                <a href="{{ route('start') }}" class="flex items-center gap-2 group">
                    <div class="bg-primary p-2 rounded-xl">
                        <i class="fa-solid fa-magnifying-glass text-white"></i>
                    </div>
                    <span class="text-2xl font-black text-dark tracking-tight">Info<span class="text-primary">Hilang</span></span>
                </a>
                <div class="button-action">
                    <button class="p-2 rounded-full hover:bg-netral-200 lg:block hidden" onclick="toggleFullScreen()" id="fullscreen-button" title="Memperluas Tampilan"><i class="fa-solid fa-expand text-dark"></i></button>
                    <button class="lg:hidden p-2 rounded-full hover:bg-netral-200" onclick="toggleSidebar()">
                        <i class="fa-solid fa-angle-left text-dark"></i>
                    </button>
                </div>
            </div>
            <nav class="py-4 overflow-y-auto flex-1">
                <ul class="space-y-2 px-2">
                    @php
                    $menus = [
                    ['route' => 'dashboard', 'icon' => 'fa-solid fa-gauge-high', 'label' => 'Dashboard'],
                    ['route' => 'missing', 'icon' => 'fa-solid fa-magnifying-glass', 'label' => 'Hilang'],
                    ['route' => 'found', 'icon' => 'fa-regular fa-flag', 'label' => 'Penemu'],
                    ['route' => 'blog', 'icon' => 'fa-regular fa-newspaper', 'label' => 'Blog'],
                    ['route' => 'settings', 'icon' => 'fa-solid fa-gear', 'label' => 'Pengaturan'],
                    ];
                    @endphp
                    @foreach($menus as $menu)
                    <li>
                        <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#!' }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group relative {{ request()->routeIs($menu['route']) ? 'text-primary font-bold' : 'text-dark hover:text-primary hover:bg-slate-50' }}">

                            <i class="{{ $menu['icon'] }} text-lg transition-all duration-200 {{ request()->routeIs($menu['route']) ? 'text-primary' : 'text-dark group-hover:text-primary' }}">
                            </i>

                            <span class="tracking-wide">{{ $menu['label'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </nav>
            <div class="p-4 border-t border-netral-100 relative" x-data="{ open: false }">
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="fixed z-[9999] w-56 overflow-hidden bg-white rounded-2xl shadow-xl border border-netral-100" :style="`left: ${$el.parentElement.getBoundingClientRect().left + 16}px;
                 bottom: ${window.innerHeight - $el.parentElement.getBoundingClientRect().top + 8}px;`" x-cloak>

                    <a href="{{ route('start') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-dark hover:bg-primary-light hover:text-primary transition-all duration-200">
                        <i class="fa-solid fa-house"></i>
                        Back to Landing
                    </a>

                    <div class="border-t border-netral-100"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center w-full gap-3 px-4 py-3 text-sm text-danger hover:bg-danger-light transition-all duration-200">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Keluar
                        </button>
                    </form>
                </div>

                <button @click="open = !open" class="flex items-center w-full gap-3 p-2 rounded-xl hover:bg-netral-50 transition-all duration-200">

                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->fullname) . '&background=ea580c&color=fff' }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" alt="Avatar">
                    <div class="flex-1 text-left min-w-0">
                        <p class="text-sm font-bold text-dark truncate">{{  Auth::user()->fullname }}</p>
                        <p class="text-[10px] text-netral-400 font-medium uppercase">{{  Auth::user()->role }}</p>
                    </div>
                    <i class="fa-solid fa-chevron-up text-[10px] text-netral-400 transition-transform"></i>
                </button>
            </div>
        </aside>

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

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/qmsq1hga0tygul287yejg9t6gpfa5npa36c0ezchh4zom7x1/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer src="{{ asset('js/dashboard.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>

    @stack('script')

    <script>
        document.getElementById('check-duplicate-btn') ? .addEventListener('click', async function() {
            const btn = this;
            const type = btn.dataset.type; // orang | hewan | barang
            const resultDiv = document.getElementById('duplicate-result');

            resultDiv.innerHTML = '';
            resultDiv.classList.add('hidden');
            btn.disabled = true;
            btn.innerHTML = 'Mengecek AI...';

            const formData = new FormData(btn.closest('form'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(`/user/check-duplicate/${type}`, {
                    method: 'POST'
                    , body: formData
                    , headers: {
                        'X-CSRF-TOKEN': csrfToken
                        , 'X-Requested-With': 'XMLHttpRequest'
                        , 'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.isDuplicate) {
                    resultDiv.className =
                        'mt-8 p-6 bg-red-100 border-l-4 border-red-600 text-red-800 rounded-r-xl shadow-lg';
                    resultDiv.innerHTML =
                        `<p class="font-bold text-xl">Duplikat Terdeteksi!</p><p>Kemiripan: <strong>${data.similarity}%</strong> — ${data.reason}</p>`;
                } else if (data.similarity > 70) {
                    resultDiv.className =
                        'mt-8 p-6 bg-yellow-100 border-l-4 border-yellow-600 text-yellow-800 rounded-r-xl shadow-lg';
                    resultDiv.innerHTML =
                        `<p class="font-bold text-xl">Peringatan!</p><p>Kemiripan: ${data.similarity}% — ${data.reason}</p>`;
                } else {
                    resultDiv.className =
                        'mt-8 p-6 bg-green-100 border-l-4 border-green-600 text-green-800 rounded-r-xl shadow-lg';
                    resultDiv.innerHTML =
                        `<p class="font-bold text-xl">Aman!</p><p>Tidak ada duplikat. Kemiripan tertinggi: ${data.similarity}%.</p>`;
                }

                resultDiv.classList.remove('hidden');

            } catch (err) {
                console.error(err);
                resultDiv.className =
                    'mt-8 p-6 bg-gray-100 border-l-4 border-gray-600 text-gray-800 rounded-r-xl';
                resultDiv.innerHTML = '<p class="font-bold">Gagal! Cek console (F12)</p>';
                resultDiv.classList.remove('hidden');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Cek Duplikat dengan AI';
            }
        });

    </script>
</body>

</html>
