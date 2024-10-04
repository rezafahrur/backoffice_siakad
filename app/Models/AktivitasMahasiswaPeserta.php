<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktivitasMahasiswaPeserta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_aktivitas_mahasiswa_peserta';
    protected $primaryKey = 'id';

    protected $fillable = [
        'aktivitas_mahasiswa_id',
        'program_studi_id',
        'mahasiswa_id',
        'matakuliah_id',
        'sks',
        'jenis_peran',
        'nilai_huruf',
        'nilai_indeks',
        'nilai_angka',
    ];

    public function aktivitasMahasiswa()
    {
        return $this->belongsTo(AktivitasMahasiswa::class, 'aktivitas_mahasiswa_id', 'id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }  
}
