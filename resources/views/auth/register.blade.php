<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daftar | InfoHilang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    @livewireStyles
</head>

<body class="min-h-screen flex items-center justify-center relative bg-netral-50 font-sans">
    <!-- Register Card -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 sm:p-10 mx-4 z-10" data-aos="zoom-in" data-aos-duration="600">

        <!-- Header -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('start') }}" class="flex items-center gap-2 group">
                <div class="bg-primary p-2 rounded-xl group-hover:rotate-12 transition-transform duration-300">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </div>
                <span class="text-2xl font-black text-dark tracking-tight">Info<span class="text-primary">Hilang</span></span>
            </a>
        </div>

        <!-- Register Form -->
        <form action="" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Depan & Belakang --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="space-y-1">
                    <label for="firstname" class="block text-sm font-bold text-dark ml-1">Nama Depan</label>
                    <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" required
                        class="w-full pl-4 pr-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                        placeholder="John" />
                    @error('firstname')
                        <p class="text-danger text-xs mt-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="lastname" class="block text-sm font-bold text-dark ml-1">Nama Belakang</label>
                    <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required
                        class="w-full pl-4 pr-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                        placeholder="Doe" />
                    @error('lastname')
                        <p class="text-danger text-xs mt-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="space-y-1">
                <label for="email" class="block text-sm font-bold text-dark ml-1">Email</label>
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full pl-4 pr-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                        placeholder="nama@email.com" />
                </div>
                @error('email')
                    <p class="text-danger text-xs mt-1 font-medium italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="space-y-1">
                <label for="password" class="block text-sm font-bold text-dark ml-1">Kata Sandi</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full pl-4 pr-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                        placeholder="Masukkan kata sandi" />
                </div>
                @error('password')
                    <p class="text-danger text-xs mt-1 font-medium italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="space-y-1">
                <label for="password_confirmation" class="block text-sm font-bold text-dark ml-1">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full pl-4 pr-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none"
                        placeholder="Konfirmasi kata sandi" />
                </div>
                @error('password_confirmation')
                    <p class="text-danger text-xs mt-1 font-medium italic">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-[0.98]">
                Daftar
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-sm text-netral-500 mt-6 font-medium">
            Sudah punya akun?
            <a href="{{ route('showLogin') }}" class="text-primary hover:text-primary-dark transition-all border-b-2 border-transparent hover:border-primary">Masuk Sekarang</a>
        </p>
    </div>

    @livewireScripts
    {{-- Font Awesome --}}
    <script src="{{ asset('js/all.min.js') }}"></script>
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
