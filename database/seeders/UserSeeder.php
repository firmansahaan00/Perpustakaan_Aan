<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Petugas;
use App\Models\kepala_perpus;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ================= ANGGOTA =================
        $anggota = User::create([
            'name' => 'Indra Anggota',
            'email' => 'anggota@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'anggota',
        ]);

        Anggota::create([
            'user_id' => $anggota->id,
            'nis' => '1001',
            'kelas' => 'XII RPL 1',
        ]);

        // ================= PETUGAS =================
        $petugas = User::create([
            'name' => 'Budi Petugas',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'petugas',
        ]);

        Petugas::create([
            'user_id' => $petugas->id,
            'nip_petugas' => 'P001',
            'no_hp' => '08123456789',
        ]);

        // ================= KEPALA =================
        $kepala = User::create([
            'name' => 'Siti Kepala',
            'email' => 'kepala@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'kepala_perpus',
        ]);

        kepala_perpus::create([
            'user_id' => $kepala->id,
            'nip_kepala' => 'K001',
        ]);
    }
}
