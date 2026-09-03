@extends('layouts.app')

@section('title', 'Laporan Peminjaman - Dashboard Petugas')
@section('header-title', 'Laporan Peminjaman & Pengembalian Alat')

@section('content')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 mb-6">
        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-base font-bold text-gray-800 mb-3">Filter Laporan</h3>

            <form action="{{ route('petugas.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Peminjaman</label>
                    <select name="status" class="w-full text-xs border border-gray-300 rounded p-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Status</option>
                        <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="telat" {{ request('status') == 'telat' ? 'selected' : '' }}>Telat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal (Pinjam)</label>
                    <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}"
                        class="w-full text-xs border border-gray-300 rounded p-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal (Pinjam)</label>
                    <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
                        class="w-full text-xs border border-gray-300 rounded p-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-xs px-4 py-2 rounded font-semibold transition shadow-sm">
                        Filter
                    </button>
                    @if(request('status') || request('dari_tanggal') || request('sampai_tanggal'))
                        <a href="{{ route('petugas.laporan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 text-xs px-3 py-2 rounded transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Rekap Laporan -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-base font-bold text-gray-800">Hasil Rekap Laporan</h3>
            <!-- Teks Tombol Disesuaikan dengan Modul -->
            <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition">
                Cetak / Print Laporan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">NO</th>
                        <th class="py-3 px-4 border-b">PEMINJAM</th>
                        <th class="py-3 px-4 border-b">TGL PINJAM</th>
                        <th class="py-3 px-4 border-b">RENCANA KEMBALI</th>
                        <th class="py-3 px-4 border-b">STATUS</th>
                        <th class="py-3 px-4 border-b">DETAIL ALAT</th>
                        <th class="py-3 px-4 border-b">DENDA</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-xs">
                    @forelse($laporans as $index => $item)
                        <tr class="hover:bg-gray-50 transition align-top">
                            <td class="py-3 px-4 border-b font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 border-b font-medium text-gray-900">{{ $item->user->name ?? 'User Dihapus' }}</td>
                            <td class="py-3 px-4 border-b">{{ $item->tgl_pinjam }}</td>
                            <td class="py-3 px-4 border-b">{{ $item->tgl_kembali_plan }}</td>
                            <td class="py-3 px-4 border-b">
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                    {{ $item->status == 'selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $item->status == 'dipinjam' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $item->status == 'diajukan' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $item->status == 'telat' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <ul class="list-disc list-inside space-y-0.5">
                                    @foreach($item->detailPinjam as $detail)
                                        <li>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }} ({{ $detail->jumlah }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-3 px-4 border-b font-semibold">
                                Rp {{ number_format($item->pengembalian->denda ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500">Tidak ada data laporan yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection