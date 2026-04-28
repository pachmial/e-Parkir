<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\User;
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
    $validate = $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    $userCreate = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/login')->with('success', 'Akun berhasil dibuat!');
}
    // POST /api/auth/login

    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // DIARAHKAN KE HALAMAN 1 SETELAH LOGIN SUKSES
            return redirect('/onboarding');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
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