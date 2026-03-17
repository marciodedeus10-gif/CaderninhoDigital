<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'cliente_id',
        'user_id',
        'valor_total',
        'desconto',
        'data_venda',
        'data_vencimento',
        'status',
        'observacoes'
    ];

    public function itens()
    {
        return $this->hasMany(ItemVenda::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
