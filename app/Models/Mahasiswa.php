<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ktp_id',
        'program_studi_id',
        'nim',
        'nama',
        'registrasi_tanggal',
        'status',
    ];
}
