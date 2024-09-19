<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodePerkuliahan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_periode_perkuliahan';

    protected $fillable = [
        'semester_id', 
        'program_studi_id',
        'tanggal_awal_kuliah', 
        'tanggal_akhir_kuliah',
        'jml_target_mhs_baru', 
        'jml_pendaftar_ikut_seleksi', 
        'jml_pendaftar_lulus_seleksi',
        'jml_daftar_ulang', 
        'jml_mengundurkan_diri', 
        'jml_minggu_pertemuan', 
    ];

    protected $casts = [
        'tanggal_awal_kuliah' => 'datetime',
        'tanggal_akhir_kuliah' => 'datetime',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }
}
