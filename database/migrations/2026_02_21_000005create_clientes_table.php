<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('bairro');
            $table->string('endereco');
            $table->string('cep');
            $table->string('numero');
            $table->string('telefone');
            $table->string('cidade');
            $table->timestamps(); // MUITO IMPORTANTE
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
