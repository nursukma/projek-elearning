<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mapel';

    protected $primaryKey = 'kode_mapel';
    public $incrementing = false;

    protected $fillable = ['kode_mapel', 'nama_mapel'];

    public function fkMapelGuru(): HasMany
    {
        return $this->hasMany(Guru::class, 'id_mapel', 'kode_mapel');
    }

    public function fkMapelUjian(): HasMany
    {
        return $this->hasMany(Ujian::class, 'kode_mapel', 'kode_mapel');
    }
}
