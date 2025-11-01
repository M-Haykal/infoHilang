<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Masuk | InfoHilang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, var(--primary) 0%, #4dabf7 100%);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 136, 229, 0.2);
        }

        .btn-social {
            transition: background-color 0.3s ease;
        }

        .btn-social:hover {
            background-color: var(--accent);
        }
    </style>
    @livewireStyles
</head>

<body class="min-h-screen flex items-center justify-center font-sans bg-gradient-custom relative overflow-hidden">
    <!-- Background Decorations -->
    <div class="absolute top-[-80px] left-[-80px] w-64 h-64 bg-highlight opacity-20 rounded-full blur-3xl md:w-80 md:h-80"
        data-aos="fade-in" data-aos-delay="100"></div>
    <div class="absolute bottom-[-100px] right-[-100px] w-72 h-72 bg-success opacity-20 rounded-full blur-3xl md:w-96 md:h-96"
        data-aos="fade-in" data-aos-delay="200"></div>

    <!-- Login Card -->
    <div class="w-full max-w-md bg-secondary rounded-2xl shadow-xl p-6 sm:p-8 mx-4" data-aos="zoom-in"
        data-aos-duration="800">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary">Info<span class="text-highlight">Hilang</span></h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Masuk untuk melaporkan atau menemukan sesuatu</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus"
                    placeholder="Masukkan email Anda" />
                @error('email')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus"
                    placeholder="Masukkan kata sandi" />
                @error('password')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm gap-2">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="text-primary focus:ring-primary rounded">
                    <span class="text-gray-600">Ingat saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-primary hover:underline">Lupa kata sandi?</a>
            </div>

            <button type="submit"
                class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Masuk
            </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center">
            <hr class="flex-1 border-gray-300">
            <span class="px-3 text-gray-500 text-sm">atau</span>
            <hr class="flex-1 border-gray-300">
        </div>

        <!-- Social Login -->
        <div class="space-y-3">
            <a href="{{ route('google.redirect') }}"
                class="w-full flex items-center justify-center gap-2 border border-gray-300 py-2 rounded-lg btn-social">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                <span class="font-medium text-gray-700">Masuk dengan Google</span>
            </a>
            <a href="#"
                class="w-full flex items-center justify-center gap-2 border border-gray-300 py-2 rounded-lg btn-social">
                <img src="https://www.svgrepo.com/show/452115/telegram.svg" alt="Telegram" class="w-5 h-5">
                <span class="font-medium text-gray-700">Masuk dengan Telegram</span>
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Belum punya akun?
            <a href="{{ route('showRegister') }}" class="text-primary hover:underline">Daftar Sekarang</a>
        </p>
    </div>

    @livewireScripts
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out',
            once: true
        });
    </script>
</body>

</html>
