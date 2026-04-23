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
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('codigo_sku')->nullable()->after('descricao');
            $table->integer('estoque')->default(0)->after('codigo_sku');
            $table->string('unidade_medida')->default('Un')->after('estoque');
            $table->decimal('preco_custo', 10, 2)->nullable()->after('preco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['codigo_sku', 'estoque', 'unidade_medida', 'preco_custo']);
        });
    }
};
