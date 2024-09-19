<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_mahasiswa_detail';
    protected $fillable = [
        'mahasiswa_id',
        'hp',
        'alamat_domisili',
        'telp_rumah',
        'kode_pos'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }
}
