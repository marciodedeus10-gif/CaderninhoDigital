<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Venda extends Model
{
    use BelongsToUser;
    protected $table = 'vendas';

    protected $fillable = [
        'user_id',
        'cliente_id',
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

    public function getSubtotalAttribute()
    {
        return $this->itens->sum('subtotal');
    }

    public function recalcularTotal()
    {
        $this->total = $this->subtotal - ($this->desconto ?? 0);
        $this->save();
    }
}
