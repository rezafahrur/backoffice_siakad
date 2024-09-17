<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataKuliah extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "m_matakuliah";
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_matakuliah',
        'nama_matakuliah',
        'program_studi_id',
        'jenis_matakuliah',
        'sks_tatap_muka',
        'sks_praktek',
        'sks_praktek_lapangan',
        'sks_simulasi',
        'metode_belajar',
        'tgl_mulai_efektif',
        'tgl_akhir_efektif',
        'status',
    ];

    // relation to kuriulum detail
    public function kurikulumDetails()
    {
        return $this->hasMany(KurikulumDetail::class, 'matakuliah_id', 'id');
    }
}
