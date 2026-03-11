<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'vendas_id',
        'produto_id',
        'quantidade',
        'valor',
        'desconto_item',
        'total'
    ];

    // Relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relacionamento com Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
