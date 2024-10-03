<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkalaNilaiDetail extends Model
{
    use HasFactory;

    protected $table = 't_skala_nilai_detail';

    protected $fillable = [
        'skala_nilai_id',
        'bobot_minimum',
        'bobot_maksimum',
        'nilai_huruf',
        'nilai_indeks',
    ];

    public function skalaNilai()
    {
        return $this->belongsTo(SkalaNilai::class, 'skala_nilai_id');
    }
}
