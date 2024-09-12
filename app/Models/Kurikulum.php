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
        'semester',
        'sum_sks_lulus',
        'sum_sks_wajib',
        'sum_sks_pilihan',
        'kode_prodi',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'kode_prodi', 'kode_program_studi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester', 'kode_semester');
    }

}
