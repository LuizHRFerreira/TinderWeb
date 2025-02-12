<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'characteristics_id',
        'name',
    ];

    public function characteristics()
    {
        return $this->belongsTo(Characteristics::class);
    }
}
