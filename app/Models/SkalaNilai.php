<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkalaNilai extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 't_skala_nilai';
    protected $fillable = [
        'semester_id',
        'program_studi_id',
        'tgl_mulai_efektif',
        'tgl_akhir_efektif',
    ];

    // relasi many-to-one dengan tabel Semester
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    // relasi many-to-one dengan tabel ProgramStudi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    // SkalaNilai.php
    public function skalaNilaiDetail()
    {
        return $this->hasMany(SkalaNilaiDetail::class, 'skala_nilai_id');
    }

    public function details()
    {
        return $this->hasMany(SkalaNilaiDetail::class);
    }





}
