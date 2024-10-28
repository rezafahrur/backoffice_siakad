<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Tentukan nama tabel yang sesuai di database
    protected $table = 'm_program_studi';
    protected $fillable = ['kode_program_studi', 'nama_program_studi', 'kode_prodi', 'nama_singkat'];

    // Relasi one-to-many dengan tabel Matakuliah
    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'program_studi_id', 'id');
    }

    // Relasi one-to-many dengan tabel Kurikulum
    public function kurikulum()
    {
        return $this->hasMany(Kurikulum::class, 'program_studi_id', 'id');
    }

    // relasi ke periode perkuliahan
    public function periodePerkuliahan()
    {
        return $this->hasMany(PeriodePerkuliahan::class, 'program_studi_id', 'id');
    }
}
