<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KuisionerAkademik extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_kuisioner_akademik';

    protected $fillable = [
        'pertanyaan_kuisioner',
        'jawaban_kuisioner',
    ];
}
