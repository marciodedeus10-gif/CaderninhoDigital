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
        Schema::create('materia_primas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('codigo_sku')->nullable();
            $table->string('unidade_medida');
            $table->decimal('custo_unitario', 10, 2);
            $table->decimal('estoque_atual', 10, 2);
            $table->decimal('estoque_minimo', 10, 2)->default(0);
            $table->foreignId('fornecedor_id')->nullable()->constrained('fornecedores')->onDelete('set null');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materia_primas');
    }
};
