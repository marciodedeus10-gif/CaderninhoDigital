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
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard/produtos-mais-vendidos',
    [DashboardController::class, 'produtosMaisVendidos']
)->name('dashboard.produtos');

Route::resource('produtos', ProdutoController::class);
Route::resource('servicos', ServicoController::class);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('clientes', ClienteController::class);
Route::resource('contatos', ContatoController::class);
Route::resource('empresas', EmpresaController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::get('/perfil', [UserController::class, 'show'])->name('perfil.show');
Route::get('/perfil/edit', [UserController::class, 'edit'])->name('perfil.edit');
Route::put('/perfil/update', [UserController::class, 'update'])->name('perfil.update');
Route::delete('/perfil/delete', [UserController::class, 'destroy'])->name('perfil.delete');

Route::resource('vendas', VendaController::class);
Route::post('vendas/{venda}/item', [VendaController::class,'addItem'])->name('vendas.addItem');
Route::post('vendas/{venda}/status', [VendaController::class,'status'])->name('vendas.status');
