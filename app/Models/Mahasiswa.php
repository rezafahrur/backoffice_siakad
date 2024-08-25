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
        'nisn',
        'email',
        'jurusan_id',
        'program_studi_id',
        'nim',
        'nama',
        'registrasi_tanggal',
        'status',
        'nama_kontak_darurat',
        'hubungan_kontak_darurat',
        'hp_kontak_darurat',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }

    public function ktp()
    {
        return $this->belongsTo(Ktp::class, 'ktp_id', 'id');
    }

    public function mahasiswaWali()
    {
        return $this->hasMany(MahasiswaWali::class, 'mahasiswa_id', 'id');
    }

    public function mahasiswaDetail()
    {
        return $this->hasOne(MahasiswaDetail::class, 'mahasiswa_id', 'id');
    }

    public function mahasiswaDetailDelete()
    {
        return $this->hasMany(MahasiswaDetail::class, 'mahasiswa_id', 'id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function krs(){
        return $this->hasMany(Krs::class, 'mahasiswa_id', 'id');
    }
}
