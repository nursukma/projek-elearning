<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'guru';
    protected $primaryKey = 'nip';

    protected $fillable = ['nip', 'nama_guru', 'tlp_guru', 'alamat_guru', 'jk_guru', 'id_mapel', 'id_users'];

    public function fkMapelGuru(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'kode_mapel');
    }

    public function fkUjianGuru(): HasMany
    {
        return $this->hasMany(Ujian::class, 'nip', 'nip');
    }

    public function fkGuruUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id');
    }
}
