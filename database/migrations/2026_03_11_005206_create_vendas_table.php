<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('vendas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->decimal('valor_total', 10, 2)->default(0);
        $table->decimal('desconto', 10, 2)->default(0);
        $table->date('data_venda');
        $table->date('data_vencimento')->nullable();
        $table->string('status')->default('pendente');
        $table->text('observacoes')->nullable();
        $table->decimal('total',10,2)->default(0);
        $table->timestamps();
    });
}
};
