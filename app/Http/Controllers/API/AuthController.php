<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan Form Login Web
    public function showLoginForm()
    {
        // Jika sudah login, langsung arahkan ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectUserByRole();
        }

        return view('auth.login');
    }

    // Proses Login Web
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectUserByRole();
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    // Redirect berdasarkan Role User agar tidak Infinite Loop
    private function redirectUserByRole()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($role === 'petugas') {
            return redirect()->intended(route('petugas.peminjaman.index'));
        }

        // Default redirect jika role lain (misal peminjam)
        return redirect()->intended('/');
    }

    // Proses Logout Web
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}