<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAkademik extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_tahun_akademik';
    protected $fillable = [
        'semester_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
