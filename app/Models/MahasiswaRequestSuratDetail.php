<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaRequestSuratDetail extends Model
{
    use HasFactory;

    protected $table = 't_request_surat_detail';

    protected $fillable = [
        'request_surat_id',
        'nama',
        'nip',
        'pangkat',
        'instansi',
    ];

    public function requestSurat()
    {
        return $this->belongsTo(MahasiswaRequestSurat::class, 'request_surat_id', 'id');
    }
}
