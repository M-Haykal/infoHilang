<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="user-id" content="{{ Auth::user()->id }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('style')
</head>

<body class="bg-accent font-sans min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside
            class="bg-white shadow-lg transition-all duration-300 ease-in-out fixed md:static inset-y-0 left-0 z-50 w-20 md:w-64">
            <div class="p-4 flex items-center justify-between border-b">
                <h1 class="text-xl font-bold text-primary md:block hidden">Info<span
                        class="text-highlight">Hilang</span>
                </h1>
                <button class="md:hidden p-2 rounded-full hover:bg-gray-200" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
            <nav class="py-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-accent rounded-lg transition-colors ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0l-2-2m2 2V4a1 1 0 00-1-1h-3a1 1 0 00-1 1z" />
                            </svg>
                            <span class="text-gray-700 md:block hidden">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('missing') }}"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-accent rounded-lg transition-colors ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="text-gray-700 md:block hidden">Hilang</span>
                        </a>
                    </li>
                    <li>
                        <a href="#!"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-accent rounded-lg transition-colors ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-gray-700 md:block hidden">Penemu</span>
                        </a>
                    </li>

                    {{-- 🔔 Chat menu dengan badge notifikasi --}}
                    <li class="relative">
                        <a href="{{ url('Chat') }}"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-accent rounded-lg transition-colors relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.013 8.013 0 01-8-8c0-2.21.895-4.208 2.342-5.518L12 2l4.658 4.482A7.993 7.993 0 0120 12z" />
                            </svg>
                            <span class="text-gray-700 md:block hidden">Chat</span>

                            <span id="chat-badge"
                                class="absolute top-1 right-3 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
                                style="display:none;">0</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-y-auto">
            <!-- Mobile Menu Toggle -->
            <div class="md:hidden flex justify-between items-center mb-4">
                <h1 class="text-xl font-bold text-gray-800">InfoHilang</h1>
                <button onclick="toggleSidebar()" class="p-2 rounded-full hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>

            <section class="m-4">
                @yield('content')
            </section>
        </main>
    </div>

    <!-- Pusher Real-time Notification -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- Leaflet Maps -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/qmsq1hga0tygul287yejg9t6gpfa5npa36c0ezchh4zom7x1/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('w-64');
        }

        Pusher.logToConsole = false;

        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        });

        const userId = "{{ Auth::id() }}";
        const channel = pusher.subscribe('private-chatify.' + userId);

        channel.bind('messaging', function(data) {
            if (data.from_id != userId) {
                const badge = document.getElementById('chat-badge');
                let count = parseInt(badge.textContent) || 0;
                badge.textContent = count + 1;
                badge.style.display = 'inline-flex';
            }
        });

        if (window.location.href.includes('/Chat')) {
            const badge = document.getElementById('chat-badge');
            if (badge) {
                badge.textContent = '0';
                badge.style.display = 'none';
            }
        }
    </script>

    @stack('script')
</body>

</html>
