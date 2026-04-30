<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PenggunaController extends Controller
{
    // GET /api/pengguna — hanya admin
    public function index()
    {
        $pengguna = Pengguna::select([
            'id', 'nama', 'email', 'no_telepon', 'peran',
            'foto_profil', 'sudah_verifikasi', 'dibuat_pada',
        ])->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $pengguna,
        ]);
    }

    // GET /api/pengguna/{id}
    public function show($id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pengguna->makeHidden('kata_sandi'),
        ]);
    }

    // PUT /api/pengguna/{id}
    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'       => 'sometimes|string|max:100',
            'no_telepon' => 'sometimes|string|max:20',
            'foto_profil'=> 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $pengguna->update($request->only(['nama', 'no_telepon', 'foto_profil']));

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $pengguna->makeHidden('kata_sandi'),
        ]);
    }

    // PUT /api/pengguna/{id}/ganti-password
    public function gantiPassword(Request $request, $id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kata_sandi_lama' => 'required|string',
            'kata_sandi_baru' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if (!Hash::check($request->kata_sandi_lama, $pengguna->kata_sandi)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi lama tidak sesuai',
            ], 400);
        }

        $pengguna->update(['kata_sandi' => Hash::make($request->kata_sandi_baru)]);

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diubah',
        ]);
    }

    // DELETE /api/pengguna/{id} — hanya admin
    public function destroy($id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan',
            ], 404);
        }

        $pengguna->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus',
        ]);
    }
}
