<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketMataKuliahDetail extends Model
{
    use HasFactory;

    protected $table = 't_paket_matakuliah_detail';

    protected $fillable = [
        'paket_matakuliah_id',
        'matakuliah_id',
        'created_at',
        'updated_at'
    ];

    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matakuliah_id', 'id');
    }

    public function paketMataKuliah()
    {
        return $this->belongsTo(PaketMataKuliah::class, 'paket_matakuliah_id', 'id');
    }

    public function jadwalDetails()
    {
        return $this->hasMany(JadwalDetail::class, 'paket_matakuliah_detail_id');
    }
}
