<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KondisiBarangSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Bagus', 'Rusak', 'Dibuang'] as $kondisi) {
            \App\Models\KondisiBarang::firstOrCreate(['nama_kondisi' => $kondisi]);
        }
    }
}