<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_pendaftaran',
        'nama_lengkap',
        'no_hp_wa',
        'email',
        'alamat',
        'catatan_keterangan',
        'status',
    ];
}
