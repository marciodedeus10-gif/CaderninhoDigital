<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LancamentoFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceiroController extends Controller
{
    public function index(Request $request)
    {
        $query = LancamentoFinanceiro::where('user_id', Auth::id());

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $lancamentos = $query->orderBy('data_vencimento', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);

        // Balanço Mensal (Mês Atual)
        $receitasMes = LancamentoFinanceiro::where('user_id', Auth::id())
            ->where('tipo', 'receita')
            ->where('status', 'pago')
            ->whereMonth('data_pagamento', now()->month)
            ->whereYear('data_pagamento', now()->year)
            ->sum('valor');

        $despesasMes = LancamentoFinanceiro::where('user_id', Auth::id())
            ->where('tipo', 'despesa')
            ->where('status', 'pago')
            ->whereMonth('data_pagamento', now()->month)
            ->whereYear('data_pagamento', now()->year)
            ->sum('valor');

        $saldoMes = $receitasMes - $despesasMes;

        return view('financeiro.index', compact('lancamentos', 'receitasMes', 'despesasMes', 'saldoMes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'tipo' => 'required|in:receita,despesa',
            'valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'status' => 'required|in:pendente,pago'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['valor'] = str_replace(',', '.', $request->valor);
        
        if ($request->status == 'pago' && !$request->filled('data_pagamento')) {
            $data['data_pagamento'] = now();
        }

        LancamentoFinanceiro::create($data);

        return redirect()->route('financeiro.index')->with('success', 'Lançamento criado com sucesso!');
    }

    public function darBaixa($id)
    {
        $lancamento = LancamentoFinanceiro::where('user_id', Auth::id())->findOrFail($id);
        
        $lancamento->update([
            'status' => 'pago',
            'data_pagamento' => now()
        ]);

        return back()->with('success', 'Baixa realizada com sucesso!');
    }

    public function destroy($id)
    {
        $lancamento = LancamentoFinanceiro::where('user_id', Auth::id())->findOrFail($id);
        
        // Se for atrelado a uma venda ou compra, talvez seja melhor avisar?
        // Por enquanto, deleta normalmente.
        $lancamento->delete();

        return redirect()->route('financeiro.index')->with('success', 'Lançamento excluído com sucesso!');
    }
}
