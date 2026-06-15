<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluargas';
    protected $fillable = ['no_kk_gereja', 'kepala_keluarga_id'];

    public function kepalaKeluarga(): BelongsTo
    {
        return $this->belongsTo(Jemaat::class, 'kepala_keluarga_id');
    }

    public function anggotaJemaat(): HasMany
    {
        return $this->hasMany(Jemaat::class, 'kartu_keluarga_id');
    }
}
