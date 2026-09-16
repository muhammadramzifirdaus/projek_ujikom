<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\DetailPinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PeminjamController extends Controller
{
    // 1. Melihat daftar/katalog alat yang tersedia
    public function katalogAlat()
    {
        $alats = Alat::with('kategori')->where('stok', '>', 0)->get();
        return view('peminjam.katalog', compact('alats'));
    }

    // 2. Memproses pengajuan peminjaman oleh peminjam
    public function ajukanPeminjaman(Request $request)
    {
        $request->validate([
            'tgl_kembali_plan' => 'required|date|after_or_equal:today',
            'alat_id'          => 'required|array',
            'alat_id.*'        => 'exists:alat,id',
            'jumlah'           => 'required|array',
            'jumlah.*'         => 'integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Validasi stok sebelum diproses
            foreach ($request->alat_id as $index => $alatId) {
                $jumlahPinjam = $request->jumlah[$index];
                $alat = Alat::findOrFail($alatId);

                if ($alat->stok < $jumlahPinjam) {
                    throw new Exception("Stok untuk alat '{$alat->nama_alat}' tidak mencukupi (Tersedia: {$alat->stok}).");
                }
            }

            // Buat header peminjaman
            $peminjaman = Peminjaman::create([
                'user_id'          => auth()->id(),
                'tgl_pinjam'       => now(),
                'tgl_kembali_plan' => $request->tgl_kembali_plan,
                'status'           => 'diajukan',
            ]);

            // Masukkan daftar alat yang dipinjam ke detail_pinjam
            foreach ($request->alat_id as $index => $alatId) {
                DetailPinjam::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id'       => $alatId,
                    'jumlah'        => $request->jumlah[$index],
                ]);
            }

            DB::commit();
            return redirect()->route('peminjam.riwayat')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan peminjaman: ' . $e->getMessage());
        }
    }

    // 3. Melihat riwayat peminjaman user yang sedang login
    public function riwayatPeminjaman()
    {
        // Disesuaikan relasinya menggunakan detailPinjam (bukan detailPinjams)
        $peminjamans = Peminjaman::with(['detailPinjam.alat', 'pengembalian'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjam.riwayat', compact('peminjamans'));
    }
}