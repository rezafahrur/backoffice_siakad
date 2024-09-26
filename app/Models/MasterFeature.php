<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class MasterFeature extends Model
{
    use HasFactory;

    protected $table = 'm_feature';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'feature_id');
    }
}
