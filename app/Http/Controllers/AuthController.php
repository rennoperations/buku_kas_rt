<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** Tampilkan halaman login */
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    /** Proses login */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /** Redirect berdasarkan role */
    private function redirectByRole(User $user)
    {
        return $user->isBendahara()
            ? redirect('/bendahara')
            : redirect('/warga');
    }
    
    public function prosesRegister(Request $request)
    {
    // 1. Validasi data yang diisi warga
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
        'no_rumah' => 'required|string|max:10', // Asumsi kamu meminta nomor rumah
    ]);

    // 2. Simpan ke database
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Enkripsi password
        'role' => 'warga', // Otomatis jadikan warga
        'no_rumah' => $request->no_rumah,
    ]);

    // 3. Arahkan kembali ke halaman login dengan pesan sukses
    return redirect('/login')->withErrors(['email' => 'Pendaftaran berhasil! Silakan login.']); 
    // Catatan: menggunakan withErrors sementara agar pesan muncul di alert merah/hijau form loginmu
    }
}
