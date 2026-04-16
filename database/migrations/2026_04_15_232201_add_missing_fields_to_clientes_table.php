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
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('estado')->nullable()->after('cidade');
            $table->string('cpf_cnpj')->nullable()->after('numero');
            $table->text('observacoes')->nullable()->after('cpf_cnpj');
            $table->boolean('ativo')->default(true)->after('observacoes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn(['estado', 'cpf_cnpj', 'observacoes', 'ativo']);
        });
    }

};
