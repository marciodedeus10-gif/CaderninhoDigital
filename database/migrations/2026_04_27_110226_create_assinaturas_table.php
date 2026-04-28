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
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plano_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['ativa', 'cancelada', 'suspensa', 'expirada']);
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->date('data_renovacao');
            $table->enum('periodicidade', ['mensal', 'anual']);
            $table->decimal('valor', 10, 2);
            $table->json('configuracao')->nullable(); // configurações específicas da assinatura
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinaturas');
    }
};
