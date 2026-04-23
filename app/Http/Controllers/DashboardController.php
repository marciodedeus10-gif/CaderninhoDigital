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

        // Cálculo do Saldo de Caixa (Mês Atual)
        $receitasMes = \App\Models\LancamentoFinanceiro::where('user_id', auth()->id())
            ->where('tipo', 'receita')
            ->where('status', 'pago')
            ->whereMonth('data_pagamento', now()->month)
            ->whereYear('data_pagamento', now()->year)
            ->sum('valor');

        $despesasMes = \App\Models\LancamentoFinanceiro::where('user_id', auth()->id())
            ->where('tipo', 'despesa')
            ->where('status', 'pago')
            ->whereMonth('data_pagamento', now()->month)
            ->whereYear('data_pagamento', now()->year)
            ->sum('valor');

        $saldoCaixa = $receitasMes - $despesasMes;

        $produtosMaisVendidos = ItemVenda::select('produto_id', DB::raw('SUM(quantidade) as total'))
            ->whereHas('venda')
            ->whereNotNull('produto_id')
            ->groupBy('produto_id')
            ->orderByDesc('total')
            ->with('produto')
            ->take(5)
            ->get();

        $servicosMaisEfetuados = ItemVenda::select('servico_id', DB::raw('SUM(quantidade) as total'))
            ->whereHas('venda')
            ->whereNotNull('servico_id')
            ->groupBy('servico_id')
            ->orderByDesc('total')
            ->with('servico')
            ->take(5)
            ->get();

        $ultimasVendas = Venda::with(['cliente', 'itens.produto'])->latest()->take(5)->get();

        $produtosEstoqueBaixo = Produto::whereColumn('estoque', '<=', 'estoque_minimo')
            ->where('ativo', 1)
            ->get();

        return view('dashboard.dashboard', compact(
            'totalClientes',
            'saldoCaixa',
            'produtosMaisVendidos',
            'servicosMaisEfetuados',
            'ultimasVendas',
            'produtosEstoqueBaixo'
        ));
    }
}
