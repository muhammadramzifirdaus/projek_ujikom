<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'no_hp'       => 'nullable|string|max:15',
            'alamat'      => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password'    => 'nullable|string|min:8',
        ]);

        $user->name   = $request->name;
        $user->no_hp  = $request->no_hp;
        $user->alamat = $request->alamat;

        // Cek file upload
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan foto baru ke disk public
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $user->foto_profil = $path;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}