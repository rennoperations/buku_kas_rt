<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class IuranController extends Controller
{
    /**
     * Menampilkan Halaman Warga dengan Data Riwayat Nyata
     */
    public function indexWarga()
    {
        try {
            $riwayat = Transaksi::orderBy('created_at', 'desc')->get();
            $totalKas = Transaksi::where('status', 'approved')->sum('nominal');
        } catch (\Exception $e) {
            $riwayat = collect([]);
            $totalKas = 0;
        }

        return view('dashboardwarga', compact('riwayat', 'totalKas'));
    }

    /**
     * Menampilkan Halaman Bendahara dengan Data Nyata dari Database
     */
    public function indexBendahara()
    {
        try {
            $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
            $totalKas = Transaksi::where('status', 'approved')->sum('nominal');
            $wargaLunas = Transaksi::where('status', 'approved')->where('periode', 'Juni 2025')->count();
            $wargaPending = Transaksi::where('status', 'pending')->count();
        } catch (\Exception $e) {
            $transaksi = collect([]);
            $totalKas = 0;
            $wargaLunas = 0;
            $wargaPending = 0;
        }

        return view('dashboardbendahara', compact('transaksi', 'totalKas', 'wargaLunas', 'wargaPending'));
    }

    /**
     * 1. Fungsi Scan Struk via Mesin AI Python di Railway
     */
    public function scanOCR(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|max:5120',
        ]);

        try {
            $file = $request->file('bukti_bayar');

            $response = Http::attach(
                'file',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post(env('AI_SERVICE_URL') . '/api/ai/ocr-struk');

            if ($response->successful()) {
                $result = $response->json();
                return response()->json([
                    'nominal_terdeteksi' => $result['nominal_terdeteksi'] ?? 0,
                    'status'             => $result['status'] ?? 'sukses',
                ]);
            }

            return response()->json([
                'nominal_terdeteksi' => 0,
                'status'             => 'gagal_mencari_total',
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'nominal_terdeteksi' => 0,
                'status'             => 'error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 2. Fungsi Menyimpan Pembayaran Warga ke Postgres Neon
     */
    public function simpanPembayaran(Request $request)
    {
        $request->validate([
            'bukti_bayar'        => 'required|image|max:5120',
            'nominal_konfirmasi' => 'required|numeric|min:1',
            'catatan'            => 'nullable|string',
        ]);

        try {
            $path = $request->file('bukti_bayar')->store('bukti_transfer', 'public');

            Transaksi::create([
                'nama_warga' => 'Pak Ahmad Hidayat', // Ganti dengan auth()->user()->name setelah ada login
                'periode'    => 'Juni 2025',
                'nominal'    => (int) $request->nominal_konfirmasi,
                'bukti_bayar'=> $path,
                'catatan'    => $request->catatan,
                'status'     => 'pending',
            ]);

            return response()->json(['message' => 'Pembayaran berhasil dikirim!']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 3. Fungsi Aksi Verifikasi dari Bendahara
     */
    public function verifikasiBendahara(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:setuju,tolak',
        ]);

        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->status = $request->aksi === 'setuju' ? 'approved' : 'rejected';
            $transaksi->save();

            return response()->json(['message' => 'Status transaksi berhasil diperbarui!']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui verifikasi: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function verifikasiPembayaran()
    {
        return view('verifikasipembayaran');
    }

    public function dataWarga()
    {
        return view('datawarga');
    }

    public function pemasukan()
    {
        return view('pemasukan');
    }

    public function laporan()
    {
        return view('laporan');
    }

    public function pengaturan()
    {
        return view('pengaturan');
    }
}