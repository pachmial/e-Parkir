<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    // GET /api/pembayaran?pemesanan_id=xxx
    public function index(Request $request)
    {
        $query = Pembayaran::with('pemesanan');

        if ($request->has('pemesanan_id')) {
            $query->where('pemesanan_id', $request->pemesanan_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pembayaran = $query->orderByDesc('dibuat_pada')->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $pembayaran,
        ]);
    }

    // GET /api/pembayaran/{id}
    public function show($id)
    {
        $pembayaran = Pembayaran::with('pemesanan')->find($id);

        if (!$pembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pembayaran tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pembayaran,
        ]);
    }

    // POST /api/pembayaran
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pemesanan_id' => 'required|uuid|exists:pemesanan,id',
            'jumlah'       => 'required|numeric|min:0',
            'metode'       => 'required|in:transfer,qris,e-wallet,tunai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Cek pemesanan belum dibayar
        $sudahAda = Pembayaran::where('pemesanan_id', $request->pemesanan_id)
            ->where('status', 'berhasil')
            ->exists();

        if ($sudahAda) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan ini sudah dibayar',
            ], 409);
        }

        $pembayaran = Pembayaran::create([
            'id'                    => Str::uuid(),
            'pemesanan_id'          => $request->pemesanan_id,
            'jumlah'                => $request->jumlah,
            'metode'                => $request->metode,
            'status'                => 'menunggu',
            'referensi_pembayaran'  => 'REF-' . strtoupper(Str::random(10)),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dibuat',
            'data'    => $pembayaran,
        ], 201);
    }

    // PUT /api/pembayaran/{id}/konfirmasi — admin atau callback payment gateway
    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pembayaran tidak ditemukan',
            ], 404);
        }

        if ($pembayaran->status !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Status pembayaran tidak valid untuk dikonfirmasi',
            ], 400);
        }

        $pembayaran->update([
            'status'      => 'berhasil',
            'dibayar_pada' => now(),
        ]);

        // Update status pemesanan menjadi aktif
        Pemesanan::where('id', $pembayaran->pemesanan_id)
            ->update(['status' => 'aktif']);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi',
            'data'    => $pembayaran,
        ]);
    }
}
