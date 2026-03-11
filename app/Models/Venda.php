<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

protected $fillable = [
    'cliente_id',
    'data_venda',
    'status',
    'total'
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
