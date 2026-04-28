<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('preco_mensal', 10, 2);
            $table->decimal('preco_anual', 10, 2)->nullable();
            $table->integer('max_usuarios');
            $table->json('recursos'); // módulos e funcionalidades permitidas
            $table->json('limites'); // limites específicos (ex: max_clientes, max_produtos)
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos');
    }
};