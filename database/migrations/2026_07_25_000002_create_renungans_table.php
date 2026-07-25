<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('renungans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('pengkhotbah_penulis');
            $table->date('tanggal');
            $table->enum('kategori', ['Renungan Harian', 'Khotbah Minggu', 'Artikel'])->default('Renungan Harian');
            $table->text('isi');
            $table->string('video_url')->nullable();
            $table->string('ayat_alkitab')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renungans');
    }
};
