<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_webs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gereja')->default('Gereja Kristen Sumba Jemaat Kandara');
            $table->string('singkatan_gereja')->default('GKS Kandara');
            $table->string('tagline_gereja')->default('Bertumbuh dalam Iman, Teguh dalam Pengharapan, dan Melayani dalam Kasih');

            $table->string('beranda_bg_foto')->nullable();
            $table->string('sambutan_nama')->default('Pdt. Andreas, S.Th');
            $table->string('sambutan_jabatan')->default('Pendeta Jemaat GKS Kandara');
            $table->text('sambutan_teks');
            $table->string('sambutan_foto')->nullable();
            
            $table->text('ayat_emas_teks');
            $table->string('ayat_emas_kitab')->default('Matius 18:20');
            
            $table->text('sejarah_gereja');
            $table->text('visi_gereja');
            $table->text('misi_gereja');
            
            $table->text('alamat_gereja');
            $table->string('no_wa_gereja')->default('081234567890');
            $table->string('email_gereja')->default('info@gkskandara.or.id');
            $table->text('maps_embed_url')->nullable();
            
            $table->string('pj_komisi_anak')->default('Ibu Maria & Tim Guru SM');
            $table->string('pj_komisi_pemuda')->default('Bpk. Yohanes & Pengurus Pemuda');
            $table->string('pj_komisi_wanita')->default('Ibu Martha & Pengurus PW');
            $table->string('pj_komisi_lansia')->default('Penatua Pendamping Lansia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_webs');
    }
};
