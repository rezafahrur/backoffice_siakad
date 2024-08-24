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
        'paket_matakuliah_detail_id',
        'hr_id',
        'ruang_kelas_id',
        'jadwal_hari',
        'jadwal_jam_mulai',
        'jadwal_jam_akhir',
    ];

    public function paketMataKuliahDetail()
    {
        return $this->belongsTo(PaketMataKuliahDetail::class, 'paket_matakuliah_detail_id', 'id');
    }

    public function hr()
    {
        return $this->belongsTo(Hr::class, 'hr_id', 'id');
    }

    public function ruangKelas()
    {
        return $this->belongsTo(RuangKelas::class, 'ruang_kelas_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }
}
