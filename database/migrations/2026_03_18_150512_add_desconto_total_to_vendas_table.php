<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table->decimal('desconto', 10, 2)->default(0);
            $table->string('status')->default('aberta'); // 👈 ADICIONA AQUI
        });
    }

    public function down()
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table->dropColumn('desconto');
            $table->dropColumn('status'); // 👈 REMOVE CORRETAMENTE
        });
    }
};
