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
        'paket_matakuliah_id',
    ];

    public function paketMataKuliah()
    {
        return $this->belongsTo(PaketMataKuliah::class, 'paket_matakuliah_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(JadwalDetail::class, 'jadwal_id', 'id');
    }
}
