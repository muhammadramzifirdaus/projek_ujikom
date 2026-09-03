<?php

namespace App\Observers;

use App\Models\Alat;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class AlatObserver
{
    private function catatLog(string $pesan): void
    {
        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aktivitas' => $pesan,
        ]);
    }

    public function created(Alat $alat): void
    {
        $this->catatLog("Menambahkan data alat baru: '{$alat->nama_alat}' (Stok: {$alat->stok}, Kondisi: {$alat->status_kondisi})");
    }

    public function updated(Alat $alat): void
    {
        $changes = [];
        foreach ($alat->getChanges() as $key => $newValue) {
            if ($key !== 'updated_at') {
                $oldValue = $alat->getOriginal($key);
                $changes[] = "kolom '{$key}' berubah dari '{$oldValue}' menjadi '{$newValue}'";
            }
        }

        $detailPerubahan = !empty($changes) ? implode(', ', $changes) : 'memperbarui data alat';

        $this->catatLog("Memperbarui alat '{$alat->nama_alat}': ({$detailPerubahan})");
    }

    public function deleted(Alat $alat): void
    {
        $this->catatLog("Menghapus data alat: '{$alat->nama_alat}'");
    }
}