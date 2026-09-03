@extends('layouts.app')

@section('title', 'Verifikasi Pengembalian - Panel Admin')
@section('header-title', 'Form Verifikasi Pengembalian Alat')

@section('content')
<div class="max-w-3xl bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="mb-6 border-b pb-4">
        <h4 class="text-base font-bold text-gray-800">Detail Peminjam & Barang</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3 text-sm">
            <div><span class="text-gray-500">Nama Peminjam:</span> <strong>{{ $peminjaman->user->name }}</strong></div>
            <div><span class="text-gray-500">Tanggal Pinjam:</span> <strong>{{ $peminjaman->tgl_pinjam }}</strong></div>
            <div><span class="text-gray-500">Rencana Kembali:</span> <strong>{{ $peminjaman->tgl_kembali_plan }}</strong></div>
            <div><span class="text-gray-500">Tanggal Pengembalian:</span> <strong class="text-blue-600">{{ $tglKembaliReal->toDateString() }}</strong></div>
        </div>

        <div class="mt-4 bg-gray-50 p-3 rounded-lg border text-sm">
            <span class="font-semibold text-gray-700">Daftar Barang Dipinjam:</span>
            <ul class="list-disc list-inside mt-1">
                @foreach($peminjaman->detailPinjam as $detail)
                    <li>{{ $detail->alat->nama_alat }} - <strong>{{ $detail->jumlah }} Unit</strong></li>
                @endforeach
            </ul>
        </div>
    </div>

    <form action="{{ route('admin.pengembalian.store', $peminjaman->id) }}" method="POST">
        @csrf

        <!-- Perhitungan Keterlambatan Otomatis -->
        <div class="mb-4 bg-amber-50 border border-amber-200 p-4 rounded-lg">
            <h5 class="text-sm font-bold text-amber-900">Perhitungan Keterlambatan (Otomatis)</h5>
            <p class="text-xs text-amber-700 mt-1">Tarif denda keterlambatan: <strong>Rp 2.500 / hari</strong></p>
            <div class="flex justify-between items-center mt-3 text-sm">
                <div>Total Hari Terlambat: <strong class="text-red-600">{{ $hariTerlambat }} Hari</strong></div>
                <div>Denda Terlambat: <strong class="text-red-600">Rp {{ number_format($dendaTerlambat, 0, ',', '.') }}</strong></div>
            </div>
            <input type="hidden" name="denda_keterlambatan" id="denda_keterlambatan" value="{{ $dendaTerlambat }}">
        </div>

        <!-- Pilihan Kondisi Kerusakan -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Kondisi Alat Saat Dikembalikan</label>
            <select name="kondisi_kembali" id="kondisi_kembali" onchange="hitungTotalDenda()" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Baik" data-denda="0">Baik / Normal (Tanpa Denda Kerusakan)</option>
                <option value="Rusak Ringan" data-denda="15000">Rusak Ringan (Lecet/Gores - Penalti Rp 15.000)</option>
                <option value="Rusak Sedang" data-denda="35000">Rusak Sedang (Komponen Bermasalah - Penalti Rp 35.000)</option>
                <option value="Rusak Parah" data-denda="75000">Rusak Parah (Mati Total/Patah - Penalti Rp 75.000)</option>
                <option value="Hilang" data-denda="150000">Barang Hilang (Ganti Rugi Penuh - Penalti Rp 150.000)</option>
            </select>
        </div>

        <!-- Input Nominal Denda Kerusakan Tambahan -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Nominal Denda Kerusakan Fisik (Rp)</label>
            <input type="number" name="denda_kerusakan" id="denda_kerusakan" value="0" min="0" oninput="updateKalkulasiTotal()"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Total Denda Keseluruhan -->
        <div class="mb-6 p-4 bg-gray-900 text-white rounded-lg flex justify-between items-center">
            <div>
                <span class="text-xs text-gray-400 block">TOTAL DENDA YANG HARUS DIBAYAR</span>
                <span class="text-xl font-black text-emerald-400" id="total_denda_display">Rp {{ number_format($dendaTerlambat, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.pengembalian.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Konfirmasi Selesai Pengembalian</button>
        </div>
    </form>
</div>

<script>
function hitungTotalDenda() {
    const select = document.getElementById("kondisi_kembali");
    const dendaOtomatis = parseInt(select.options[select.selectedIndex].getAttribute("data-denda")) || 0;
    document.getElementById("denda_kerusakan").value = dendaOtomatis;
    updateKalkulasiTotal();
}

function updateKalkulasiTotal() {
    const dendaTelat = parseInt(document.getElementById("denda_keterlambatan").value) || 0;
    const dendaRusak = parseInt(document.getElementById("denda_kerusakan").value) || 0;
    const total = dendaTelat + dendaRusak;
    document.getElementById("total_denda_display").innerText = "Rp " + total.toLocaleString("id-ID");
}
</script>
@endsection