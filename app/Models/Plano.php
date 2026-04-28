<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco_mensal',
        'preco_anual',
        'max_usuarios',
        'recursos',
        'limites',
        'vantagens',
        'desvantagens',
        'ativo'
    ];

    protected $casts = [
        'recursos' => 'array',
        'limites' => 'array',
        'vantagens' => 'array',
        'desvantagens' => 'array',
        'preco_mensal' => 'decimal:2',
        'preco_anual' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function assinaturas()
    {
        return $this->hasMany(Assinatura::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function permiteRecurso($recurso)
    {
        return in_array($recurso, $this->recursos ?? []);
    }

    public function getLimite($chave)
    {
        return $this->limites[$chave] ?? null;
    }
}