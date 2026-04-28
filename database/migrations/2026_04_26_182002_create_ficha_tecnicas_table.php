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
        Schema::create('ficha_tecnicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('produto_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('servico_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('materia_prima_id')->constrained('materia_primas')->onDelete('cascade');
            $table->decimal('quantidade', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_tecnicas');
    }
};
