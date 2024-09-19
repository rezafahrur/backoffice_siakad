<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Config;

class Semester extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_semester';
    protected $fillable = [
        'kode_semester',
        'nama_semester',
        'tahun_awal',
        'tahun_akhir',
        'semester',
    ];

    // relasi one-to-many dengan tabel Kurikulum
    public function kurikulum()
    {
        return $this->hasMany(Kurikulum::class, 'semester', 'kode_semester');
    }

    // relasi ke periode perkuliahan
    public function periodePerkuliahan()
    {
        return $this->hasMany(PeriodePerkuliahan::class, 'semester_id', 'id');
    }

}
