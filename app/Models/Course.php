<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $perPage = 15;
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'category_id',
        'price',
        'currency',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
