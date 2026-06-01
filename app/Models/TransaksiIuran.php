namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiIuran extends Model
{
    protected $table = 'transaksi_iuran'; // Sesuai nama tabel di MySQL
    
    // Matikan timestamps bawaan Laravel karena kamu pakai nama kolom sendiri
    public $timestamps = false; 

    // Daftar kolom yang bisa diisi (Mass Assignment)
    protected $fillable = ['user_id', 'nominal', 'bukti_bayar', 'status', 'tgl_bayar'];
}