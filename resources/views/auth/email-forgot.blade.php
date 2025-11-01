<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-accent flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Lupa Password</h2>

        @if (session('status'))
            <div class="bg-success/100 text-success/700 p-3 rounded mb-4">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email" class="block text-gray-700 font-semibold mb-2">Alamat Email</label>
            <input type="email" id="email" name="email"
                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary/500"
                required autofocus>

            @error('email')
                <p class="text-danger text-sm mt-2">{{ $message }}</p>
            @enderror

            <button type="submit"
                class="w-full bg-primary text-white font-semibold py-3 rounded-lg mt-4 hover:bg-primary/700 transition">
                Kirim Link Reset
            </button>
        </form>
    </div>
</body>

</html>
