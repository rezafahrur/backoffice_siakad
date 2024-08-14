<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangKelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_ruang_kelas';
    protected $fillable = [
        'kode_ruang_kelas',
        'nama_ruang_kelas',
        'kapasitas',
    ];
}
