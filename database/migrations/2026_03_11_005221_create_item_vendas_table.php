<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('item_vendas', function (Blueprint $table) {

        $table->id();

        $table->foreignId('venda_id')->constrained()->cascadeOnDelete();

        $table->foreignId('produto_id')->nullable()->constrained()->nullOnDelete();

        $table->foreignId('servico_id')->nullable()->constrained()->nullOnDelete();

        $table->integer('quantidade');

        $table->decimal('preco',10,2);

        $table->decimal('subtotal',10,2);

        $table->timestamps();

    });
}
};
