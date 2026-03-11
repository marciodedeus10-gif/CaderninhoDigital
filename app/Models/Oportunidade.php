<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oportunidade extends Model
{
    protected $fillable = [
        'cliente_id',
        'tipo',
        'descricao',
        'data_contato'
    ];
}
