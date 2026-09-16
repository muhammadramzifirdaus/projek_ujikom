@extends('layouts.app')

@section('title', 'Kelola Peminjaman - Panel Admin')
@section('header-title', 'Manajemen Transaksi Peminjaman')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <!-- Header & Toolbar Admin -->
        <div class="p-5 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="text-base font-bold text-gray-800">Daftar Transaksi Peminjaman</h3>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <!-- Form Search -->
                <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="flex items-center gap-0 w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam / status..."
                        class="w-full md:w-64 px-3 py-2 text-xs border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-xs px-4 py-2 font-semibold rounded-r-lg transition">
                        Cari
                    </button>
                </form>

                <!-- Tombol Tambah Peminjaman Admin -->
                <a href="{{ route('admin.peminjaman.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
                    + Tambah Peminjaman
                </a>
            </div>
        </div>

        <!-- Tabel Utama -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider border-b">
                        <th class="py-3 px-4">PEMINJAM</th>
                        <th class="py-3 px-4">ALAT YANG DIPINJAM</th>
                        <th class="py-3 px-4">TGL PINJAM / RENCANA KEMBALI</th>
                        <th class="py-3 px-4">STATUS</th>
                        <th class="py-3 px-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-xs divide-y divide-gray-100">
                    @forelse($peminjamans as $peminjaman)
                        <tr class="hover:bg-gray-50 transition align-top">
                            <!-- Peminjam -->
                            <td class="py-3 px-4 font-bold text-gray-900">
                                {{ $peminjaman->user->name ?? 'User Dihapus' }}
                            </td>

                            <!-- Alat yang Dipinjam -->
                            <td class="py-3 px-4">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($peminjaman->detailPinjam as $detail)
                                        <li>
                                            <span class="font-semibold">{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}</span>
                                            <span class="text-[10px] bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded font-medium">
                                                ({{ $detail->jumlah }} pcs)
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            <!-- Tanggal Pinjam & Rencana Kembali -->
                            <td class="py-3 px-4 text-gray-600">
                                <div><span class="font-medium text-gray-500">Pinjam:</span> {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('Y-m-d') }}</div>
                                <div><span class="font-bold text-gray-700">Rencana:</span> {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_plan)->format('Y-m-d') }}</div>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full inline-block
                                    @if($peminjaman->status == 'diajukan') bg-amber-100 text-amber-800
                                    @elseif($peminjaman->status == 'dipinjam') bg-blue-100 text-blue-800
                                    @elseif($peminjaman->status == 'selesai' || $peminjaman->status == 'dikembalikan') bg-emerald-100 text-emerald-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>

                            <!-- Aksi (Dropdown Update Status & Tombol Hapus) -->
                            <td class="py-3 px-4 text-center">
                                <div class="flex flex-col items-center gap-1.5 w-28 mx-auto">
                                    <form action="{{ route('admin.peminjaman.updateStatus', $peminjaman->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()"
                                            class="w-full text-xs border border-gray-300 rounded px-2 py-1 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                                            <option value="diajukan" {{ $peminjaman->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                            <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                            <option value="selesai" {{ ($peminjaman->status == 'selesai' || $peminjaman->status == 'dikembalikan') ? 'selected' : '' }}>Selesai</option>
                                            <option value="telat" {{ $peminjaman->status == 'telat' ? 'selected' : '' }}>Telat</option>
                                            <option value="ditolak" {{ $peminjaman->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </form>

                                    <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" method="POST" class="w-full" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-1 rounded transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500 text-xs">Belum ada transaksi peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection