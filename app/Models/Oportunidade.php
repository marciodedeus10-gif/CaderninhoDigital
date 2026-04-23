<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToUser;

class Oportunidade extends Model
{
    use HasFactory, BelongsToUser;

    protected $table = 'oportunidades';

    protected $fillable = [
        'cliente_id',
        'tipo',
        'descricao',
        'data_contato'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
