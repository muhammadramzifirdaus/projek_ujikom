<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - PinjamIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: url("{{ asset('assets/img/backgroundlogin.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 max-w-md w-full shadow-2xl text-center space-y-6 border border-white/20">
        <!-- Logo -->
        <div class="flex justify-center">
            <img src="{{ asset('assets/img/pinjaminlogo.svg') }}" alt="PinjamIn Logo" class="w-16 h-16 object-contain">
        </div>

        <!-- Title -->
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">PinjamIn</h1>
            <p class="text-xs text-gray-500 font-medium mt-1">Nggak usah beli, PinjamIn aja</p>
        </div>

        <!-- Description -->
        <p class="text-xs text-gray-600 leading-relaxed px-2">
            Selamat datang di <strong class="text-gray-800">PinjamIn</strong>! Platform praktis untuk mengelola, mengajukan, dan memantau peminjaman sarana prasarana secara cepat dan terintegrasi.
        </p>

        <!-- Buttons -->
        <div class="space-y-3 pt-2">
            <a href="{{ route('register') }}" class="block w-full py-3.5 bg-[#009669] hover:bg-[#007d57] text-white font-bold rounded-xl text-xs transition duration-200 shadow-md">
                Buat Akun / Registrasi
            </a>
            <a href="{{ route('login') }}" class="block w-full py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs border border-gray-200 transition duration-200">
                Sudah Punya Akun? Login
            </a>
        </div>
    </div>
</body>
</html>