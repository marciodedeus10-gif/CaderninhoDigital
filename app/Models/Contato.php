<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Contato extends Model
{
    use BelongsToUser;
    protected $fillable = [
        'nome',
        'email',
        'assunto',
        'mensagem'
    ];
}