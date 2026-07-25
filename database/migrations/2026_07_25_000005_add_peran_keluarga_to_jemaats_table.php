<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jemaats', function (Blueprint $table) {
            $table->enum('peran_keluarga', ['Kepala Keluarga (Ayah)', 'Istri (Ibu)', 'Anak', 'Anggota Keluarga Lain'])
                  ->default('Kepala Keluarga (Ayah)')
                  ->after('jenis_kelamin');
        });
    }

    public function down(): void
    {
        Schema::table('jemaats', function (Blueprint $table) {
            $table->dropColumn('peran_keluarga');
        });
    }
};
