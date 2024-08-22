<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Krs extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'm_krs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mahasiswa_id',
        'paket_matakuliah_id',
        'status',
        'tgl_transfer',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function paketMatakuliah()
    {
        return $this->belongsTo(PaketMataKuliah::class, 'paket_matakuliah_id', 'id');
    }
}
