<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Fornecedor extends Model
{
    use BelongsToUser;

    protected $table = 'fornecedores';

    protected $fillable = [
        'user_id',
        'nome',
        'cnpj_cpf',
        'telefone',
        'email',
        'endereco',
        'observacoes',
        'ativo'
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
