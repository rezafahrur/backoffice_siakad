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
        return $this->hasOne(MahasiswaWali::class, 'mahasiswa_id', 'id');
    }

    public function mahasiswaDetail()
    {
        return $this->hasOne(MahasiswaDetail::class, 'mahasiswa_id', 'id');
    }
}
