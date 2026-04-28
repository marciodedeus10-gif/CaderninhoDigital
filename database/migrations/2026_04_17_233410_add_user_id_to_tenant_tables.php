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
        $tables = ['clientes', 'produtos', 'servicos', 'oportunidades', 'contatos'];

        // Pegar o primeiro usuário, se existir
        $firstUser = DB::table('users')->first();
        $defaultUserId = $firstUser ? $firstUser->id : null;

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'user_id')) {
                Schema::table($table, function (Blueprint $table_blueprint) {
                    $table_blueprint->unsignedBigInteger('user_id')->nullable()->after('id');
                });

                // Se existe um usuário, atualizar os registros existentes
                if ($defaultUserId) {
                    DB::table($table)->update(['user_id' => $defaultUserId]);
                }

                // Agora, alterar a coluna para não ser nula (opcional, mas recomendado) e adicionar a constraint
                // Se ainda assim der erro por dados órfãos, deixamos nullable ou fazemos cascade.
                Schema::table($table, function (Blueprint $table_blueprint) {
                    $table_blueprint->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['clientes', 'produtos', 'servicos', 'oportunidades', 'contatos'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table_blueprint) {
                $table_blueprint->dropForeign(['user_id']);
                $table_blueprint->dropColumn('user_id');
            });
        }
    }
};
