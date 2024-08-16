<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 't_hr_detail';

    protected $fillable = [
        'master_hr_id',
        'hp',
        'otp',
    ];

    /**
     * Relasi dengan model Hr
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hr()
    {
        return $this->belongsTo(Hr::class, 'master_hr_id');
    }
}
