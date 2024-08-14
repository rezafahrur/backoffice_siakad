<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mataKuliah extends Model
{
    use HasFactory;
    protected $table = "m_matakuliah";
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_matakuliah', 
        'nama_matakuliah', 
        'program_studi_id',
        'sks'
    ];
}