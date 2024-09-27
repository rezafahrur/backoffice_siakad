<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NilaiDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_nilai_detail';

    protected $fillable = [
        'nilai_id',
        'mahasiswa_id',
        'hasil_proyek',
        'quiz',
        'tugas',
        'uts',
        'uas',
        'aktivitas_partisipatif',
        'nilai_huruf',
        'nilai_indeks',
        'nilai_angka'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nilai_id', 'id');
    }
}


