<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-accent/100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-primary/600 mb-6">Reset Password</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <label class="block text-accent/700 font-semibold mb-2">Password Baru</label>
            <input type="password" name="password"
                class="w-full border border-accent/300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary/500"
                required>

            <label class="block text-accent/700 font-semibold mb-2 mt-4">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="w-full border border-accent/300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary/500"
                required>

            <button type="submit"
                class="w-full bg-primary text-white font-semibold py-3 rounded-lg mt-6 hover:bg-primary/700 transition">
                Ubah Password
            </button>
        </form>
    </div>
</body>

</html>
