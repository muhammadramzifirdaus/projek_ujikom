<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login web
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role === "admin") {
                return redirect()->route("admin.dashboard");
            }
            return redirect("/");
        }

        return view("auth.login");
    }

    // Memproses submit form login web
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email"    => "required|email",
            "password" => "required|string",
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === "admin") {
                return redirect()->intended(route("admin.dashboard"))->with("success", "Selamat datang kembali, Admin!");
            }

            return redirect()->intended("/");
        }

        return back()->withErrors([
            "email" => "Kredensial yang diberikan tidak cocok dengan data kami.",
        ])->onlyInput("email");
    }

    // Memproses logout web
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("login")->with("success", "Anda telah berhasil keluar.");
    }
}
