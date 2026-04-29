<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kendaraan;
use App\Models\LokasiParkir; // ← TAMBAHAN

class BerandaController extends Controller
{
    // ─── BERANDA (BARU) ───────────────────────────────────────────────────────
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

    // ─── AKUN / PROFILE (TIDAK DIUBAH) ────────────────────────────────────────
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        $kendaraan = Kendaraan::where('pengguna_id', $user->id)->first();

        return view('akun', compact('user', 'kendaraan'));
    }

    // ─── SAVE KENDARAAN (TIDAK DIUBAH) ────────────────────────────────────────
   public function saveKendaraan(Request $request)
{
    $request->validate([
        'jenis_kendaraan' => 'required',
        'plat_nomor'      => 'required'
    ]);

    $user = Auth::user();

    Kendaraan::updateOrCreate(
        ['pengguna_id' => $user->id],
        [
            'id'         => \Illuminate\Support\Str::uuid(), // hanya dipakai saat create
            'jenis'      => $request->jenis_kendaraan,       // sesuai kolom di model
            'plat_nomor' => $request->plat_nomor,
        ]
    );

    return redirect('/beranda')->with('success', 'Data kendaraan berhasil disimpan!');
}
}
