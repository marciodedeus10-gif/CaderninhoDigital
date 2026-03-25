<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\ItemVenda;


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
        $totalClientes = Cliente::count();

        // 👇 ALTERAÇÃO AQUI
        $totalVendas = ItemVenda::sum('subtotal');

        return view('dashboard', compact(
            'totalClientes',
            'totalVendas'
        ));
    }
}               