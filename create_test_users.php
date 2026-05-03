<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Assinatura;
use App\Models\Plano;

// Planos disponíveis
$planos = Plano::all();

$testUsers = [
    [
        'name' => 'Teste Bronze',
        'email' => 'bronze@test.com',
        'password' => bcrypt('123456'),
        'plano_id' => 1 // Bronze
    ],
    [
        'name' => 'Teste Prata',
        'email' => 'prata@test.com',
        'password' => bcrypt('123456'),
        'plano_id' => 2 // Prata
    ],
    [
        'name' => 'Teste Ouro',
        'email' => 'ouro@test.com',
        'password' => bcrypt('123456'),
        'plano_id' => 3 // Ouro
    ],
    [
        'name' => 'Admin Teste',
        'email' => 'admin@test.com',
        'password' => bcrypt('123456'),
        'plano_id' => 3 // Ouro
    ]
];

foreach ($testUsers as $testUser) {
    $plano_id = $testUser['plano_id'];
    unset($testUser['plano_id']);
    
    // Verificar se usuário já existe
    $user = User::where('email', $testUser['email'])->first();
    
    if (!$user) {
        $user = User::create($testUser);
        echo "✓ Usuário criado: {$user->email}\n";
    } else {
        echo "⚠ Usuário já existe: {$user->email}\n";
    }
    
    // Criar ou atualizar assinatura
    $assinatura = $user->assinatura;
    if (!$assinatura) {
        /* Busca o plano para obter o preço */
        $plano = Plano::find($plano_id);
        $valorPlano = $plano ? $plano->preco_mensal : 0.00;
        Assinatura::create([
            'user_id' => $user->id,
            'plano_id' => $plano_id,
            'status' => 'ativa',
            'data_inicio' => now(),
            'data_fim' => now()->addYear(),
            'data_renovacao' => now()->addYear(),
            'periodicidade' => 'anual',
            'valor' => $valorPlano
        ]);
        echo "  → Assinatura criada com Plano ID: {$plano_id}\n";
    } else {
        $assinatura->update(['plano_id' => $plano_id, 'status' => 'ativa']);
        echo "  → Assinatura atualizada com Plano ID: {$plano_id}\n";
    }
}

echo "\n=== USUÁRIOS DE TESTE CRIADOS ===\n";
echo "Bronze: bronze@test.com | Senha: 123456\n";
echo "Prata: prata@test.com | Senha: 123456\n";
echo "Ouro: ouro@test.com | Senha: 123456\n";
echo "Admin: admin@test.com | Senha: 123456\n";
echo "===================================\n";
