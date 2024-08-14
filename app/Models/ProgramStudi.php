<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang sesuai di database
    protected $table = 'm_program_studi';
    protected $fillable = ['kode_program_studi', 'nama_program_studi'];
}

