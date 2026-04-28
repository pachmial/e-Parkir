<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
    // 1. Cek apakah slot masih tersedia (mencegah double booking)
    $isBooked = Booking::where('slot_id', $request->slot_id)
                        ->where('status', 'active')
                        ->exists();

    if ($isBooked) {
        return back()->with('error', 'Maaf, tempat ini baru saja dipesan orang lain!');
    }

    // 2. Simpan Data Booking
    $booking = Booking::create([
        'user_id' => auth()->id(),
        'slot_id' => $request->slot_id,
        'plat_nomor' => $request->inputPlat,
        'jam_awal' => $request->inputJamAwal,
        'jam_akhir' => $request->inputJamAkhir,
        'total_harga' => $request->total_harga,
        'status' => 'active'
    ]);

    // 3. Update status slot jadi Terisi (Occupied)
    Slot::where('id', $request->slot_id)->update(['is_occupied' => true]);

    return redirect('/halaman-berhasil');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
