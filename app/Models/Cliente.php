<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'numero',
        'cpf_cnpj',
        'observacoes',
        'ativo'
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

}
