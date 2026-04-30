<?php

namespace App\Http\Controllers;

use App\Models\LokasiParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LokasiParkirController extends Controller
{
    // GET /api/lokasi-parkir
    public function index(Request $request)
    {
        $query = LokasiParkir::query();

        if ($request->has('aktif')) {
            $query->where('aktif', filter_var($request->aktif, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%');
        }

        $lokasi = $query->withCount('slotParkir')->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $lokasi,
        ]);
    }

    // GET /api/lokasi-parkir/{id}
    public function show($id)
    {
        $lokasi = LokasiParkir::with('slotParkir')->find($id);

        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi parkir tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $lokasi,
        ]);
    }

    // POST /api/lokasi-parkir — admin
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          => 'required|string|max:150',
            'alamat'        => 'required|string',
            'latitude'      => 'required|numeric|between:-90,90',
            'longitude'     => 'required|numeric|between:-180,180',
            'total_slot'    => 'required|integer|min:1',
            'harga_per_jam' => 'required|numeric|min:0',
            'jam_buka'      => 'required|date_format:H:i',
            'jam_tutup'     => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $lokasi = LokasiParkir::create([
            'id'            => Str::uuid(),
            'nama'          => $request->nama,
            'alamat'        => $request->alamat,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'total_slot'    => $request->total_slot,
            'harga_per_jam' => $request->harga_per_jam,
            'jam_buka'      => $request->jam_buka,
            'jam_tutup'     => $request->jam_tutup,
            'aktif'         => $request->input('aktif', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lokasi parkir berhasil ditambahkan',
            'data'    => $lokasi,
        ], 201);
    }

    // PUT /api/lokasi-parkir/{id} — admin
    public function update(Request $request, $id)
    {
        $lokasi = LokasiParkir::find($id);

        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi parkir tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'          => 'sometimes|string|max:150',
            'alamat'        => 'sometimes|string',
            'latitude'      => 'sometimes|numeric|between:-90,90',
            'longitude'     => 'sometimes|numeric|between:-180,180',
            'total_slot'    => 'sometimes|integer|min:1',
            'harga_per_jam' => 'sometimes|numeric|min:0',
            'jam_buka'      => 'sometimes|date_format:H:i',
            'jam_tutup'     => 'sometimes|date_format:H:i',
            'aktif'         => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $lokasi->update($request->only([
            'nama', 'alamat', 'latitude', 'longitude',
            'total_slot', 'harga_per_jam', 'jam_buka', 'jam_tutup', 'aktif',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Lokasi parkir berhasil diperbarui',
            'data'    => $lokasi,
        ]);
    }

    // DELETE /api/lokasi-parkir/{id} — admin
    public function destroy($id)
    {
        $lokasi = LokasiParkir::find($id);

        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi parkir tidak ditemukan',
            ], 404);
        }

        $lokasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lokasi parkir berhasil dihapus',
        ]);
    }
}
