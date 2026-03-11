<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('vendas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('vendas_id')->nullable();
        $table->unsignedBigInteger('produto_id');
        $table->integer('quantidade');
        $table->decimal('valor', 10,2);
        $table->decimal('desconto_item', 10,2)->nullable();
        $table->decimal('total', 10,2);
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
