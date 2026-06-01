<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_warga',
        'periode',
        'nominal',
        'bukti_bayar',
        'catatan',
        'status'
    ];
}