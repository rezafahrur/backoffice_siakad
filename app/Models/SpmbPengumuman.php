<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbPengumuman extends Model
{
    use HasFactory;

    protected $table = 'spmb_pengumuman';

    protected $fillable = [
        'judul',
        'gambar',
        'file_pengumuman',
        'deskripsi',
    ];
}