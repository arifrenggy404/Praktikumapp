<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jemaat extends Model
{
    use HasFactory;

    protected $table = 'jemaats';
    protected $fillable = [
        'kartu_keluarga_id', 'nama_lengkap', 'jenis_kelamin', 'peran_keluarga', 'tempat_lahir', 'tanggal_lahir', 
        'alamat_domisili', 'no_hp', 'status_baptis', 'status_sidi', 
        'tanggal_baptis', 'tanggal_sidi', 'nama_orang_tua', 'file_dokumen'
    ];

    // Accessor Otomatis Hitung Kategori Usia
    protected function kategoriUsia(): Attribute
    {
        return Attribute::make(
            get: function () {
                $usia = Carbon::parse($this->tanggal_lahir)->age;
                if ($usia <= 16) return 'Anak & Remaja';
                if ($usia >= 17 && $usia < 50) return 'Pemuda / Dewasa';
                return 'Lansia';
            }
        );
    }

    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function userAccount(): HasOne
    {
        return $this->hasOne(User::class, 'jemaat_id');
    }

    public function jadwalPelayanan(): BelongsToMany
    {
        return $this->belongsToMany(JadwalPelayanan::class, 'pelayan_jadwal', 'jemaat_id', 'jadwal_id')
                    ->withPivot('peran');
    }

    public function pelayan(): HasOne
    {
        return $this->hasOne(Pelayan::class, 'jemaat_id');
    }
}
