<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class FichaTecnica extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'produto_id',
        'servico_id',
        'materia_prima_id',
        'quantidade'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }

    public function materiaPrima()
    {
        return $this->belongsTo(MateriaPrima::class);
    }
}
