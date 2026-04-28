# Script de Teste - Sistema de Assinaturas
# Para Windows PowerShell

Write-Host "==============================================================="
Write-Host "  🚀 TESTE RÁPIDO - SISTEMA DE ASSINATURAS" -ForegroundColor Green
Write-Host "===============================================================" -ForegroundColor Green
Write-Host ""

# Função para executar comandos
function RunCommand {
    param(
        [string]$Command,
        [string]$Description
    )
    
    Write-Host "▶ $Description" -ForegroundColor Cyan
    Write-Host "  Executando: $Command" -ForegroundColor Gray
    Write-Host ""
    
    Invoke-Expression $Command
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "  ✅ Sucesso!" -ForegroundColor Green
    } else {
        Write-Host "  ❌ Erro! Código: $LASTEXITCODE" -ForegroundColor Red
    }
    Write-Host ""
}

# 1. Diagnóstico
Write-Host "PASSO 1: Diagnóstico do Sistema" -ForegroundColor Yellow
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Yellow
Write-Host ""

RunCommand "php diagnose.php" "Verificando arquivos necessários"

# 2. Composer Install
Write-Host ""
Write-Host "PASSO 2: Instalar Dependências" -ForegroundColor Yellow
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Yellow
Write-Host ""

$composer_check = Test-Path ".\vendor\autoload.php"
if ($composer_check) {
    Write-Host "✅ Vendor já instalado" -ForegroundColor Green
} else {
    RunCommand "composer install" "Instalando dependências (pode levar alguns minutos)"
}

# 3. Migrations
Write-Host ""
Write-Host "PASSO 3: Executar Migrations" -ForegroundColor Yellow
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Yellow
Write-Host ""

RunCommand "php artisan migrate" "Criando tabelas no banco de dados"

# 4. Seeders
Write-Host ""
Write-Host "PASSO 4: Executar Seeders" -ForegroundColor Yellow
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Yellow
Write-Host ""

RunCommand "php artisan db:seed --class=PlanoSeeder" "Populando planos (Autônomo, Pequena Empresa, Empresa)"

Write-Host ""

RunCommand "php artisan db:seed --class=RolePermissionSeeder" "Criando roles e permissões"

# 5. Teste com Tinker
Write-Host ""
Write-Host "PASSO 5: Teste com Tinker (Terminal Interativo)" -ForegroundColor Yellow
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Yellow
Write-Host ""

Write-Host "Vou executar testes automáticos no Tinker..." -ForegroundColor Cyan
Write-Host ""

# Criar arquivo de comando para Tinker
$tinker_commands = @"
# Ver planos
App\Models\Plano::all()->map(fn(`$p) => echo `$p->nome . `n);

# Criar usuário teste
`$user = App\Models\User::create([
    'name' => 'João Teste',
    'email' => 'joao.teste@example.com',
    'password' => Hash::make('senha123')
]);

# Criar assinatura
`$plano = App\Models\Plano::where('nome', 'Pequena Empresa')->first();
`$assinatura = App\Models\Assinatura::create([
    'user_id' => `$user->id,
    'plano_id' => `$plano->id,
    'status' => 'ativa',
    'data_inicio' => now(),
    'data_fim' => now()->addMonth(),
    'data_renovacao' => now()->addMonth(),
    'periodicidade' => 'mensal',
    'valor' => `$plano->preco_mensal
]);

# Atribuir role
`$user->assignRole('Administrador');

# Verificar
echo "✅ Usuário criado: " . `$user->email . `n;
echo "✅ Assinatura ativa: " . (`$user->temAssinaturaAtiva() ? 'SIM' : 'NÃO') . `n;
echo "✅ Role atribuído: " . `$user->getRoleNames()->implode(', ') . `n;

exit
"@

# Salvar em arquivo temporário
$tinker_file = "$env:TEMP\tinker_test.txt"
$tinker_commands | Out-File -FilePath $tinker_file -Encoding UTF8

# Executar Tinker com os comandos
Write-Host "Executando testes..." -ForegroundColor Cyan
Get-Content $tinker_file | php artisan tinker

Remove-Item $tinker_file -Force

# 6. Servidor de desenvolvimento
Write-Host ""
Write-Host "PASSO 6: Iniciar Servidor de Desenvolvimento" -ForegroundColor Yellow
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Yellow
Write-Host ""

Write-Host "Para testar no navegador, inicie o servidor:" -ForegroundColor Yellow
Write-Host ""
Write-Host "   php artisan serve" -ForegroundColor White -BackgroundColor Black
Write-Host ""
Write-Host "Depois acesse: http://127.0.0.1:8000/assinaturas" -ForegroundColor Green
Write-Host ""

# Fim
Write-Host ""
Write-Host "==============================================================="
Write-Host "  ✅ TESTES CONCLUÍDOS!" -ForegroundColor Green
Write-Host "===============================================================" -ForegroundColor Green
Write-Host ""
Write-Host "URLs para testar:" -ForegroundColor Yellow
Write-Host "  • Assinaturas: http://127.0.0.1:8000/assinaturas" -ForegroundColor Cyan
Write-Host "  • Usuários: http://127.0.0.1:8000/usuarios" -ForegroundColor Cyan
Write-Host "  • Dashboard: http://127.0.0.1:8000/dashboard" -ForegroundColor Cyan
Write-Host ""
Write-Host "Credenciais teste:" -ForegroundColor Yellow
Write-Host "  • Email: joao.teste@example.com" -ForegroundColor Cyan
Write-Host "  • Senha: senha123" -ForegroundColor Cyan
Write-Host ""