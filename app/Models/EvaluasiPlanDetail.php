<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluasiPlanDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_evaluasi_plan_detail';

    protected $fillable = [
        'evaluasi_plan_id',
        'jenis_evaluasi',
        'nama_evaluasi',
        'desc_indo',
        'desc_eng',
        'bobot',
        'no_urut',
    ];

    public function evaluasiPlan()
    {
        return $this->belongsTo(EvaluasiPlan::class, 'evaluasi_plan_id', 'id');
    }
}
