<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasMahasiswaBimbing extends Model
{
    use HasFactory;

    protected $table = 't_aktivitas_mahasiswa_bimbing_uji';

    protected $fillable = [
        'aktivitas_mahasiswa_id',
        'nidn_dosen',
        'nama_dosen',
        'jenis_peran',
        'urutan_pembimbing',
        'kategori_kegiatan',
    ];

    // Relasi dengan tabel m_aktivitas_mahasiswa
    public function aktivitasMahasiswa()
    {
        return $this->belongsTo(AktivitasMahasiswa::class, 'aktivitas_mahasiswa_id', 'id');
    }
}
