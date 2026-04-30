<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kendaraan;
use App\Models\LokasiParkir;


class BerandaController extends Controller
{
    public function profile()
{
    $user = Auth::user();

    if (!$user) {
        return redirect('/login');
    }

    // ✅ FIX DI SINI
    $kendaraan = Kendaraan::where('pengguna_id', $user->id)->first();

    return view('akun', compact('user', 'kendaraan'));
}

public function saveKendaraan(Request $request)
{
    $request->validate([
        'jenis_kendaraan' => 'required',
        'plat_nomor' => 'required'
    ]);

    $user = Auth::user();

    // ✅ FIX DI SINI JUGA
    Kendaraan::updateOrCreate(
        ['pengguna_id' => $user->id],
        [
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'plat_nomor' => $request->plat_nomor
        ]
    );

    return redirect()->route('akun')->with('success', 'Data tersimpan');

    
}

// tambah method ini di dalam class, setelah method saveKendaraan()
public function index()
{
    $parkirList = LokasiParkir::where('aktif', true)->get()->map(function ($item) {
        return [
            'nama'   => $item->nama,
            'param'  => $item->id,
            'lokasi' => $item->alamat,
            'harga'  => 'Rp' . number_format($item->harga_per_jam, 0, ',', '.') . '/jam',
            'rating' => '4.5',
            'foto'   => 'images/default.jpg',
        ];
    })->toArray();

    return view('beranda', compact('parkirList'));
}
}