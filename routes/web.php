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
use App\Http\Controllers\QuemSomosController;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AssinaturaController;


// ============================================================
// ROTAS PÚBLICAS
// ============================================================

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sobrenos', function () {
    return view('sobrenos');
})->name('sobrenos');

Route::get('/relatos', function () {
    return view('relatos');
})->name('relatos');

Route::get('/o-app', function () {
    return view('o-app');
})->name('o-app');

Route::get('/beneficios', function () {
    return view('beneficios');
})->name('beneficios');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/quemSomos', [QuemSomosController::class, 'index'])->name('quemSomos.index');

// Recuperação de senha — apenas UM bloco, sem duplicatas ✅
Route::get('/esqueci-senha', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/esqueci-senha', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/resetar-senha/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/resetar-senha', [ResetPasswordController::class, 'reset'])->name('password.update');


// ============================================================
// ROTAS COM AUTENTICAÇÃO
// ============================================================

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('plano:dashboard_basico');
    Route::get('/dashboard/produtos-mais-vendidos', [DashboardController::class, 'produtosMaisVendidos'])->name('dashboard.produtos')->middleware('plano:dashboard_basico');

    // Resources
    Route::resource('produtos', ProdutoController::class)->middleware('plano:produtos');
    Route::get('/produtos/{produto}/estoque', [ProdutoController::class, 'estoque'])->name('produtos.estoque')->middleware('plano:estoque');
    Route::post('/produtos/{produto}/estoque', [ProdutoController::class, 'adicionarMovimentacao'])->name('produtos.adicionarMovimentacao')->middleware('plano:estoque');
    Route::resource('servicos', ServicoController::class)->middleware('plano:servicos');
    Route::resource('clientes', ClienteController::class)->middleware('plano:clientes');
    Route::resource('fornecedores', FornecedorController::class)->parameters(['fornecedores' => 'fornecedore'])->middleware('plano:compras');
    Route::resource('contatos', ContatoController::class)->middleware('plano:clientes');
    Route::resource('oportunidades', OportunidadeController::class)->middleware('plano:vendas');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Perfil do usuário
    Route::get('/perfil', [UserController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [UserController::class, 'update'])->name('perfil.update');
    Route::delete('/perfil/delete', [UserController::class, 'destroy'])->name('perfil.delete');

    // Vendas (resource + rotas extras)
    Route::resource('vendas', VendaController::class);
    Route::post('vendas/{venda}/item', [VendaController::class, 'addItem'])->name('vendas.addItem');
    Route::post('vendas/{venda}/addServico', [VendaController::class, 'addServico'])->name('vendas.addServico');
    Route::post('vendas/{venda}/status', [VendaController::class, 'status'])->name('vendas.status');
    Route::post('/vendas/{id}/desconto', [VendaController::class, 'updateDesconto'])->name('vendas.updateDesconto');
    Route::put('/vendas/{id}/finalizar', [VendaController::class, 'finalizar'])->name('vendas.finalizar');
    Route::delete('/vendas/item/{id}', [VendaController::class, 'removeItem'])->name('vendas.removeItem');
    Route::put('/vendas/item/{id}', [VendaController::class, 'updateItem'])->name('vendas.updateItem');

    // Compras
    Route::resource('compras', CompraController::class);
    Route::post('/compras/{compra}/item', [CompraController::class, 'addItem'])->name('compras.addItem');
    Route::delete('/compras/item/{item}', [CompraController::class, 'removeItem'])->name('compras.removeItem');
    Route::post('/compras/{compra}/receber', [CompraController::class, 'receber'])->name('compras.receber');

    // Financeiro
    Route::resource('financeiro', \App\Http\Controllers\FinanceiroController::class);
    Route::post('/financeiro/{id}/baixa', [\App\Http\Controllers\FinanceiroController::class, 'darBaixa'])->name('financeiro.baixa');

// Matéria Prima e Ficha Técnica
    Route::resource('materia_primas', MateriaPrimaController::class);
    // Rotas de gerenciamento de estoque de matéria-prima
    Route::get('/materia_primas/{materia_prima}/add-stock', [MateriaPrimaController::class, 'addStockForm'])->name('materia_primas.add_stock_form');
    Route::post('/materia_primas/{materia_prima}/add-stock', [MateriaPrimaController::class, 'addStock'])->name('materia_primas.add_stock');
    Route::post('/produtos/{produto}/ficha-tecnica', [\App\Http\Controllers\FichaTecnicaController::class, 'storeProduto'])->name('ficha.produto.store');
    Route::post('/servicos/{servico}/ficha-tecnica', [\App\Http\Controllers\FichaTecnicaController::class, 'storeServico'])->name('ficha.servico.store');
    Route::delete('/ficha-tecnica/{id}', [\App\Http\Controllers\FichaTecnicaController::class, 'destroy'])->name('ficha.destroy');

    // Assinaturas e Planos
    Route::resource('assinaturas', AssinaturaController::class)->except(['show', 'edit', 'update', 'destroy']);
    // Rota para criar assinatura gratuita do plano Bronze
    Route::post('/assinaturas/gratis', [AssinaturaController::class, 'gratis'])->name('assinaturas.gratis');
    Route::post('/assinaturas/cancelar', [AssinaturaController::class, 'cancelar'])->name('assinaturas.cancelar');
    Route::post('/assinaturas/upgrade', [AssinaturaController::class, 'upgrade'])->name('assinaturas.upgrade');

    // Gerenciamento de Usuários (para administradores)
    Route::resource('usuarios', UsuarioController::class)->middleware('permission:ver_usuarios');


Route::get('/ouro', function () {
    return "Área Ouro";
})->middleware('plano:ouro');

Route::get('/prata', function () {
    return "Área Prata ou Ouro";
})->middleware('plano:prata,ouro');
});
