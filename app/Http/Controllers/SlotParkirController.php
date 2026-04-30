<?php

namespace App\Http\Controllers;

use App\Models\SlotParkir;
use App\Models\LokasiParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SlotParkirController extends Controller
{
    // GET /api/lokasi-parkir/{lokasiId}/slot
    public function index($lokasiId)
    {
        $lokasi = LokasiParkir::find($lokasiId);

        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi parkir tidak ditemukan',
            ], 404);
        }

        $slots = SlotParkir::where('lokasi_parkir_id', $lokasiId)
            ->orderBy('lantai')
            ->orderBy('kode_slot')
            ->get();

        $ringkasan = [
            'total'    => $slots->count(),
            'tersedia' => $slots->where('status', 'tersedia')->count(),
            'terisi'   => $slots->where('status', 'terisi')->count(),
            'dipesan'  => $slots->where('status', 'dipesan')->count(),
            'nonaktif' => $slots->where('status', 'nonaktif')->count(),
        ];

        return response()->json([
            'success'  => true,
            'ringkasan' => $ringkasan,
            'data'     => $slots,
        ]);
    }

    // GET /api/slot-parkir/{id}
    public function show($id)
    {
        $slot = SlotParkir::with('lokasiParkir')->find($id);

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Slot parkir tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $slot,
        ]);
    }

    // POST /api/lokasi-parkir/{lokasiId}/slot — admin
    public function store(Request $request, $lokasiId)
    {
        $lokasi = LokasiParkir::find($lokasiId);

        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi parkir tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_slot'  => 'required|string|max:10',
            'lantai'     => 'nullable|string|max:10',
            'zona'       => 'nullable|string|max:10',
            'jenis_slot' => 'nullable|in:reguler,disabilitas,motor',
            'id_sensor'  => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Cek kode slot sudah ada di lokasi yang sama
        $exists = SlotParkir::where('lokasi_parkir_id', $lokasiId)
            ->where('kode_slot', $request->kode_slot)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Kode slot sudah digunakan di lokasi ini',
            ], 409);
        }

        $slot = SlotParkir::create([
            'id'               => Str::uuid(),
            'lokasi_parkir_id' => $lokasiId,
            'kode_slot'        => $request->kode_slot,
            'lantai'           => $request->lantai,
            'zona'             => $request->zona,
            'jenis_slot'       => $request->input('jenis_slot', 'reguler'),
            'status'           => 'tersedia',
            'id_sensor'        => $request->id_sensor,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slot parkir berhasil ditambahkan',
            'data'    => $slot,
        ], 201);
    }

    // PUT /api/slot-parkir/{id} — admin
    public function update(Request $request, $id)
    {
        $slot = SlotParkir::find($id);

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Slot parkir tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_slot'  => 'sometimes|string|max:10',
            'lantai'     => 'sometimes|string|max:10',
            'zona'       => 'sometimes|string|max:10',
            'jenis_slot' => 'sometimes|in:reguler,disabilitas,motor',
            'status'     => 'sometimes|in:tersedia,terisi,dipesan,nonaktif',
            'id_sensor'  => 'sometimes|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $slot->update($request->only(['kode_slot', 'lantai', 'zona', 'jenis_slot', 'status', 'id_sensor']));

        return response()->json([
            'success' => true,
            'message' => 'Slot parkir berhasil diperbarui',
            'data'    => $slot,
        ]);
    }

    // DELETE /api/slot-parkir/{id} — admin
    public function destroy($id)
    {
        $slot = SlotParkir::find($id);

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Slot parkir tidak ditemukan',
            ], 404);
        }

        $slot->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slot parkir berhasil dihapus',
        ]);
    }
}
