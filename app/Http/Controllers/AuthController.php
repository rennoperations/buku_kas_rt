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
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // LOGIKA PENENTU ARAH
        if ($user->role === 'bendahara') {
            return redirect('/bendahara'); // Arahkan ke dashboard bendahara
        } else {
            return redirect('/dashboard'); // Arahkan ke dashboard warga
        }
    }

    return back()->withErrors(['email' => 'Login gagal.']);
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
        'password' => Hash::make($request->password),
        'no_rumah' => $request->no_rumah,
        'role' => $request->role, // PASTIkan ini $request->role, bukan 'warga'
    ]);

    // 3. Arahkan kembali ke halaman login dengan pesan sukses
    return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan Login.'); 
    // Catatan: menggunakan withErrors sementara agar pesan muncul di alert merah/hijau form loginmu
    }
}
