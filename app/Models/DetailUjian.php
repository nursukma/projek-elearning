<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Casts\Attribute;

class DetailUjian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'detail_ujian';

    protected $fillable = ['id_ujian', 'pertanyaan_ujian', 'lampiran', 'option_ujian', 'jawaban_ujian', 'level'];

    public function fkDetUjianUjian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'id_ujian', 'id_ujian');
    }

    // For save json data types
    protected function option_ujian(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    // protected $casts = ['option_jawaban' => 'array'];
}
