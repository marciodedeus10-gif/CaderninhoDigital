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
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->string('cep')->nullable()->after('endereco');
            $table->date('data_cadastro')->nullable()->after('cep');
            $table->decimal('valor_minimo', 10, 2)->nullable()->after('data_cadastro');
        });
    }

    public function down(): void
    {
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->dropColumn(['cep', 'data_cadastro', 'valor_minimo']);
        });
    }
};
