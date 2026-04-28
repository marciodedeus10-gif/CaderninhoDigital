@echo off
REM Script de Setup Automático - Sistema de Assinaturas
REM Para Windows CMD

echo.
echo ================================================================
echo   SETUP - SISTEMA DE ASSINATURAS
echo ================================================================
echo.

REM Cores (simples para Windows)
setlocal enabledelayedexpansion

echo [1/3] Executando Migrations...
echo.
php artisan migrate
if %ERRORLEVEL% neq 0 (
    echo.
    echo [ERRO] Falha ao executar migrations!
    echo.
    pause
    exit /b 1
)

echo.
echo [2/3] Populando Planos...
echo.
php artisan db:seed --class=PlanoSeeder
if %ERRORLEVEL% neq 0 (
    echo.
    echo [ERRO] Falha ao popular planos!
    echo.
    pause
    exit /b 1
)

echo.
echo [3/3] Criando Roles e Permissoes...
echo.
php artisan db:seed --class=RolePermissionSeeder
if %ERRORLEVEL% neq 0 (
    echo.
    echo [ERRO] Falha ao criar roles e permissoes!
    echo.
    pause
    exit /b 1
)

echo.
echo ================================================================
echo   SUCESSO! Sistema configurado com sucesso!
echo ================================================================
echo.
echo Proximos passos:
echo.
echo 1. Inicie o servidor:
echo    php artisan serve
echo.
echo 2. Acesse no navegador:
echo    http://127.0.0.1:8000/assinaturas
echo.
echo 3. Ou use Tinker para criar usuario:
echo    php artisan tinker
echo.
pause