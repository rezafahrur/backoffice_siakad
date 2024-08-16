<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    // tabel m_position
    protected $table = 'm_position';

    // kolom yang bisa diisi posisi
    protected $fillable = ['posisi'];
}
