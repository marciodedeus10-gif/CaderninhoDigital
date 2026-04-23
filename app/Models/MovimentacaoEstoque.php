<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class MovimentacaoEstoque extends Model
{
    use BelongsToUser;

    protected $table = 'movimentacoes_estoque';

    protected $fillable = [
        'produto_id',
        'user_id',
        'tipo',
        'quantidade',
        'observacao'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
