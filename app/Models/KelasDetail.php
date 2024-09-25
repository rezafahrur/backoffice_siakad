<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_kelas_detail';

    protected $fillable = [
        'kelas_id',
        'kurikulum_detail_id',
        'hr_id',
        'tatap_muka',
        'sks_ajar',
        'jenis_evaluasi',
        'description',
        'lingkup_kelas',
        'mode_kelas',
        'aktivitas_partisipatif',
        'hasil_proyek',
        'tugas',
        'quiz',
        'uts',
        'uas',

    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function kurikulumDetail()
    {
        return $this->belongsTo(KurikulumDetail::class, 'kurikulum_detail_id', 'id');
    }

    public function hr()
    {
        return $this->belongsTo(Hr::class, 'hr_id', 'id');
    }
}
