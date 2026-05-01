<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plano_id',
        'status',
        'data_inicio',
        'data_fim',
        'data_renovacao',
        'periodicidade',
        'valor',
        'configuracao'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'data_renovacao' => 'date',
        'valor' => 'decimal:2',
        'configuracao' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function scopeAtiva($query)
    {
        return $query->where('status', 'ativa');
    }

    public function scopeExpirada($query)
    {
        return $query->where('status', 'expirada');
    }

    public function estaAtiva()
    {
        return $this->status === 'ativa' && $this->data_fim >= now();
    }

    public function diasParaExpirar()
    {
        return now()->diffInDays($this->data_fim, false);
    }
}