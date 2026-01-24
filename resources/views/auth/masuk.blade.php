<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Masuk | InfoHilang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-focus-custom:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

    </style>
    @livewireStyles
</head>

<body class="min-h-screen flex items-center justify-center relative overflow-hidden bg-slate-50 font-sans">
    <div class="w-full max-w-md glass-card rounded-3xl shadow-2xl p-8 sm:p-10 mx-4 z-10" data-aos="zoom-in" data-aos-duration="600">

        <div class="flex justify-center mb-6">
            <a href="{{ route('start') }}" class="flex items-center gap-2 group">
                <div class="bg-blue-600 p-2 rounded-xl group-hover:rotate-12 transition-transform duration-300">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </div>
                <span class="text-2xl font-black text-slate-800 tracking-tight">Info<span class="text-blue-600">Hilang</span></span>
            </a>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div class="space-y-1">
                <label for="email" class="block text-sm font-bold text-slate-700 ml-1">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl input-focus-custom bg-slate-50/50 text-sm transition-all outline-none" placeholder="nama@email.com" />
                </div>
                @error('email')
                <p class="text-red-500 text-xs mt-1 font-medium italic"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="password" class="block text-sm font-bold text-slate-700 ml-1">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl input-focus-custom bg-slate-50/50 text-sm transition-all outline-none" placeholder="••••••••" />
                </div>
                @error('password')
                <p class="text-red-500 text-xs mt-1 font-medium italic"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs sm:text-sm">
                <label class="flex items-center group cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 bg-orange-600 focus:ring-orange-500/30 cursor-pointer transition-all">
                    <span class="ml-2 text-slate-600 group-hover:text-slate-800 transition-colors">Ingat saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-colors">Lupa Password?</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-[0.98]">
                Masuk Sekarang
            </button>
        </form>

        <div class="my-6 flex items-center">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="px-4 text-slate-400 text-xs font-bold uppercase tracking-widest">Atau</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center gap-3 border py-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition-all group">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 group-hover:scale-110 transition-transform">
            <span class="font-bold text-slate-700 text-sm">Masuk dengan Google</span>
        </a>

        <p class="text-center text-sm text-slate-500 mt-6 font-medium">
            Belum bergabung?
            <a href="{{ route('showRegister') }}" class="text-blue-600 hover:text-blue-700 transition-all border-b-2 border-transparent hover:border-blue-600">Buat Akun Baru</a>
        </p>
    </div>

    @livewireScripts
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });

    </script>
</body>

</html>
