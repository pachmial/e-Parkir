<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\TokenRefresh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    
public function register(Request $request)
{
    $request->validate([
        'nama'     => 'required',
        'email'    => 'required|email|unique:pengguna,email',
        'password' => 'required|min:6',
    ]);

    Pengguna::create([
        'id'         => \Illuminate\Support\Str::uuid(),
        'nama'       => $request->nama,
        'email'      => $request->email,
        'kata_sandi' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    return redirect('/login')->with('success', 'Akun berhasil dibuat!');
}

public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect('/beranda');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
} // Penutup fungsi login

    // POST /api/auth/logout
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            TokenRefresh::where('token', hash('sha256', $token))
                ->update(['dicabut' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}