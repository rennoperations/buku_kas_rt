<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama kolom di file migrasi terbaru
    protected $fillable = [
        'user_id',
        'nama_warga',
        'periode',
        'nominal',
        'bukti_bayar',
        'catatan',
        'status',
    ];

    // Beritahu Laravel bahwa kolom verified_at adalah format tanggal/waktu
    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // ── RELASI DATABASE ──

    // 1. Transaksi ini milik 1 Warga (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 2. Transaksi ini diverifikasi oleh 1 Bendahara (User)
    public function bendahara()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}