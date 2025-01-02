<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbPendaftar extends Model
{
    use HasFactory;

    protected $table = 'spmb_m_pendaftar';

    protected $fillable = [
        'user_id',
        'no_pendaftaran',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'desa',
        'kecamatan',
        'kota',
        'no_telepon',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
