<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\ItemVenda;
use Illuminate\Support\Facades\DB;


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

        $produtosMaisVendidos = ItemVenda::select('produto_id', DB::raw('SUM(quantidade) as total'))
            ->whereNotNull('produto_id')
            ->groupBy('produto_id')
            ->orderByDesc('total')
            ->with('produto')
            ->take(5)
            ->get();

        $servicosMaisEfetuados = ItemVenda::select('servico_id', DB::raw('SUM(quantidade) as total'))
            ->whereNotNull('servico_id')
            ->groupBy('servico_id')
            ->orderByDesc('total')
            ->with('servico')
            ->take(5)
            ->get();

        $ultimasVendas = Venda::with(['cliente', 'itens.produto'])->latest()->take(5)->get();

        return view('dashboard.dashboard', compact(
            'totalClientes',
            'totalVendas',
            'produtosMaisVendidos',
            'servicosMaisEfetuados',
            'ultimasVendas'
        ));
    }
}
