<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.default.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    @vite(['resources/css/app.css'])
    @stack('style')
</head>

<body class="bg-accent font-sans min-h-screen">
    @include('components.loading')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-secondary shadow-lg w-20 md:w-64 h-screen sticky top-0 flex flex-col">
            <div class="p-4 flex items-center justify-between border-b">
                <a href="{{ route('start') }}">
                    <h1 class="text-xl font-bold text-primary md:block hidden">Info<span
                            class="text-highlight">Hilang</span>
                    </h1>
                </a>
                <button class="md:hidden p-2 rounded-full hover:bg-gray-200" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <nav class="py-4 overflow-y-auto flex-1">
                <ul class="space-y-2 px-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-accent rounded-lg transition-colors ">
                            <i class="fa-regular fa-house"></i>
                            <span class="text-gray-700 md:block hidden">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('missing') }}"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-accent rounded-lg transition-colors ">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span class="text-gray-700 md:block hidden">Hilang</span>
                        </a>
                    </li>
                    <li>
                        <a href="#!"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-accent rounded-lg transition-colors ">
                            <i class="fa-regular fa-flag"></i>
                            <span class="text-gray-700 md:block hidden">Penemu</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 overflow-y-auto">
            <!-- Mobile Menu Toggle -->
            <div class="md:hidden flex justify-between items-center mb-4 bg-secondary shadow">
                <h1 class="text-xl font-bold text-gray-800">InfoHilang</h1>
                <button onclick="toggleSidebar()" class="p-2 rounded-full hover:bg-gray-200">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <section class="m-4">
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
    <script src="https://cdn.tiny.cloud/1/qmsq1hga0tygul287yejg9t6gpfa5npa36c0ezchh4zom7x1/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer src="{{ asset('js/dashboard.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>

    @stack('script')

    <script>
        document.getElementById('check-duplicate-btn')?.addEventListener('click', async function() {
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
