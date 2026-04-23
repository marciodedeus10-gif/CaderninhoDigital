<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToUser
{
    /**
     * Boot the trait to add a global scope and observe creating event.
     */
    protected static function bootBelongsToUser()
    {
        // Aplica o global scope para sempre filtrar pelo usuário logado
        static::addGlobalScope('user_id', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where($builder->getQuery()->from . '.user_id', Auth::id());
            }
        });

        // Evento saving/creating para popular o user_id automaticamente
        static::creating(function ($model) {
            if (Auth::check() && empty($model->user_id)) {
                $model->user_id = Auth::id();
            }
        });
    }
}
