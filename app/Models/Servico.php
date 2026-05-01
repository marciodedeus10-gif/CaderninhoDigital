<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Servico extends Model
{
    use BelongsToUser;
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categoria',
        'validade_dias',
        'ativo'
    ];

    public function fichaTecnicas()
    {
        return $this->hasMany(FichaTecnica::class);
    }
}
