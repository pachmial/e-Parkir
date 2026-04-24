<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Balik ke Login setelah buat akun
        return redirect('/halaman3')->with('success', 'Akun berhasil dibuat!');
    } // Penutup fungsi register

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // DIARAHKAN KE HALAMAN 1 SETELAH LOGIN SUKSES
            return redirect('/halaman1');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    } // Penutup fungsi login

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/halaman3');
    } // Penutup fungsi logout

} // Penutup CLASS AuthController (INI YANG TADI SALAH POSISI)