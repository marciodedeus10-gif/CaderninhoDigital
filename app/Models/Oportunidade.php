<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Oportunidade extends Model
{
    use HasFactory;

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
