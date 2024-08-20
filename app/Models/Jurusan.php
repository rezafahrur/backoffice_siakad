<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_jurusan';

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
    ];
}
