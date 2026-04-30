<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiParkir;

class BookingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */

        public function index(Request $request)
    {
        $lokasiId = $request->location;

        $lokasi = LokasiParkir::find($lokasiId);

        return view('booking', compact('lokasi'));
    }
    
    public function getSnapToken(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'ORDER-' . time();
        $grossAmount = (int) $request->input('total_bayar', 0);

        if ($grossAmount <= 0) {
            return response()->json(['error' => 'Jumlah tidak valid'], 422);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $request->input('nama', 'User'),
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'snapToken' => $snapToken,
            'order_id'  => $orderId,
        ]);
    }
}