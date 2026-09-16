@extends('layouts.app')

@section('title', 'Kelola Pengembalian - Panel Admin')
@section('header-title', 'Manajemen Pengembalian Alat')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <!-- Header & Toolbar Pengembalian -->
        <div class="p-5 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="text-lg font-bold text-gray-800">Daftar Transaksi Pengembalian</h3>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <!-- Form Cari -->
                <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="flex w-full md:w-80">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam / status..."
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 text-sm font-semibold rounded-r-lg transition">
                        Cari
                    </button>
                </form>

                <!-- TOMBOL PROSES PENGEMBALIAN (Global / Ke transaksi aktif terbanyak) -->
                @php
                    $peminjamanAktif = $peminjamans->firstWhere('status', 'dipinjam');
                @endphp
                @if($peminjamanAktif)
                    <a href="{{ route('admin.pengembalian.proses', $peminjamanAktif->id) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-lg transition whitespace-nowrap shadow-sm">
                        + Proses Pengembalian
                    </a>
                @endif
            </div>
        </div>

        <!-- Tabel Transaksi Pengembalian -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">Peminjam</th>
                        <th class="py-3 px-4 border-b">Alat & Jumlah</th>
                        <th class="py-3 px-4 border-b">Tgl Pinjam / Batas</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Detail Pengembalian</th>
                        <th class="py-3 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($peminjamans as $pinjam)
                        <tr class="hover:bg-gray-50 transition align-top">
                            <td class="py-3 px-4 border-b font-semibold text-gray-900">{{ $pinjam->user->name ?? 'User Dihapus' }}</td>
                            <td class="py-3 px-4 border-b">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($pinjam->detailPinjam as $detail)
                                        <li>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }} (<strong>{{ $detail->jumlah }}</strong>)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-3 px-4 border-b text-xs text-gray-600">
                                <div><strong class="text-gray-700">Pinjam:</strong> {{ $pinjam->tgl_pinjam }}</div>
                                <div><strong class="text-gray-700">Batas:</strong> {{ $pinjam->tgl_kembali_plan }}</div>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if($pinjam->status == 'dipinjam') bg-blue-100 text-blue-800
                                    @elseif($pinjam->status == 'dikembalikan' || $pinjam->status == 'selesai') bg-emerald-100 text-emerald-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($pinjam->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b text-xs">
                                @if($pinjam->pengembalian)
                                    <div><strong>Tgl Kembali:</strong> {{ $pinjam->pengembalian->tgl_kembali }}</div>
                                    <div><strong>Kondisi:</strong> {{ $pinjam->pengembalian->kondisi_kembali }}</div>
                                    <div><strong>Total Denda:</strong> <span class="text-red-600 font-bold">Rp {{ number_format($pinjam->pengembalian->denda, 0, ',', '.') }}</span></div>
                                    <div class="text-gray-500">Penerima: {{ $pinjam->pengembalian->petugas->name ?? 'Sistem' }}</div>
                                @else
                                    <span class="text-amber-600 font-medium italic">Belum dikembalikan</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border-b text-center">
                                @if($pinjam->status === 'dipinjam')
                                    <a href="{{ route('admin.pengembalian.proses', $pinjam->id) }}"
                                       class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded text-xs font-semibold shadow transition">
                                        Proses Kembali
                                    </a>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded font-medium">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500 text-sm">Tidak ada data transaksi pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection