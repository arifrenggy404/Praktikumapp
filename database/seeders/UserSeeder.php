<?php

namespace Database\Seeders;

use App\Models\Jemaat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Masukkan data fisik Jemaat sebagai Sekretaris jika belum ada
        $jemaat = Jemaat::firstOrCreate(
            ['nama_lengkap' => 'Martina Pauwila'],
            [
                'tempat_lahir' => 'Waingapu',
                'tanggal_lahir' => '1985-01-01',
                'alamat_domisili' => 'Kandara',
                'status_baptis' => 'Sudah',
                'status_sidi' => 'Sudah',
            ]
        );

        // 2. Buat akun login Sekretaris jika belum ada
        User::firstOrCreate(
            ['username' => 'sekretaris_kandara'],
            [
                'jemaat_id' => $jemaat->id,
                'password' => Hash::make('rahasia123'),
            ]
        );
    }
}