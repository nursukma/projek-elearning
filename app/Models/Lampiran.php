<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lampiran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'lampiran';

    protected $fillable = ['url_lampiran'];

    public function fkLampiranDetUjian(): BelongsTo
    {
        return $this->belongsTo(DetailUjian::class, 'lampiran', 'id');
    }
}
