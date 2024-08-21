<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

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

    public function province()
    {
        return $this->belongsTo(Province::class, 'alamat_prov_code', 'code');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'alamat_kotakab_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'alamat_kec_code', 'code');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'alamat_kel_code', 'code');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'ktp_id', 'id');
    }

    public function mahasiswaWali()
    {
        return $this->hasMany(MahasiswaWali::class, 'ktp_id', 'id');
    }
}
