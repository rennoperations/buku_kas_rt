<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // --- TAMBAHKAN DUA BARIS INI ---
    protected $table = 'users'; 
    public $timestamps = false; 

    /**
     * The attributes that are mass assignable.
     * Sesuaikan dengan nama kolom yang ada di tabel 'users' milikmu
     */
    protected $fillable = [
        'nik',           // Ganti 'name' dengan 'nik'
        'nama_lengkap',  // Ganti 'email' dengan 'nama_lengkap'
        'password',
        'role',          // Tambahkan kolom yang ada di database
        'no_hp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
