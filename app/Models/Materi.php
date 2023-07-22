<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'materi';
    protected $primaryKey = 'id';

    protected $fillable = ['kode_mapel', 'deskripsi', 'berkas'];

    public function fkMapelMateri(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'kode_mapel', 'kode_mapel');
    }
}
