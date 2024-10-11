<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaKtm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_mahasiswa_ktm';

    protected $fillable = [
        'mahasiswa_id',
        'path_photo',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }
}
