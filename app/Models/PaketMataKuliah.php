<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketMataKuliah extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_paket_matakuliah';

    protected $fillable = [
        'nama_paket_matakuliah',
        'program_studi_id',
        'semester',
        'status',
        'created_at',
        'updated_at',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }

    public function paketMataKuliahDetail()
    {
        return $this->hasMany(PaketMataKuliahDetail::class, 'paket_matakuliah_id', 'id');
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'paket_matakuliah_id', 'id');
    }

}
