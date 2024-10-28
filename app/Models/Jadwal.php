<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "m_jadwal";
    protected $primaryKey = 'id';

    protected $fillable = [
        'semester_id',
        'ruang_kelas_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function ruangKelas()
    {
        return $this->belongsTo(RuangKelas::class, 'ruang_kelas_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(JadwalDetail::class, 'jadwal_id', 'id');
    }
}
