<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login | InfoHilang</title>
</head>

<body
    class="min-h-screen flex items-center justify-center font-sans bg-gradient-to-br from-primary via-blue-500 to-accent relative overflow-hidden">

    <!-- Background Circles -->
    <div class="absolute top-[-100px] left-[-100px] w-72 h-72 bg-highlight opacity-20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-120px] right-[-120px] w-80 h-80 bg-success opacity-20 rounded-full blur-3xl"></div>

    <div class="w-full max-w-md bg-secondary rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-primary">Info<span class="text-highlight">Hilang</span></h1>
            <p class="text-gray-600 mt-1">Masuk untuk melaporkan atau menemukan sesuatu</p>
        </div>

        <!-- Login Form -->
        <form action="" method="POST" class="space-y-5">
            @csrf
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

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="text-primary focus:ring-primary">
                    <span>Ingat saya</span>
                </label>
                <a href="" class="text-primary hover:underline">Lupa password?</a>
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
            <a href=""
                class="w-full flex items-center justify-center gap-2 border border-gray-300 py-2 rounded-lg hover:bg-accent transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                <span class="font-medium text-gray-700">Masuk dengan Google</span>
            </a>

            <a href=""
                class="w-full flex items-center justify-center gap-2 border border-gray-300 py-2 rounded-lg hover:bg-accent transition">
                <img src="https://www.svgrepo.com/show/452115/telegram.svg" alt="Telegram" class="w-5 h-5">
                <span class="font-medium text-gray-700">Masuk dengan Telegram</span>
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Belum punya akun?
            <a href="" class="text-primary hover:underline">Daftar Sekarang</a>
        </p>
    </div>

</body>

</html>
