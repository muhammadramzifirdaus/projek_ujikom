<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - PinjamIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen p-6">
    <div class="max-w-2xl mx-auto bg-slate-800/80 p-8 rounded-2xl border border-slate-700 shadow-2xl space-y-6">
        <h2 class="text-2xl font-bold text-indigo-400">Pengaturan Profil</h2>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 p-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Preview Foto Profil -->
            <div class="flex items-center space-x-4">
                <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : 'https://via.placeholder.com/100' }}" 
                     alt="Foto Profil" class="w-20 h-20 rounded-full object-cover border-2 border-indigo-500">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Ganti Foto Profil</label>
                    <input type="file" name="foto_profil" class="text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Email (Tidak bisa diubah)</label>
                <input type="email" value="{{ $user->email }}" disabled class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl p-3 text-slate-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">No. HP / WA</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Alamat</label>
                <textarea name="alamat" rows="2" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <hr class="border-slate-700 my-4">

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 rounded-xl transition duration-200">
                Simpan Perubahan
            </button>
        </form>
    </div>
</body>
</html>