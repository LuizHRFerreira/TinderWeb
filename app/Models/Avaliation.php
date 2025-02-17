<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliation extends Model
{
    use HasFactory;
    protected $fillable = [
        'avaliator_id',
        'avaliated_id',
        'like',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
