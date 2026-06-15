<?php

use App\Models\User;
use App\Models\Inventaris;
use App\Models\KondisiBarang;
use App\Models\JadwalPelayanan;
use Database\Seeders\KondisiBarangSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->seed(KondisiBarangSeeder::class);
});

test('inventaris search works', function () {
    $bagusId = KondisiBarang::where('nama_kondisi', 'Bagus')->first()->id;
    
    Inventaris::create([
        'nama_barang' => 'Kursi Jati',
        'jumlah_kuantitas' => 10,
        'kondisi_id' => $bagusId
    ]);
    
    Inventaris::create([
        'nama_barang' => 'Meja Kantor',
        'jumlah_kuantitas' => 5,
        'kondisi_id' => $bagusId
    ]);

    $this->actingAs($this->user)
        ->get(route('inventaris.index', ['search' => 'Kursi']))
        ->assertStatus(200)
        ->assertSee('Kursi Jati')
        ->assertDontSee('Meja Kantor');
});

test('jadwal pelayanan search works', function () {
    JadwalPelayanan::create([
        'nama_ibadah' => 'Ibadah Minggu',
        'tanggal_waktu' => now()->addDays(1)->format('Y-m-d H:i:s'),
        'lokasi_ibadah' => 'Gereja Pusat',
        'semester' => 'Jan-Jun 2026'
    ]);
    
    JadwalPelayanan::create([
        'nama_ibadah' => 'Pemuda',
        'tanggal_waktu' => now()->addDays(2)->format('Y-m-d H:i:s'),
        'lokasi_ibadah' => 'Aula',
        'semester' => 'Jan-Jun 2026'
    ]);

    $this->actingAs($this->user)
        ->get(route('jadwal.index', ['search' => 'Minggu']))
        ->assertStatus(200)
        ->assertSee('Ibadah Minggu')
        ->assertDontSee('Pemuda');

    $this->actingAs($this->user)
        ->get(route('jadwal.index', ['search' => 'Aula']))
        ->assertStatus(200)
        ->assertSee('Pemuda')
        ->assertDontSee('Ibadah Minggu');
});
