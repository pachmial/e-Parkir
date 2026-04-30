<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\SlotParkir;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PemesananController extends Controller
{
    // GET /api/pemesanan
    public function index(Request $request)
    {
        $query = Pemesanan::with(['slotParkir.lokasiParkir', 'kendaraan']);

        if ($request->has('pengguna_id')) {
            $query->where('pengguna_id', $request->pengguna_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pemesanan = $query->orderByDesc('dibuat_pada')->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $pemesanan,
        ]);
    }

    // GET /api/pemesanan/{id}
    public function show($id)
    {
        $pemesanan = Pemesanan::with([
            'slotParkir.lokasiParkir',
            'kendaraan',
            'pembayaran',
        ])->find($id);

        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pemesanan,
        ]);
    }

    // POST /api/pemesanan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id'  => 'required|uuid|exists:pengguna,id',
            'slot_id'      => 'required|uuid|exists:slot_parkir,id',
            'kendaraan_id' => 'required|uuid|exists:kendaraan,id',
            'waktu_mulai'  => 'required|date|after_or_equal:now',
            'catatan'      => 'nullable|string',
        ]);

            $booking = Pemesanan::create([
        'id' => Str::uuid(), // Sesuai tipe char(36) di foto DB kamu
        'pengguna_id' => auth()->id(),
        'slot_id' => $request->slot_id, // Dari pilihan di Foto 6
        'kendaraan_id' => $request->kendaraan_id, // ID kendaraan yang tadi diambil
        'kode_pemesanan' => 'ORDER-' . time(),
        'waktu_mulai' => $request->waktu_mulai,
        'total_harga' => $request->total_harga,
        'status' => 'menunggu'
    ]);

    Pembayaran::create([
        'id' => Str::uuid(),
        'pemesanan_id' => $booking->id,
        'jumlah' => $booking->total_harga,
        'metode' => 'Bank BCA',
        'status' => 'menunggu'
    ]);
        

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Cek slot tersedia
        $slot = SlotParkir::find($request->slot_id);
        if ($slot->status !== 'tersedia') {
            return response()->json([
                'success' => false,
                'message' => 'Slot parkir tidak tersedia',
            ], 409);
        }

        // Buat kode pemesanan unik
        $kodePemesanan = 'PRK-' . strtoupper(Str::random(8));

        $pemesanan = Pemesanan::create([
            'id'              => Str::uuid(),
            'pengguna_id'     => $request->pengguna_id,
            'slot_id'         => $request->slot_id,
            'kendaraan_id'    => $request->kendaraan_id,
            'kode_pemesanan'  => $kodePemesanan,
            'waktu_mulai'     => $request->waktu_mulai,
            'status'          => 'menunggu',
            'catatan'         => $request->catatan,
        ]);

        // Update status slot menjadi dipesan
        $slot->update(['status' => 'dipesan']);

return response()->json(['success' => true, 'booking_id' => $booking->id]);
    }

    // PUT /api/pemesanan/{id}/selesai
    public function selesai(Request $request, $id)
    {
        $pemesanan = Pemesanan::with('slotParkir.lokasiParkir')->find($id);

        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan',
            ], 404);
        }

        if ($pemesanan->status !== 'lunas') {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak sedang aktif',
            ], 400);
        }

        $waktuSelesai = now();
        $waktuMulai   = \Carbon\Carbon::parse($pemesanan->waktu_mulai);
        $durasiJam    = round($waktuMulai->diffInMinutes($waktuSelesai) / 60, 2);
        $hargaPerJam  = $pemesanan->slotParkir->lokasiParkir->harga_per_jam;
        $totalHarga   = max(1, ceil($durasiJam)) * $hargaPerJam;

        $pemesanan->update([
            'waktu_selesai' => $waktuSelesai,
            'durasi_jam'    => $durasiJam,
            'total_harga'   => $totalHarga,
            'status'        => 'selesai',
        ]);

        // Bebaskan slot kembali
        $pemesanan->slotParkir->update(['status' => 'tersedia']);

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan selesai',
            'data'    => $pemesanan,
        ]);
    }

    // PUT /api/pemesanan/{id}/batalkan
    public function batalkan($id)
    {
        $pemesanan = Pemesanan::find($id);

        if (!$pemesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan',
            ], 404);
        }

        if (!in_array($pemesanan->status, ['menunggu', 'aktif'])) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak dapat dibatalkan',
            ], 400);
        }

        $pemesanan->update(['status' => 'dibatalkan']);

        // Bebaskan slot
        SlotParkir::where('id', $pemesanan->slot_id)->update(['status' => 'tersedia']);

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dibatalkan',
        ]);
    }
}
