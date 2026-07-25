<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_pendaftaran', ['Baptis', 'Sidi', 'Pernikahan', 'Konseling', 'Permohonan Doa']);
            $table->string('nama_lengkap');
            $table->string('no_hp_wa');
            $table->string('email')->nullable();
            $table->text('alamat');
            $table->text('catatan_keterangan')->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Selesai', 'Ditolak'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
