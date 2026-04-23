<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Compra extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'fornecedor_id',
        'data_compra',
        'data_entrega',
        'total',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'data_compra' => 'date',
        'data_entrega' => 'date',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function itens()
    {
        return $this->hasMany(ItemCompra::class);
    }

    public function recalcularTotal()
    {
        $this->total = $this->itens()->sum('subtotal');
        $this->save();
    }
}
