<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{

    protected $fillable = [
        'venda_id',
        'produto_id',
        'servico_id',
        'quantidade',
        'preco',
        'subtotal'
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}
