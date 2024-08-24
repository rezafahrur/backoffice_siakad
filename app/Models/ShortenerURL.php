<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenerURL extends Model
{
    use HasFactory;
    protected $connection = 'so_poltekbatu';
    protected $table = 'so_url';
    public $timestamps = false;
}
