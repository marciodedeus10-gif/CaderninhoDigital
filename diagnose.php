#!/usr/bin/env php
<?php
/**
 * Script de Diagnóstico - Sistema de Assinaturas
 * Executa verificações para identificar problemas
 */

echo "═══════════════════════════════════════════════════════════════\n";
echo "  🔍 DIAGNÓSTICO - SISTEMA DE ASSINATURAS\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$errors = [];
$warnings = [];

// 1. Verificar se Laravel está inicializado
echo "1️⃣  Verificando Laravel...\n";
if (!file_exists(__DIR__ . '/bootstrap/app.php')) {
    $errors[] = "Arquivo bootstrap/app.php não encontrado!";
} else {
    echo "   ✅ Laravel encontrado\n";
}

// 2. Verificar arquivo .env
echo "\n2️⃣  Verificando .env...\n";
if (!file_exists(__DIR__ . '/.env')) {
    $errors[] = ".env não existe! Execute: cp .env.example .env";
} else {
    echo "   ✅ .env existe\n";
    if (!file_exists(__DIR__ . '/.env.local')) {
        if (getenv('DB_CONNECTION') === false || getenv('APP_KEY') === false) {
            $warnings[] = "Variáveis de ambiente podem não estar carregadas";
        } else {
            echo "   ✅ Variáveis de ambiente carregadas\n";
        }
    }
}

// 3. Verificar migrations
echo "\n3️⃣  Verificando Migrations...\n";
$migrations_path = __DIR__ . '/database/migrations';
if (!is_dir($migrations_path)) {
    $errors[] = "Diretório de migrations não encontrado!";
} else {
    $migrations = array_diff(scandir($migrations_path), ['.', '..']);
    echo "   ✅ " . count($migrations) . " migrations encontradas\n";
    
    if (!in_array('2026_04_27_110000_create_planos_table.php', $migrations) ||
        !in_array('2026_04_27_110226_create_assinaturas_table.php', $migrations)) {
        $warnings[] = "Migrations de planos/assinaturas podem estar faltando";
    }
}

// 4. Verificar models
echo "\n4️⃣  Verificando Models...\n";
$models = [
    'app/Models/Plano.php',
    'app/Models/Assinatura.php',
    'app/Models/User.php'
];
foreach ($models as $model) {
    if (!file_exists(__DIR__ . '/' . $model)) {
        $errors[] = "Model não encontrado: $model";
    } else {
        echo "   ✅ " . basename($model) . " encontrado\n";
    }
}

// 5. Verificar Seeders
echo "\n5️⃣  Verificando Seeders...\n";
$seeders = [
    'database/seeders/PlanoSeeder.php',
    'database/seeders/RolePermissionSeeder.php'
];
foreach ($seeders as $seeder) {
    if (!file_exists(__DIR__ . '/' . $seeder)) {
        $warnings[] = "Seeder não encontrado: $seeder";
    } else {
        echo "   ✅ " . basename($seeder) . " encontrado\n";
    }
}

// 6. Verificar Controllers
echo "\n6️⃣  Verificando Controllers...\n";
$controllers = [
    'app/Http/Controllers/AssinaturaController.php',
    'app/Http/Controllers/UsuarioController.php'
];
foreach ($controllers as $controller) {
    if (!file_exists(__DIR__ . '/' . $controller)) {
        $warnings[] = "Controller não encontrado: $controller";
    } else {
        echo "   ✅ " . basename($controller) . " encontrado\n";
    }
}

// 7. Verificar Middleware
echo "\n7️⃣  Verificando Middleware...\n";
if (!file_exists(__DIR__ . '/app/Http/Middleware/CheckPlanoPermission.php')) {
    $warnings[] = "Middleware CheckPlanoPermission não encontrado";
} else {
    echo "   ✅ Middleware encontrado\n";
}

// 8. Verificar Composer
echo "\n8️⃣  Verificando Composer...\n";
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    $errors[] = "Vendor não está instalado! Execute: composer install";
} else {
    echo "   ✅ Vendor instalado\n";
}

// 9. Verificar spatie/laravel-permission
echo "\n9️⃣  Verificando Spatie Permission...\n";
if (!is_dir(__DIR__ . '/vendor/spatie/laravel-permission')) {
    $errors[] = "Spatie Permission não instalado! Execute: composer require spatie/laravel-permission";
} else {
    echo "   ✅ Spatie Permission instalado\n";
}

// Resumo
echo "\n═══════════════════════════════════════════════════════════════\n";
echo "  📊 RESUMO\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

if (count($errors) > 0) {
    echo "❌ ERROS ENCONTRADOS:\n";
    foreach ($errors as $i => $error) {
        echo "   " . ($i + 1) . ". $error\n";
    }
    echo "\n";
}

if (count($warnings) > 0) {
    echo "⚠️  AVISOS:\n";
    foreach ($warnings as $i => $warning) {
        echo "   " . ($i + 1) . ". $warning\n";
    }
    echo "\n";
}

if (count($errors) == 0 && count($warnings) == 0) {
    echo "✅ TUDO OK! Sistema pronto para testar.\n\n";
    echo "Próximos passos:\n";
    echo "   php artisan migrate\n";
    echo "   php artisan db:seed --class=PlanoSeeder\n";
    echo "   php artisan db:seed --class=RolePermissionSeeder\n";
    echo "   php artisan tinker\n";
} else if (count($errors) == 0) {
    echo "⚠️  Sistema pode funcionar, mas verificar os avisos.\n";
} else {
    echo "❌ Sistema não está pronto. Corrija os erros acima.\n";
}

echo "\n";
?>