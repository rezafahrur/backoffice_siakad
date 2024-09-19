<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaWali extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_mahasiswa_wali';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mahasiswa_id',
        'ktp_id',
        'nama',
        'status_kewalian',
        'kebutuhan_khusus',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function ktp()
    {
        return $this->belongsTo(Ktp::class, 'ktp_id', 'id');
    }

    public function mahasiswaWaliDetail()
    {
        return $this->hasOne(MahasiswaWaliDetail::class, 'mahasiswa_wali_id', 'id');
    }

    public function mahasiswaWaliDetailDelete()
    {
        return $this->hasMany(MahasiswaWaliDetail::class, 'mahasiswa_wali_id', 'id');
    }
}
