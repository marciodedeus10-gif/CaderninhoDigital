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
        Schema::create('lancamento_financeiros', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    $table->enum('tipo', ['receita', 'despesa']);
    $table->string('descricao');
    $table->decimal('valor', 10, 2);

    $table->date('data_vencimento');
    $table->date('data_pagamento')->nullable();

    $table->enum('status', ['pendente', 'pago', 'cancelado'])->default('pago');

    $table->foreignId('venda_id')->nullable()->constrained()->onDelete('cascade');
    $table->foreignId('compra_id')->nullable()->constrained()->onDelete('cascade');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lancamento_financeiros');
    }
};
