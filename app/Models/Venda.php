<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

protected $fillable = [
    'user_id',
    'cliente_id',
    'produto_id',
    'valor',
    'desconto',
    'valor_total',
    'data_venda',
    'data_vencimento',
    'observacoes',
    'status',
    'total',
    'desconto_total'
];

public function cliente()
{
    return $this->belongsTo(Cliente::class);
}

public function itens()
{
    return $this->hasMany(ItemVenda::class);
}

}
