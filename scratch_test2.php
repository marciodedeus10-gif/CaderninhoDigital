<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::latest()->first();
dump($user->plano()->toSql());
dump($user->plano()->getBindings());
dump($user->assinatura->toArray());
dump($user->plano->toArray());
