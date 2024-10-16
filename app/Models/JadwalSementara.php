<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalSementara extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_jadwal_sementara';

    protected $fillable = [
        'id',
        'kelas_id',
        'file',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
