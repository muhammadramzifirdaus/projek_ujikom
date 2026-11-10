<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - PinjamIn</title>
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
<body class="min-h-screen flex items-center justify-center p-4 py-8">
    <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 max-w-md w-full shadow-2xl space-y-5 border border-white/20">
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="flex justify-center">
                <img src="{{ asset('assets/img/pinjaminlogo.svg') }}" alt="PinjamIn Logo" class="w-14 h-14 object-contain">
            </div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Daftar Akun</h2>
            <p class="text-xs text-gray-500 font-medium">Buat akun PinjamIn baru kamu</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-xl text-xs">
                <p class="font-semibold">{{ $errors->first() }}</p>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
            @csrf
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap kamu" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs text-gray-800 focus:outline-none focus:bg-white focus:border-[#009669]">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="pinjamin@email.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs text-gray-800 focus:outline-none focus:bg-white focus:border-[#009669]">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">No. HP / WA</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08XXXXXXXXXX" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs text-gray-800 focus:outline-none focus:bg-white focus:border-[#009669]">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">Alamat</label>
                <textarea name="alamat" rows="2" placeholder="Alamat rumah/domisili" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs text-gray-800 focus:outline-none focus:bg-white focus:border-[#009669]">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 pr-10 text-xs text-gray-800 focus:outline-none focus:bg-white focus:border-[#009669]">
                    <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg id="eyeIcon1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 pr-10 text-xs text-gray-800 focus:outline-none focus:bg-white focus:border-[#009669]">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg id="eyeIcon2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#009669] hover:bg-[#007d57] text-white font-bold py-3.5 rounded-xl transition duration-200 shadow-md text-xs mt-2">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-xs text-gray-500">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#009669] font-bold hover:underline">Login di sini</a>
        </p>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 0110.122 1.933M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>
</html>