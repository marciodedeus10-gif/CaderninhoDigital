<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::create(["name" => "Test", "email" => "test" . rand() . "@test.com", "password" => "password"]);
$p = App\Models\Plano::where("nome", "Ouro")->first();
$a = App\Models\Assinatura::create([
    "user_id" => $user->id,
    "plano_id" => $p->id,
    "status" => "ativa",
    "data_inicio" => now(),
    "data_fim" => now()->addMinutes(5),
    "data_renovacao" => now()->addMinutes(5),
    "periodicidade" => "mensal",
    "valor" => 0.00
]);
dump($a->toArray());
dump($user->temAssinaturaAtiva());
dump($user->plano->nome);
