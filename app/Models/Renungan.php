<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'pengkhotbah_penulis',
        'tanggal',
        'kategori',
        'isi',
        'video_url',
        'ayat_alkitab',
    ];
}
