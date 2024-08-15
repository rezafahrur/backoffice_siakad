<?php

namespace App\Models;

use App\Models\Ktp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hr extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_hr';

    protected $fillable = [
        'ktp_id',
        'position_id',
        'nip',
        'gelar_depan',
        'nama',
        'gelar_belakang',
    ];

    /**
     * Relasi dengan model Ktp
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ktp()
    {
        return $this->belongsTo(Ktp::class, 'ktp_id');
    }

    /**
     * Relasi dengan model Position
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
