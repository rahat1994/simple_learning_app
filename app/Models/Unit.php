<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'video_units';
    protected $fillable = [
        'name',
        'transcript',
        'is_active',
        'module_id',
        'src'
    ];
}
