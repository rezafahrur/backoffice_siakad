<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nilai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_nilai';

    protected $fillable = [
        'program_studi_id',
        'kelas_id',
        'matakuliah_id',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(NilaiDetail::class, 'nilai_id', 'id');
    }
}
