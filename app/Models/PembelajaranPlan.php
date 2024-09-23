<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelajaranPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_pembelajaran_plan';

    protected $fillable = [
        'id',
        'matakuliah_id',
        'program_studi_id',
    ];

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(PembelajaranPlanDetail::class, 'pembelajaran_plan_id', 'id');
    }
}
