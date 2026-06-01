<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk "ngobrol" dengan AI
use App\Models\TransaksiIuran;       // Untuk simpan ke DB

class IuranController extends Controller
{
    // TAHAP 1: Kirim gambar ke FastAPI (OCR)
    public function scanStruk(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('bukti_bayar');

        // Bagian "Ngobrol" dengan AI
        $response = Http::timeout(30)->attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post('http://127.0.0.1:8001/api/ai/ocr-struk');

        if ($response->failed()) {
            return response()->json(['status' => 'error', 'pesan' => 'Gagal terhubung ke AI'], 503);
        }

        return response()->json($response->json());
    }

    // TAHAP 2: Simpan hasil konfirmasi ke Database
    public function simpanTransaksi(Request $request) 
    {
        // Validasi input
        $request->validate([
            'bukti_bayar'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nominal_konfirmasi' => 'required|numeric',
        ]);

        // Simpan gambar secara permanen
        $path = $request->file('bukti_bayar')->store('bukti_transfer', 'public');

        // Simpan ke database
        $transaksi = new TransaksiIuran();
        $transaksi->user_id     = 1; // User ID hardcoded untuk testing
        $transaksi->nominal     = (float) $request->input('nominal_konfirmasi');
        $transaksi->bukti_bayar = $path;
        $transaksi->status      = 'pending';
        $transaksi->save();

        return response()->json(['message' => 'Data berhasil disimpan']);
    }
}