<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Halaman login
    public function loginForm()
    {
        return view('admin.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.products.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
    public function formGantiPassword()
{
    return view('admin.ganti-password');
}

public function simpanPassword(Request $request)
{
    $passwordLama = \App\Models\Setting::get('hapus_password');

    if ($request->password_lama !== $passwordLama) {
        return back()->with('error', 'Password lama salah!');
    }

    if ($request->password_baru !== $request->konfirmasi) {
        return back()->with('error', 'Konfirmasi password tidak cocok!');
    }

    \App\Models\Setting::set('hapus_password', $request->password_baru);

    return back()->with('success', 'Password berhasil diubah!');
}
}