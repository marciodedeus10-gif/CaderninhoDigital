<?php

namespace App\Http\Controllers;

use App\Models\Produto;

class DashboardController extends Controller
{
    public function produtosMaisVendidos()
    {
        $produtos = Produto::withSum('vendas as total_vendido', 'quantidade')
            ->withSum('vendas as receita_total', 'valor_total')
            ->orderByDesc('total_vendido')
            ->get();

        return view('dashboard.produtos', compact('produtos'));
    }

public function index()
{
    $totalVendas = Venda::where('user_id', auth()->id())->sum('valor_total');

    $totalClientes = Cliente::where('user_id', auth()->id())->count();

    $totalProdutos = Produto::where('user_id', auth()->id())->count();

    return view('dashboard', compact(
        'totalVendas',
        'totalClientes',
        'totalProdutos'


    ));
}

}