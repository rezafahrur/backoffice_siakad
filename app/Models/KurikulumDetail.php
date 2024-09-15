<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KurikulumDetail extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 't_kurikulum_detail';

    protected $fillable = [
        'kurikulum_id',
        'matakuliah_id',
    ];

    // relation to matakuliah
    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matakuliah_id', 'id');
    }

    // relation to kurikulum
    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'id');
    }
}
