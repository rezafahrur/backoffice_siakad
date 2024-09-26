<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterFeature;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ];

    public function features()
    {
        return $this->belongsTo(MasterFeature::class, 'feature_id');
    }
}