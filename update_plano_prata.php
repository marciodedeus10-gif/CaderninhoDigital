<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Plano;

// Atualizar plano Prata (ID 2) com o recurso 'compras'
$platinaPlan = Plano::find(2);

if ($platinaPlan) {
    $platinaPlan->recursos = [
        'clientes',
        'produtos',
        'servicos',
        'vendas',
        'compras',
        'estoque',
        'financeiro',
        'dashboard_completo',
        'relatorios_basicos',
        'multi_usuario'
    ];
    $platinaPlan->save();
    echo "✓ Plano Prata (ID 2) atualizado com sucesso!\n";
    echo "Recursos disponíveis: " . implode(', ', $platinaPlan->recursos) . "\n";
} else {
    echo "✗ Plano não encontrado\n";
}
