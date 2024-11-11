<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUjianDetail extends Model
{
    use HasFactory;

    //table t_jadwal_ujian_detail

    protected $table = 't_jadwal_ujian_detail';

    protected $fillable = [
        'id',
        'jadwal_ujian_id',
        'matakuliah_id',
        'ruang_kelas_id',
        'kode_jadwal_ujian',
        'tanggal',
        'jam_mulai',
        'jam_akhir',
    ];

    public function jadwal_ujian()
    {
        return $this->belongsTo(JadwalUjian::class, 'jadwal_ujian_id', 'id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }

    public function ruang_kelas()
    {
        return $this->belongsTo(RuangKelas::class, 'ruang_kelas_id', 'id');
    }
    
}
