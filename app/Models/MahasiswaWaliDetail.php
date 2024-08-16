<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaWaliDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_mahasiswa_wali_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mahasiswa_wali_id',
        'hp',
        'alamat_domisili',
        'pekerjaan',
        'penghasilan',
        'pendidikan'
    ];

    public function mahasiswaWali()
    {
        return $this->belongsTo(MahasiswaWali::class, 'mahasiswa_wali_id', 'id');
    }
}
