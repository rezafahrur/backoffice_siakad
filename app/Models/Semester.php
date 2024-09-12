<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Config;

class Semester extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_semester';
    protected $fillable = [
        'kode_semester',
        'nama_semester',
        'tahun_awal',
        'tahun_akhir',
        'semester',
    ];

}
