<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacteristicsOptionsUsers extends Model
{
    //Aqui eu coloco oque eu quero que seja inserido no DB dessa tabela.
    use HasFactory;
    
    protected $fillable = [
    'users_id',
    'characteristics_id',
    'options_id',
    'i_am',
    'i_seek',
    ];

}
