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
        // Mengambil riwayat transaksi khusus warga yang login (sementara ambil semua dulu untuk dummy-nyata)
        $riwayat = Transaksi::orderBy('created_at', 'desc')->get();
        
        // Menghitung total kas yang disetujui (Approved)
        $totalKas = Transaksi::where('status', 'approved')->sum('nominal');

        return view('dashboardwarga', compact('riwayat', 'totalKas'));
    }

    /**
     * Menampilkan Halaman Bendahara dengan Data Nyata dari Database
     */
    public function indexBendahara()
    {
        // Ambil semua transaksi yang butuh verifikasi (pending) dan yang sudah selesai
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
        
        $totalKas = Transaksi::where('status', 'approved')->sum('nominal');
        $wargaLunas = Transaksi::where('status', 'approved')->where('periode', 'Juni 2025')->count();
        $wargaPending = Transaksi::where('status', 'pending')->count();

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
            
            // Kirim file gambar mentah langsung ke server AI Railway
            $response = Http::attach(
                'file', 
                file_get_contents($file->getRealPath()), 
                $file->getClientOriginalName()
            )->post(env('AI_SERVICE_URL') . '/api/v1/ocr'); // Sesuaikan endpoint route dari FastAPI-mu

            if ($response->successful()) {
                $result = $response->json();
                return response()->json([
                    'nominal_terdeteksi' => $result['nominal'] ?? null
                ]);
            }

            return response()->json(['message' => 'AI gagal mendeteksi nominal'], 422);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal terhubung ke server AI: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 2. Fungsi Menyimpan Pembayaran Warga ke Postgres Neon
     */
    public function simpanPembayaran(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|max:5120',
            'nominal_konfirmasi' => 'required|numeric|min:1',
            'catatan' => 'nullable|string'
        ]);

        try {
            // Simpan gambar bukti bayar ke folder storage/app/public/bukti_transfer
            $path = $request->file('bukti_bayar')->store('bukti_transfer', 'public');

            // Simpan record data ke Neon database
            Transaksi::create([
                'nama_warga' => 'Pak Ahmad Hidayat', // Sementara di-hardcode sebelum ada auth login
                'periode' => 'Juni 2025',
                'nominal' => $request->nominal_konfirmasi,
                'bukti_bayar' => $path,
                'catatan' => $request->catatan,
                'status' => 'pending'
            ]);

            return response()->json(['message' => 'Pembayaran berhasil dikirim!']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 3. Fungsi Aksi Verifikasi dari Bendahara
     */
    public function verifikasiBendahara(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:setuju,tolak'
        ]);

        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->status = $request->aksi === 'setuju' ? 'approved' : 'rejected';
            $transaksi->save();

            return response()->json(['message' => 'Status transaksi berhasil diperbarui!']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui verifikasi: ' . $e->getMessage()], 500);
        }
    }
}