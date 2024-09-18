<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use App\Models\Ktp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hr extends Authenticatable
{
    use HasRoles;
    use HasFactory;
    use SoftDeletes;
    use Notifiable;


    protected $table = 'm_hr';

    protected $fillable = [
        'ktp_id',
        'position_id',
        'nip',
        'gelar_depan',
        'nama',
        'gelar_belakang',
        'photo_profile',
        'email',
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

    public function hrDetail()
    {
        return $this->hasOne(HrDetail::class, 'master_hr_id');
    }

    public function jadwalDetails()
    {
        return $this->hasMany(JadwalDetail::class, 'hr_id');
    }

    public function kelasDetails()
    {
        return $this->hasMany(KelasDetail::class, 'hr_id');
    }
}
