<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LancamentoFinanceiro extends Model
{
    protected $fillable = [
    'user_id',
    'tipo',
    'descricao',
    'valor',
    'data_vencimento',
    'data_pagamento',
    'status',
    'venda_id',
    'compra_id'
];
}
