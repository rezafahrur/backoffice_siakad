<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelajaranPlanDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_pembelajaran_plan_detail';

    protected $fillable = [
        'pembelajaran_plan_id',
        'pertemuan',
        'materi_indo',
        'materi_eng',
    ];

    public function pembelajaranPlan()
    {
        return $this->belongsTo(PembelajaranPlan::class, 'pembelajaran_plan_id', 'id');
    }
}
