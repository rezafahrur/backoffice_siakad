<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_prestasi';
    protected $fillable = [
        'mahasiswa_id',
        'program_studi_id',
        'jenis',
        'tingkat',
        'nama',
        'tahun',
        'penyelenggara',
        'peringkat',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }
}
