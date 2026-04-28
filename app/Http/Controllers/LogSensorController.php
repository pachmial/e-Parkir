<?php

namespace App\Http\Controllers;

use App\Models\LogSensor;
use App\Models\SlotParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LogSensorController extends Controller
{
    // GET /api/slot-parkir/{slotId}/log-sensor
    public function index($slotId)
    {
        $slot = SlotParkir::find($slotId);

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Slot parkir tidak ditemukan',
            ], 404);
        }

        $logs = LogSensor::where('slot_id', $slotId)
            ->orderByDesc('dicatat_pada')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data'    => $logs,
        ]);
    }

    // POST /api/log-sensor — dikirim oleh perangkat sensor/IoT
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slot_id'   => 'required|uuid|exists:slot_parkir,id',
            'id_sensor' => 'required|string|max:50',
            'status'    => 'required|in:tersedia,terisi',
            'jarak_cm'  => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Catat log
        $log = LogSensor::create([
            'id'        => Str::uuid(),
            'slot_id'   => $request->slot_id,
            'id_sensor' => $request->id_sensor,
            'status'    => $request->status,
            'jarak_cm'  => $request->jarak_cm,
        ]);

        // Update status slot secara realtime jika slot sedang tidak dipesan
        $slot = SlotParkir::find($request->slot_id);
        if ($slot && !in_array($slot->status, ['dipesan', 'nonaktif'])) {
            $slot->update([
                'status'             => $request->status,
                'terakhir_diperbarui' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Log sensor berhasil dicatat',
            'data'    => $log,
        ], 201);
    }
}
