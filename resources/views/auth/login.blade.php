<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Masuk | InfoHilang</title>
    @stack('style')
    @livewireStyles
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
</head>

<body class="min-h-screen flex items-center justify-center relative overflow-hidden bg-netral-50 font-sans">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 sm:p-10 mx-4 z-10" data-aos="zoom-in" data-aos-duration="600">

        <div class="flex justify-center mb-6">
            <a href="{{ route('start') }}" class="flex items-center gap-2 group">
                <div class="bg-primary p-2 rounded-xl group-hover:rotate-12 transition-transform duration-300">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </div>
                <span class="text-2xl font-black text-dark tracking-tight">Info<span class="text-primary">Hilang</span></span>
            </a>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div class="space-y-1">
                <label for="login" class="block text-sm font-bold text-dark ml-1">Username atau Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-netral-400">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" id="login" name="login" required value="{{ old('login') }}" class="w-full pl-10 pr-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="Username atau email" />
                </div>
                @error('login')
                <p class="text-red-500 text-xs mt-1 font-medium italic"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="password" class="block text-sm font-bold text-dark ml-1">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-netral-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required class="w-full pl-10 pr-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none" placeholder="••••••••" />
                </div>
                @error('password')
                <p class="text-red-500 text-xs mt-1 font-medium italic"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs sm:text-sm">
                <label class="flex items-center group cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 bg-primary focus:ring-primary cursor-pointer transition-all">
                    <span class="ml-2 text-slate-600 group-hover:text-dark transition-colors">Ingat saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="font-bold text-primary hover:text-primary-dark transition-colors">Lupa Password?</a>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-[0.98]">
                Masuk Sekarang
            </button>
        </form>

        <div class="my-6 flex items-center">
            <div class="flex-1 h-px bg-netral-300"></div>
            <span class="px-4 text-netral-400 text-xs font-bold uppercase tracking-widest">Atau</span>
            <div class="flex-1 h-px bg-netral-300"></div>
        </div>

        <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center gap-3 border py-3 rounded-xl bg-netral-100 hover:bg-netral-200 transition-all group">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 group-hover:scale-110 transition-transform">
            <span class="font-bold text-dark text-sm">Masuk dengan Google</span>
        </a>

        <p class="text-center text-sm text-netral-500 mt-6 font-medium">
            Belum bergabung?
            <a href="{{ route('showRegister') }}" class="text-primary hover:text-primary-dark transition-all border-b-2 border-transparent hover:border-primary">Buat Akun Baru</a>
        </p>
    </div>

    {{-- Font Awesome --}}
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });
    </script>
    @livewireScripts
</body>
</html>
