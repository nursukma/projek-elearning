<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ujian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'ujian';

    protected $primaryKey = 'id_ujian';
    public $incrementing = false;

    protected $fillable = ['id_ujian', 'kode_mapel', 'nama_ujian', 'waktu_mulai', 'waktu_akhir', 'nip'];

    public function fkUjianGuru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'nip', 'nip');
    }

    public function fkMapelUjian(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'kode_mapel', 'kode_mapel');
    }

    // public function fkUjianKelas(): BelongsTo
    // {
    //     return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    // }

    public function fkDetUjianUjian(): HasMany
    {
        return $this->hasMany(DetailUjian::class, 'id_ujian', 'id_ujian');
    }

    public function fkSubjekUjian(): HasMany
    {
        return $this->hasMany(SubjekUjian::class, 'no_ujian', 'id_ujian');
    }
}