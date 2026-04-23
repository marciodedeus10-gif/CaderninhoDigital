<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Produto extends Model
{
    use BelongsToUser;
    protected $fillable = [
        'nome',
        'descricao',
        'codigo_sku',
        'estoque',
        'estoque_minimo',
        'unidade_medida',
        'preco',
        'preco_custo',
        'categoria',
        'validade_padrao_dias',
        'ativo',
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
