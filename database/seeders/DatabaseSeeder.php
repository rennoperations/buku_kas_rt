<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Bendahara
        User::create([
            'name'     => 'Pak Ahmad Hidayat',
            'email'    => 'bendahara@kasrt.com',
            'password' => Hash::make('bendahara123'),
            'role'     => 'bendahara',
            'no_rumah' => null,
        ]);

        // Akun Warga (contoh)
        User::create([
            'name'     => 'Ibu Siti Rahmawati',
            'email'    => 'siti@kasrt.com',
            'password' => Hash::make('warga123'),
            'role'     => 'warga',
            'no_rumah' => 'A-01',
        ]);

        User::create([
            'name'     => 'Bapak Joko Susanto',
            'email'    => 'joko@kasrt.com',
            'password' => Hash::make('warga123'),
            'role'     => 'warga',
            'no_rumah' => 'A-02',
        ]);
    }
}
