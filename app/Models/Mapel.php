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

    protected $fillable = ['kode_mapel', 'nama_mapel'];

    public function fkMapelGuru(): HasMany
    {
        return $this->hasMany(Guru::class, 'id_mapel', 'kode_mapel');
    }
}
