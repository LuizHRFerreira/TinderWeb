<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class characteristics extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'app_id',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}

