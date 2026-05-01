<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Assinatura;

$users = User::all();

foreach ($users as $user) {
    if (!$user->assinatura) {
        Assinatura::create([
            'user_id' => $user->id,
            'plano_id' => 2, // Plano Prata com recurso 'compras'
            'status' => 'ativa',
            'data_inicio' => now(),
            'data_fim' => now()->addYear(),
            'data_renovacao' => now()->addYear(),
            'periodicidade' => 'anual',
            'valor' => 1499.00
        ]);
        echo "Assinatura criada para usuário {$user->email}\n";
    } else {
        echo "Usuário {$user->email} já tem assinatura\n";
    }
}

echo "Concluído.\n";