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
        'sks'
    ];
}
