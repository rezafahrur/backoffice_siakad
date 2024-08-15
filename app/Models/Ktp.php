<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ktp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_ktp';
    protected $fillable = [
        'nik',
        'nama',
        'alamat_jalan',
        'alamat_rt',
        'alamat_rw',
        'alamat_prov_code',
        'alamat_kotakab_code',
        'alamat_kec_code',
        'alamat_kel_code',
        'lahir_tempat',
        'lahir_tgl',
        'jenis_kelamin',
        'agama',
        'golongan_darah',
        'kewarganegaraan'
    ];

}
