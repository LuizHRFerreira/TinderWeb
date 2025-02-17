<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacteristicsOptionsUsers extends Model
{
    use HasFactory;

     //Aqui eu coloco oque eu quero que seja inserido no DB dessa tabela.
    protected $fillable = [
    'user_id',
    'i_am',
    'i_seek',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

}
