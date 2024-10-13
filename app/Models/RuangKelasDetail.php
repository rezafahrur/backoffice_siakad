<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuangKelasDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_ruang_kelas_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ruang_kelas_id',
        'hari',
        'jam_awal',
        'jam_akhir',
        'is_available',
    ];

    public function ruangKelas()
    {
        return $this->belongsTo(RuangKelas::class, 'ruang_kelas_id');
    }
}
