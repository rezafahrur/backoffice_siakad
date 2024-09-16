<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProgramStudi;

class Kurikulum extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_kurikulum';

    protected $fillable = [
        'nama_kurikulum',
        'program_studi_id',
        'semester',
        'semester_angka',
        'sum_sks_lulus',
        'sum_sks_wajib',
        'sum_sks_pilihan',
        'status',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }

    public function semesters()
    {
        return $this->belongsTo(Semester::class, 'semester', 'kode_semester');
    }

    public function kurikulumDetails()
    {
        return $this->hasMany(KurikulumDetail::class, 'kurikulum_id', 'id');
    }

}
