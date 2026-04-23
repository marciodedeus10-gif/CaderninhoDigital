<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venda::with('cliente', 'itens.produto');

        // Filtro por Intervalo de Datas
        if ($request->filled('data_de')) {
            $query->whereDate('data_venda', '>=', $request->data_de);
        }
        if ($request->filled('data_ate')) {
            $query->whereDate('data_venda', '<=', $request->data_ate);
        }

        // Ordenação
        $sort = $request->get('sort', 'recentes');
        if ($sort === 'alfabetica') {
            $query->join('clientes', 'vendas.cliente_id', '=', 'clientes.id')
                ->select('vendas.*')
                ->orderBy('clientes.nome', 'asc');
        } elseif ($sort === 'antigas') {
            $query->orderBy('data_venda', 'asc')->orderBy('created_at', 'asc');
        } else {
            // Default: Recentes
            $query->orderBy('data_venda', 'desc')->orderBy('created_at', 'desc');
        }

        $vendas = $query->paginate(10);

        return view('vendas.index', compact('vendas'));
    }







    public function create(Request $request)
    {
        $clientes = Cliente::all();
        $selected_cliente_id = $request->cliente_id;
        return view('vendas.create', compact('clientes', 'selected_cliente_id'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data_venda' => 'required|date',
        ]);

        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'user_id' => auth()->id(),
            'data_venda' => $request->data_venda,
            'data_vencimento' => $request->data_vencimento,
            'observacoes' => $request->observacoes,
            'status' => 'aberta',
            'total' => 0,
        ]);

        return redirect()->route('vendas.show', $venda->id)
            ->with('success', 'Venda criada com sucesso!');
    }

    public function show($id)
    {
        $venda = Venda::with('itens', 'itens.produto', 'itens.servico')->findOrFail($id);
        // TOTAL BRUTO (sem desconto geral)
        $totalItens = $venda->subtotal;
        $total = $venda->total;
        $produtos = Produto::all();
        $servicos = Servico::all();

        // Produtos mais vendidos
        $produtosMaisVendidosIds = \App\Models\ItemVenda::whereHas('venda')
            ->whereNotNull('produto_id')
            ->select('produto_id', \Illuminate\Support\Facades\DB::raw('SUM(quantidade) as total'))
            ->groupBy('produto_id')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('produto_id');

        if ($produtosMaisVendidosIds->isEmpty()) {
            $produtosMaisVendidos = Produto::take(5)->get();
        } else {
            $produtosMaisVendidos = Produto::whereIn('id', $produtosMaisVendidosIds)->get();
        }

        // Serviços mais vendidos
        $servicosMaisVendidosIds = \App\Models\ItemVenda::whereHas('venda')
            ->whereNotNull('servico_id')
            ->select('servico_id', \Illuminate\Support\Facades\DB::raw('SUM(quantidade) as total'))
            ->groupBy('servico_id')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('servico_id');

        if ($servicosMaisVendidosIds->isEmpty()) {
            $servicosMaisVendidos = Servico::take(5)->get();
        } else {
            $servicosMaisVendidos = Servico::whereIn('id', $servicosMaisVendidosIds)->get();
        }

        return view('vendas.show', compact('venda', 'total', 'produtos', 'servicos', 'produtosMaisVendidos', 'servicosMaisVendidos'));
    }

    public function addItem(Request $request, Venda $venda)
    {
        if ($request->has('preco')) {
            $request->merge(['preco' => str_replace(',', '.', $request->preco)]);
        }

        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1'
        ]);

        if ($venda->status !== 'aberta') {
            return back()->with('error', 'Venda já finalizada!');
        }

        // Trava de segurança do Estoque
        $produto = Produto::findOrFail($request->produto_id);
        if ($produto->estoque < $request->quantidade) {
            return back()->with('error', "Estoque insuficiente! Apenas {$produto->estoque} unidades disponíveis.");
        }

        $subtotal = $request->quantidade * $request->preco;

        ItemVenda::create([
            'venda_id' => $venda->id,
            'produto_id' => $request->produto_id,
            'servico_id' => null,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'subtotal' => $subtotal
        ]);

        $venda->recalcularTotal();

        return back()->with('success', 'Item adicionado!');
    }

    public function addServico(Request $request, Venda $venda)
    {
        if ($request->has('preco')) {
            $request->merge(['preco' => str_replace(',', '.', $request->preco)]);
        }

        $request->validate([
            'servico_id' => 'required|exists:servicos,id',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1'
        ]);

        if ($venda->status !== 'aberta') {
            return back()->with('error', 'Venda já finalizada!');
        }

        $subtotal = $request->quantidade * $request->preco;

        ItemVenda::create([
            'venda_id' => $venda->id,
            'produto_id' => null,
            'servico_id' => $request->servico_id,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'subtotal' => $subtotal
        ]);

        $venda->recalcularTotal();

        return back()->with('success', 'Serviço adicionado!');
    }

    public function removeItem($id)
    {
        $item = ItemVenda::findOrFail($id);
        $venda = $item->venda;

        if ($venda->status !== 'aberta') {
            return back()->with('error', 'Não pode remover item!');
        }

        $item->delete();
        $venda->recalcularTotal();

        return back()->with('success', 'Item removido!');
    }

    public function updateItem(Request $request, ItemVenda $item)
    {
        if ($item->produto_id) {
            $produto = $item->produto;
            if ($produto->estoque < $request->quantidade) {
                return back()->with('error', "Estoque insuficiente! Apenas {$produto->estoque} unidades disponíveis.");
            }
        }

        $item->quantidade = $request->quantidade;
        $item->subtotal = $item->quantidade * $item->preco;
        $item->save();

        $item->venda->recalcularTotal();
        return back()->with('success', 'Quantidade atualizada!');
    }

    public function updateDesconto(Request $request, $id)
    {
        if ($request->has('desconto')) {
            $request->merge(['desconto' => str_replace(',', '.', $request->desconto)]);
        }

        $request->validate([
            'desconto' => 'required|numeric|min:0',
            'tipo_desconto' => 'nullable|in:valor,porcentagem'
        ]);

        $venda = Venda::findOrFail($id);

        if ($venda->status !== 'aberta') {
            return back()->with('error', 'Venda finalizada!');
        }

        $subtotal = $venda->subtotal;
        $desconto_valor = $request->desconto;

        if ($request->tipo_desconto === 'porcentagem') {
            $desconto_valor = ($subtotal * $request->desconto) / 100;
        }

        if ($desconto_valor > $subtotal) {
            return back()->with('error', 'O desconto não pode ser maior que o subtotal da venda!');
        }

        $venda->desconto = $desconto_valor;
        $venda->recalcularTotal();

        return back()->with('success', 'Desconto atualizado!');
    }

    public function finalizar($id)
    {
        $venda = Venda::with('itens')->findOrFail($id);

        if ($venda->itens->count() == 0) {
            return back()->with('error', 'Adicione itens antes de finalizar!');
        }

        // Baixa automática de estoque
        foreach ($venda->itens as $item) {
            if ($item->produto_id) {
                $produto = $item->produto;
                if ($produto->estoque < $item->quantidade) {
                    return back()->with('error', "O produto {$produto->nome} não tem estoque suficiente para finalizar a venda!");
                }

                // Deduzir estoque
                $produto->decrement('estoque', $item->quantidade);

                // Histórico de Saída
                \App\Models\MovimentacaoEstoque::create([
                    'produto_id' => $produto->id,
                    'tipo' => 'saida',
                    'quantidade' => $item->quantidade,
                    'observacao' => "Venda #" . $venda->id
                ]);
            }
        }

        $venda->status = 'finalizada';
        $venda->save();

        // ✅ 🔥 AQUI ENTRA O FINANCEIRO (NOVO)
        \App\Models\LancamentoFinanceiro::create([
            'user_id' => auth()->id(),
            'tipo' => 'receita',
            'descricao' => 'Venda #' . $venda->id,
            'valor' => $venda->total,
            'data_vencimento' => now(),
            'data_pagamento' => now(),
            'status' => 'pago',
            'venda_id' => $venda->id
        ]);

        return back()->with('success', 'Venda finalizada!');
    }

    public function destroy($id)
    {
        $venda = Venda::findOrFail($id);

        if ($venda->status !== 'aberta') {
            return back()->with('error', 'Apenas vendas abertas podem ser excluídas!');
        }

        // ✅ 🔥 (PROTEÇÃO FUTURA - financeiro)
        \App\Models\LancamentoFinanceiro::where('venda_id', $venda->id)->delete();

        $venda->itens()->delete();
        $venda->delete();

        return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso!');
    }

}
