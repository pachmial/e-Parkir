<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotifikasiController extends Controller
{
    // GET /api/pengguna/{penggunaId}/notifikasi
    public function index($penggunaId)
    {
        $notifikasi = Notifikasi::where('pengguna_id', $penggunaId)
            ->orderByDesc('dibuat_pada')
            ->paginate(15);

        $belumDibaca = Notifikasi::where('pengguna_id', $penggunaId)
            ->where('sudah_dibaca', false)
            ->count();

        return response()->json([
            'success'      => true,
            'belum_dibaca' => $belumDibaca,
            'data'         => $notifikasi,
        ]);
    }

    // PUT /api/notifikasi/{id}/baca
    public function tandaiBaca($id)
    {
        $notifikasi = Notifikasi::find($id);

        if (!$notifikasi) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        $notifikasi->update(['sudah_dibaca' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca',
        ]);
    }

    // PUT /api/pengguna/{penggunaId}/notifikasi/baca-semua
    public function bacaSemua($penggunaId)
    {
        Notifikasi::where('pengguna_id', $penggunaId)
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca',
        ]);
    }

    // DELETE /api/notifikasi/{id}
    public function destroy($id)
    {
        $notifikasi = Notifikasi::find($id);

        if (!$notifikasi) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus',
        ]);
    }

    // POST /api/notifikasi — internal/admin untuk kirim notif manual
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required|uuid|exists:pengguna,id',
            'judul'       => 'required|string|max:150',
            'pesan'       => 'required|string',
            'jenis'       => 'nullable|in:info,peringatan,sukses,pembayaran',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $notifikasi = Notifikasi::create([
            'id'          => Str::uuid(),
            'pengguna_id' => $request->pengguna_id,
            'judul'       => $request->judul,
            'pesan'       => $request->pesan,
            'jenis'       => $request->input('jenis', 'info'),
            'sudah_dibaca' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dikirim',
            'data'    => $notifikasi,
        ], 201);
    }
}
