<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanWeb extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gereja',
        'singkatan_gereja',
        'tagline_gereja',
        'beranda_bg_foto',
        'sambutan_nama',
        'sambutan_jabatan',
        'sambutan_teks',
        'sambutan_foto',
        'ayat_emas_teks',
        'ayat_emas_kitab',
        'sejarah_gereja',
        'visi_gereja',
        'misi_gereja',
        'alamat_gereja',
        'no_wa_gereja',
        'email_gereja',
        'maps_embed_url',
        'pj_komisi_anak',
        'pj_komisi_pemuda',
        'pj_komisi_wanita',
        'pj_komisi_lansia',
    ];
}
