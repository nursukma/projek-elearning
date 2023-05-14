<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas'];

    public function fkSiswaKelas(): HasMany
    {
        return $this->hasMany(Siswa::class, 'id_kelas', 'id');
    }

    // public function fkUjianKelas(): HasMany
    // {
    //     return $this->hasMany(Ujian::class, 'id_kelas', 'id');
    // }
}