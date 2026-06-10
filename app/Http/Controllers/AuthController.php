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
            $request->session()->regenerate();

            // Cek jabatan/role untuk melempar ke halaman yang tepat
            if (Auth::user()->role === 'bendahara') {
                return redirect()->intended('/bendahara');
            } else {
                return redirect()->intended('/warga'); // Lempar ke /warga
            }
        }

        return back()->withErrors(['email' => 'Email atau Password salah.']);
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /** Redirect berdasarkan role (Fungsi Helper) */
    private function redirectByRole(User $user)
    {
        return $user->role === 'bendahara'
            ? redirect('/bendahara')
            : redirect('/warga');
    }

    /** Proses Register */
    public function prosesRegister(Request $request)
    {
        // 1. Validasi data yang diisi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'no_rumah' => 'required|string|max:10',
            'no_wa' => 'nullable|string|max:20',
            'role' => 'required|in:warga,bendahara' // Pastikan role hanya bisa diisi warga/bendahara
        ]);

        // 2. Simpan ke database dan tampung di variabel $user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_rumah' => $request->no_rumah,
            'no_wa' => $request->no_wa,
            'role' => $request->role, 
        ]);

        // 3. Login otomatis setelah daftar
        Auth::login($user);

        // 4. Arahkan ke halaman yang sesuai dengan jabatannya
        if ($user->role === 'bendahara') {
            return redirect('/bendahara')->with('success', 'Pendaftaran Bendahara berhasil!');
        } else {
            return redirect('/warga')->with('success', 'Pendaftaran Warga berhasil!');
        }
    }
}