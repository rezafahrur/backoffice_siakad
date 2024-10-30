<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaRequestSurat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_request_surat';

    protected $fillable = [
        'mahasiswa_id',
        'semester_id',
        'jenis_surat',
        'catatan',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    // ambil semester
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
