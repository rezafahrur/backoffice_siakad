<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_kelas';

    protected $fillable = [
        'program_studi_id',
        'semester_id',
        'kurikulum_id',
        'nama_kelas',
        'kapasitas',
        'tanggal_mulai',
        'tanggal_akhir',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(KelasDetail::class, 'kelas_id', 'id');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'kelas_id', 'id');
    }
}
