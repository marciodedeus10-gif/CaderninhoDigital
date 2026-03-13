<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'bairro',
        'endereco',
        'cep',
        'numero',
        'telefone',
        'cidade',
        'estado',
        'ativo'
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
