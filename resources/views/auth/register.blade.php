<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register | InfoHilang</title>
</head>

<body
    class="min-h-screen flex items-center justify-center font-sans bg-gradient-to-br from-primary via-blue-500 to-accent relative overflow-hidden">

    <!-- Background Ornaments -->
    <div class="absolute top-[-100px] left-[-100px] w-72 h-72 bg-highlight opacity-20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-120px] right-[-120px] w-80 h-80 bg-success opacity-20 rounded-full blur-3xl"></div>

    <div class="w-full max-w-md bg-secondary rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary">Daftar <span class="text-highlight">InfoHilang</span></h1>
            <p class="text-gray-600 mt-1">Buat akun untuk melaporkan atau menemukan sesuatu</p>
        </div>

        <!-- Register Form -->
        <form action="" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
            </div>

            <button type="submit"
                class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Daftar
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun?
            <a href="" class="text-primary hover:underline">Masuk Sekarang</a>
        </p>
    </div>

</body>

</html>
