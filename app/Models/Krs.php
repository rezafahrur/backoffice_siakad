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
        'status',
        'tgl_transfer',
        'kurikulum_id',
        'kelas_id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
