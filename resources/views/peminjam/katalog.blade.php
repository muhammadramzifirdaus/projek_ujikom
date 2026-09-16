@extends('layouts.app')

@section('title', 'Katalog Alat - Panel Peminjam')
@section('header-title', 'Katalog Alat Tersedia')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg text-xs">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-xs">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Daftar Alat -->
        <div class="lg:col-span-2">
            <h3 class="text-base font-bold text-gray-800 mb-4">Daftar Alat Tersedia</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($alats as $alat)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 flex flex-col justify-between">
                        <div>
                            @if($alat->gambar)
                                {{-- Memeriksa apakah path sudah mengandung 'storage/' atau belum --}}
                                <img src="{{ asset(Str::startsWith($alat->gambar, 'storage/') ? $alat->gambar : 'storage/' . $alat->gambar) }}" 
                                     alt="{{ $alat->nama_alat }}" 
                                     class="w-full h-36 object-cover rounded mb-3">
                            @else
                                <div class="w-full h-36 bg-gray-100 rounded mb-3 flex items-center justify-center text-gray-400 text-xs">
                                    Tanpa Gambar
                                </div>
                            @endif

                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded uppercase">
                                {{ $alat->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                            <h4 class="font-bold text-gray-900 text-sm mt-1">{{ $alat->nama_alat }}</h4>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $alat->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs font-medium text-gray-600">Stok: <strong class="text-gray-900">{{ $alat->stok }}</strong></span>
                            @if($alat->stok > 0)
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                                    Tersedia
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-red-100 text-red-800">
                                    Habis
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-6 rounded-lg text-center text-gray-500 text-xs border">
                        Belum ada alat yang tersedia untuk dipinjam.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Form Pengajuan Peminjaman -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 h-fit">
            <h3 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b">Form Ajukan Peminjaman</h3>
            
            <form action="{{ route('peminjam.ajukan') }}" method="POST">
                @csrf

                <!-- Rencana Kembali -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Rencana Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali_plan" required min="{{ date('Y-m-d') }}"
                        class="w-full text-xs border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Pilih Alat & Jumlah -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Alat & Jumlah</label>
                    <div class="flex gap-2">
                        <select name="alat_id[]" required class="w-full text-xs border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">-- Pilih Alat --</option>
                            @foreach($alats as $alat)
                                <option value="{{ $alat->id }}" {{ $alat->stok <= 0 ? 'disabled' : '' }}>
                                    {{ $alat->nama_alat }} (Stok: {{ $alat->stok }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="jumlah[]" value="1" min="1" required placeholder="Qty"
                            class="w-20 text-xs border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2.5 rounded-lg transition shadow-sm mt-2">
                    Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>
@endsection