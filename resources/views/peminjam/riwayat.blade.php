@extends('layouts.app')

@section('title', 'Riwayat Saya - Panel Peminjam')
@section('header-title', 'Riwayat Pengajuan Peminjaman')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-base font-bold text-gray-800">Daftar Transaksi Saya</h3>
            <a href="{{ route('peminjam.katalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                + Ajukan Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider border-b">
                        <th class="py-3 px-4">ALAT YANG DIPINJAM</th>
                        <th class="py-3 px-4">TANGGAL PINJAM / BATAS</th>
                        <th class="py-3 px-4">STATUS</th>
                        <th class="py-3 px-4">DETAIL PENGEMBALIAN</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-xs divide-y divide-gray-100">
                    @forelse($peminjamans as $pinjam)
                        <tr class="hover:bg-gray-50 transition align-top">
                            <td class="py-3 px-4">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($pinjam->detailPinjam as $detail)
                                        <li>
                                            <span class="font-semibold">{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}</span>
                                            <span class="text-[10px] bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded font-medium">
                                                ({{ $detail->jumlah }} Unit)
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-3 px-4 text-gray-600">
                                <div>Pinjam: <strong>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('Y-m-d') }}</strong></div>
                                <div>Batas: <strong>{{ \Carbon\Carbon::parse($pinjam->tgl_kembali_plan)->format('Y-m-d') }}</strong></div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full inline-block
                                    @if($pinjam->status == 'diajukan') bg-amber-100 text-amber-800
                                    @elseif($pinjam->status == 'dipinjam') bg-blue-100 text-blue-800
                                    @elseif($pinjam->status == 'selesai' || $pinjam->status == 'dikembalikan') bg-emerald-100 text-emerald-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($pinjam->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($pinjam->pengembalian)
                                    <div>Tgl Kembali: <strong>{{ $pinjam->pengembalian->tgl_kembali }}</strong></div>
                                    <div>Kondisi: <strong>{{ $pinjam->pengembalian->kondisi_kembali }}</strong></div>
                                    <div>Total Denda: <strong class="text-red-600">Rp {{ number_format($pinjam->pengembalian->denda, 0, ',', '.') }}</strong></div>
                                @else
                                    <span class="text-gray-400 italic">Belum dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500 text-xs">Belum ada riwayat peminjaman alat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection