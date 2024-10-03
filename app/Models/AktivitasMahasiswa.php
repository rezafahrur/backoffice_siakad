<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktivitasMahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_aktivitas_mahasiswa';

    protected $fillable = [
        'program_studi_id', 
        'semester_id', 
        'kode_aktivitas',
        'jenis_aktivitas', 
        'judul', 
        'lokasi',
        'nomor_sk_tugas',
        'tanggal_sk_tugas',
        'keterangan_aktivitas',
        'jenis_anggota',
        'tanggal_mulai', 
        'tanggal_selesai'
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}

