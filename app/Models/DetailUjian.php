<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailUjian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'detail_ujian';

    protected $fillable = ['id_ujian', 'pertanyaan_ujian', 'lampiran', 'option_ujian', 'jawaban_ujian'];

    public function fkDetUjianUjian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'id_ujian', 'id_ujian');
    }

    public function fkLampiranDetUjian(): HasMany
    {
        return $this->hasMany(Lampiran::class, 'lampiran', 'id');
    }
}
