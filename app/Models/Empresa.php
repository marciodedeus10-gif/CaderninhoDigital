<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function contatos()
    {
        return $this->hasMany(Contato::class);
    }
}