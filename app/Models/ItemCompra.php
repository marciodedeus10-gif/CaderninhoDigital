<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    protected $table = 'itens_compra';

    protected $fillable = [
        'compra_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'subtotal'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
