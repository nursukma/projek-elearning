<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryNilai extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'temporary_nilai';
    protected $fillable = ['id_user', 'betul', 'soal'];
}
