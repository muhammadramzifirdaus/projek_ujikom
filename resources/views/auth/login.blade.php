<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Panel Aplikasi Peminjaman Alat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-gray-800 tracking-wider">PANEL ADMIN</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk untuk mengelola sistem peminjaman</p>
        </div>

        @if(session("error"))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session("error") }}
            </div>
        @endif

        @if(session("success"))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm">
                {{ session("success") }}
            </div>
        @endif

        <form action="{{ route("login.process") }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old("email") }}" required autofocus
                    placeholder="admin@gmail.com"
                    class="w-full px-4 py-2.5 text-sm border @error("email") border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error("email")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    placeholder="••••••••"
                    class="w-full px-4 py-2.5 text-sm border @error("password") border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error("password")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg shadow transition duration-200">
                Masuk ke Sistem
            </button>
        </form>
    </div>

</body>
</html>
