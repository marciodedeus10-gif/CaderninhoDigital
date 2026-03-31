<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UserController;
use App\http\Controllers\QuemSomosController;
use App\Http\Controllers\ItemVendaController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;





//
// Rotas com autenticacao
//
Route::middleware('auth')->group(function () {

    // ADMIN

    Route::resource('produtos', ProdutoController::class);
    Route::resource('servicos', ServicoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('contatos', ContatoController::class);


    // USUÁRIO
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/perfil', [UserController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [UserController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/update', [UserController::class, 'update'])->name('perfil.update');
    Route::delete('/perfil/delete', [UserController::class, 'destroy'])->name('perfil.delete');

    Route::resource('vendas', VendaController::class);
    Route::post('vendas/{venda}/item', [VendaController::class,'addItem'])->name('vendas.addItem');
    Route::post('vendas/{venda}/addServico', [VendaController::class,'addServico'])->name('vendas.addServico');
    Route::post('vendas/{venda}/status', [VendaController::class,'status'])->name('vendas.status');
    Route::post('/vendas/{id}/desconto', [VendaController::class, 'updateDesconto'])
        ->name('vendas.updateDesconto');
    Route::put('/vendas/{id}/finalizar', [VendaController::class, 'finalizar'])
        ->name('vendas.finalizar');
    // Route::delete('/itens/{id}', [ItemVendaController::class, 'destroy'])
    //     ->name('itens.delete');


    Route::get('/vendas', [VendaController::class, 'index'])->name('vendas.index');

    Route::delete('/vendas/item/{id}', [VendaController::class, 'removeItem'])
        ->name('vendas.removeItem');

    Route::put('/vendas/item/{id}', [VendaController::class, 'updateItem'])
        ->name('vendas.updateItem');

});

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard/produtos-mais-vendidos',
    [DashboardController::class, 'produtosMaisVendidos']
)->name('dashboard.produtos');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/quemSomos', [QuemSomosController::class, 'index'])->name('quemSomos.index');

Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('password.request');


Route::get('/esqueci-senha', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('/esqueci-senha', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/resetar-senha/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/resetar-senha', [ResetPasswordController::class, 'reset'])->name('password.update');
