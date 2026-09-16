<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Panel')</title>
    <!-- Memuat Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
            <!-- Judul Sidebar Disuper-presisikan (Ukuran text-sm agar sama presisi seperti gambar 1) -->
            <div class="px-5 py-4 text-sm font-bold tracking-wider border-b border-gray-800 uppercase">
                Panel {{ auth()->user()->role ?? 'User' }}
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <!-- MENU KHUSUS ADMIN -->
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.user.index') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('admin.user.*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola User
                    </a>

                    <a href="{{ route('admin.kategori.index') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('admin.kategori.*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Kategori
                    </a>

                    <a href="{{ route('admin.alat.index') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('admin.alat.*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Alat
                    </a>

                    <a href="{{ route('admin.peminjaman.index') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('admin.peminjaman*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Peminjaman
                    </a>

                    <a href="{{ route('admin.pengembalian.index') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('admin.pengembalian*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Pengembalian
                    </a> 

                <!-- MENU KHUSUS PETUGAS -->
                @elseif(auth()->user()->role === 'petugas')
                    <a href="{{ route('petugas.peminjaman.index') }}"
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('petugas.peminjaman*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Persetujuan Peminjaman
                    </a>

                    <a href="{{ route('petugas.pengembalian.index') }}"
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('petugas.pengembalian*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Pemantauan Pengembalian
                    </a>

                    <a href="{{ route('petugas.laporan.index') }}"
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('petugas.laporan*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Cetak Laporan
                    </a>

                <!-- MENU KHUSUS PEMINJAM -->
                @else
                    <a href="{{ route('peminjam.katalog') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('peminjam.katalog*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Daftar Alat
                    </a>

                    <a href="{{ route('peminjam.riwayat') }}" 
                       class="block px-4 py-2 text-xs rounded-lg transition {{ request()->routeIs('peminjam.riwayat*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Riwayat Peminjaman
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-gray-800 text-xs text-gray-400">
                Logged in as: <span class="text-white font-semibold">{{ auth()->user()->name ?? 'User' }}</span>
            </div>
        </aside>

        <!-- MAIN CONTENT CONTAINER -->
        <div class="flex-1 flex flex-col overflow-y-auto">

            <!-- NAVBAR ATAS -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
                <div class="text-base font-semibold text-gray-800">
                    @yield('header-title', 'Dashboard')
                </div>
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- KONTEN UTAMA HALAMAN -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>