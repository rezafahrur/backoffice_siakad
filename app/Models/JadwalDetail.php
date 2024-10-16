<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "t_jadwal_detail";
    protected $primaryKey = 'id';

    protected $fillable = [
        'jadwal_id',
        'ruang_kelas_detail_id',
        'kelas_id',
        'kode_hr',
        'nama_matakuliah'
    ];

    public function ruangKelasDetail()
    {
        return $this->belongsTo(RuangKelasDetail::class, 'ruang_kelas_detail_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }
}
