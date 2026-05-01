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
        Schema::table('itens_compra', function (Blueprint $table) {
            $table->foreignId('materia_prima_id')->nullable()->constrained('materia_primas')->cascadeOnDelete();
            $table->string('tipo_item')->default('produto'); // 'produto' ou 'materia_prima'
            $table->foreignId('produto_id')->nullable()->change(); // Make nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itens_compra', function (Blueprint $table) {
            $table->dropForeign(['materia_prima_id']);
            $table->dropColumn('tipo_item');
            $table->foreignId('produto_id')->nullable(false)->change(); // Revert
        });
    }
};
