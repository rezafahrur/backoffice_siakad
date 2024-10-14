<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangKelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_ruang_kelas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_ruang_kelas',
        'nama_ruang_kelas',
        'kapasitas',
    ];

    public function jadwalDetails()
    {
        return $this->hasMany(JadwalDetail::class, 'ruang_kelas_id');
    }

    public function ruangKelasDetail()
    {
        return $this->hasMany(RuangKelasDetail::class, 'ruang_kelas_id', 'id');
    }
}
