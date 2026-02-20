<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categoria',
        'validade_padrao_dias',
        'recorrente',
        'ativo',
    ];
}
