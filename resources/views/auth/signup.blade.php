<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daftar | InfoHilang</title>
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

    <!-- Register Card -->
    <div class="w-full max-w-md bg-secondary rounded-2xl shadow-xl p-6 sm:p-8 mx-4" data-aos="zoom-in"
        data-aos-duration="800">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary">Daftar <span class="text-highlight">InfoHilang</span></h1>
            <p class="text-gray-600 mt-2 text-sm sm:text-base">Buat akun untuk melaporkan atau menemukan sesuatu</p>
        </div>

        <!-- Register Form -->
        <form action="" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                <input type="text" id="firstname" name="firstname" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus"
                    placeholder="Masukkan nama depan Anda" />
                @error('firstname')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                <input type="text" id="lastname" name="lastname" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus"
                    placeholder="Masukkan nama belakang Anda" />
                @error('lastname')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

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

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata
                    Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus"
                    placeholder="Konfirmasi kata sandi" />
                @error('password_confirmation')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Daftar
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('showLogin') }}" class="text-primary hover:underline">Masuk Sekarang</a>
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
