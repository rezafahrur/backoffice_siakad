<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'm_berita';

    protected $fillable = [
        'url_id',
        'views',
        'kategori_berita_id',
        'judul_berita',
        'path_photo',
        'isi_berita',
    ];

    public function kategoriBerita()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_berita_id', 'id');
    }
}
