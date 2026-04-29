<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function index() {
        $qr = QrCode::size(200)->generate('https://example.com');
        return view ('qrcode', compact('qr'));
    }

}
