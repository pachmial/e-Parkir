<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KendaraanController extends Controller
{
    // GET /api/pengguna/{penggunaId}/kendaraan
    public function index($penggunaId)
    {
        $kendaraan = Kendaraan::where('pengguna_id', $penggunaId)
            ->orderByDesc('utama')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $kendaraan,
        ]);
    }

    // GET /api/kendaraan/{id}
    public function show($id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $kendaraan,
        ]);
    }

    // POST /api/pengguna/{penggunaId}/kendaraan
    public function store(Request $request, $penggunaId)
    {
        $validator = Validator::make($request->all(), [
            'plat_nomor' => 'required|string|max:20',
            'merek'      => 'nullable|string|max:50',
            'model'      => 'nullable|string|max:50',
            'warna'      => 'nullable|string|max:30',
            'jenis'      => 'nullable|in:mobil,motor',
            'utama'      => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Cek plat nomor sudah terdaftar untuk pengguna ini
        $exists = Kendaraan::where('pengguna_id', $penggunaId)
            ->where('plat_nomor', strtoupper($request->plat_nomor))
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Plat nomor sudah terdaftar',
            ], 409);
        }

        // Jika kendaraan ini dijadikan utama, reset utama lainnya
        if ($request->input('utama', false)) {
            Kendaraan::where('pengguna_id', $penggunaId)->update(['utama' => false]);
        }

        // Jika belum ada kendaraan, otomatis jadi utama
        $isUtama = $request->input('utama', false);
        if (!Kendaraan::where('pengguna_id', $penggunaId)->exists()) {
            $isUtama = true;
        }

        $kendaraan = Kendaraan::create([
            'id'          => Str::uuid(),
            'pengguna_id' => $penggunaId,
            'plat_nomor'  => strtoupper($request->plat_nomor),
            'merek'       => $request->merek,
            'model'       => $request->model,
            'warna'       => $request->warna,
            'jenis'       => $request->input('jenis', 'mobil'),
            'utama'       => $isUtama,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil ditambahkan',
            'data'    => $kendaraan,
        ], 201);
    }

    // PUT /api/kendaraan/{id}
    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'merek' => 'sometimes|string|max:50',
            'model' => 'sometimes|string|max:50',
            'warna' => 'sometimes|string|max:30',
            'jenis' => 'sometimes|in:mobil,motor',
            'utama' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Jika dijadikan utama, reset utama lainnya
        if ($request->input('utama', false)) {
            Kendaraan::where('pengguna_id', $kendaraan->pengguna_id)
                ->where('id', '!=', $id)
                ->update(['utama' => false]);
        }

        $kendaraan->update($request->only(['merek', 'model', 'warna', 'jenis', 'utama']));

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil diperbarui',
            'data'    => $kendaraan,
        ]);
    }

    // DELETE /api/kendaraan/{id}
    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan',
            ], 404);
        }

        $kendaraan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil dihapus',
        ]);
    }
}
