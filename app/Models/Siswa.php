<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'siswa';

    protected $fillable = ['nis', 'nama_siswa', 'tlp_siswa', 'alamat_siswa', 'jk_siswa', 'id_kelas', 'id_user'];

    public function fkSiswaKelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function fkSiswaUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function fkSubjekSiswa(): HasMany
    {
        return $this->hasMany(SubjekUjian::class, 'nis_peserta', 'nis');
    }
}
