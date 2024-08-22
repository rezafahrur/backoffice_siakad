<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'm_kategori_berita';

    protected $fillable = [
        'kategori_berita',
    ];

    public function berita()
    {
        return $this->hasMany(Berita::class, 'kategori_berita_id', 'id');
    }

    
}
