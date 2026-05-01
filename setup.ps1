# Script Setup - PowerShell
# Para executar: powershell -ExecutionPolicy Bypass -File .\setup.ps1

Write-Host ""
Write-Host "╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║       SETUP - SISTEMA DE ASSINATURAS E PLANOS             ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

$errors = @()

# Função para executar comando
function Execute-Command {
    param(
        [string]$Command,
        [string]$Description,
        [int]$Step
    )
    
    Write-Host "[$Step/3] $Description" -ForegroundColor Yellow
    Write-Host "Executando: $Command" -ForegroundColor Gray
    Write-Host ""
    
    try {
        Invoke-Expression $Command 2>&1
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Sucesso!" -ForegroundColor Green
            Write-Host ""
            return $true
        } else {
            Write-Host "⚠️  Possível erro (código: $LASTEXITCODE)" -ForegroundColor Yellow
            Write-Host ""
            return $false
        }
    } catch {
        Write-Host "❌ Erro: $_" -ForegroundColor Red
        Write-Host ""
        $errors += $_
        return $false
    }
}

# 1. Migrations
Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Blue
Execute-Command "php artisan migrate" "Criando tabelas no banco de dados" 1
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Blue

# 2. PlanoSeeder
Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Blue
Execute-Command "php artisan db:seed --class=PlanoSeeder" "Populando planos (Autônomo, Pequena Empresa, Empresa)" 2
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Blue

# 3. RolePermissionSeeder
Write-Host ""
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Blue
Execute-Command "php artisan db:seed --class=RolePermissionSeeder" "Criando roles e permissões" 3
Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Blue

# Resumo
Write-Host ""
Write-Host "╔════════════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║                    ✅ SETUP CONCLUÍDO!                     ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════════════╝" -ForegroundColor Green
Write-Host ""

if ($errors.Count -eq 0) {
    Write-Host "🎉 Tudo foi configurado com sucesso!" -ForegroundColor Green
} else {
    Write-Host "⚠️  Alguns avisos foram encontrados, mas o sistema pode funcionar" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "PRÓXIMAS AÇÕES:" -ForegroundColor Cyan
Write-Host ""
Write-Host "1️⃣  Inicie o servidor Laravel:" -ForegroundColor Yellow
Write-Host "   php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "2️⃣  Abra no navegador:" -ForegroundColor Yellow
Write-Host "   http://127.0.0.1:8000/assinaturas" -ForegroundColor Cyan
Write-Host ""
Write-Host "3️⃣  Ou teste no Tinker:" -ForegroundColor Yellow
Write-Host "   php artisan tinker" -ForegroundColor White
Write-Host "   > App\Models\Plano::count()" -ForegroundColor Gray
Write-Host "   => 3  # Deve aparecer 3 planos" -ForegroundColor Green
Write-Host ""
Write-Host "═══════════════════════════════════════════════════════════" -ForegroundColor Gray
Write-Host ""

Write-Host "Pressione qualquer tecla para sair..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
