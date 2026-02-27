<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ClienteController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/produtos-mais-vendidos', 
    [DashboardController::class, 'produtosMaisVendidos']
)->name('dashboard.produtos');

Route::resource('produtos', ProdutoController::class);
Route::resource('servicos', ServicoController::class);
Route::resource('vendas', VendaController::class);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('clientes', ClienteController::class);
Route::resource('contatos', ContatoController::class);
Route::resource('empresas', EmpresaController::class);

Route::get('/dashboard', function () {
    return "Bem-vindo ao Dashboard!";
})->middleware('auth')->name('dashboard');