<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjekUjian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'subjek_ujian';

    protected $fillable = ['no_ujian', 'nis_peserta', 'nilai'];

    public function fkSubjekUjian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'no_ujian', 'id_ujian');
    }

    public function fkSubjekSiswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'nis_peserta', 'nis');
    }
}
