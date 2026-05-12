<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Fornecedor extends Model
{
    use BelongsToUser;

    protected $table = 'fornecedores';

    protected $casts = [
        'data_cadastro' => 'date',
        'valor_minimo' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
