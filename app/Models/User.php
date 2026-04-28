<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarAttribute(): ?string
    {
        return $this->attributes['foto'] ?? null;
    }

    public function setAvatarAttribute(?string $value): void
    {
        $this->attributes['foto'] = $value;
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    public function assinatura()
    {
        return $this->hasOne(Assinatura::class);
    }

    public function plano()
    {
        return $this->hasOneThrough(Plano::class, Assinatura::class, 'user_id', 'id', 'id', 'plano_id');
    }

    public function temAssinaturaAtiva()
    {
        return $this->assinatura && $this->assinatura->estaAtiva();
    }

    public function podeAcessarRecurso($recurso)
    {
        if (!$this->temAssinaturaAtiva()) {
            return false;
        }

        return $this->plano->permiteRecurso($recurso);
    }

    public function getLimite($chave)
    {
        if (!$this->temAssinaturaAtiva()) {
            return 0;
        }

        return $this->plano->getLimite($chave);
    }

    public function podeCriarUsuario()
    {
        if (!$this->temAssinaturaAtiva()) {
            return false;
        }

        $usuariosAtuais = User::where('user_id', $this->id)->count();
        return $usuariosAtuais < $this->plano->max_usuarios;
    }
}
