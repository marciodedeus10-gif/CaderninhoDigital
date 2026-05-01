<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class MateriaPrima extends Model
{
    use BelongsToUser;

    protected $table = 'materia_primas';

    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'codigo_sku',
        'unidade_medida',
        'custo_unitario',
        'estoque_atual',
        'estoque_minimo',
        'fornecedor_id',
        'ativo'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function fichaTecnicas()
    {
        return $this->hasMany(FichaTecnica::class);
    }
}
