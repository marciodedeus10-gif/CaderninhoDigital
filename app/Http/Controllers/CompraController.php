<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ItemCompra;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('fornecedor')->latest()->paginate(10);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $fornecedores = Fornecedor::all();
        return view('compras.create', compact('fornecedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'data_compra' => 'required|date'
        ]);

        $compra = Compra::create([
            'user_id' => auth()->id(),
            'fornecedor_id' => $request->fornecedor_id,
            'data_compra' => $request->data_compra,
            'status' => 'pendente',
            'total' => 0
        ]);

        return redirect()->route('compras.show', $compra)->with('success', 'Pedido de compra iniciado!');
    }

    public function show(Compra $compra)
    {
        $compra->load(['itens.produto', 'fornecedor']);
        $produtos = Produto::all();
        return view('compras.show', compact('compra', 'produtos'));
    }

    public function addItem(Request $request, Compra $compra)
    {
        if ($compra->status !== 'pendente') {
            return back()->with('error', 'Pedido não está mais pendente.');
        }

        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
            'preco_unitario' => 'required|numeric|min:0'
        ]);

        ItemCompra::create([
            'compra_id' => $compra->id,
            'produto_id' => $request->produto_id,
            'quantidade' => $request->quantidade,
            'preco_unitario' => $request->preco_unitario,
            'subtotal' => $request->quantidade * $request->preco_unitario
        ]);

        $compra->recalcularTotal();
        return back()->with('success', 'Item adicionado ao pedido.');
    }

    public function removeItem(ItemCompra $item)
    {
        $compra = $item->compra;
        if ($compra->status !== 'pendente') {
            return back()->with('error', 'Pedido não está pendente.');
        }

        $item->delete();
        $compra->recalcularTotal();
        return back()->with('success', 'Item removido.');
    }

    public function destroy(Compra $compra)
    {
        if ($compra->status === 'recebido') {
            return back()->with('error', 'Compras recebidas não podem ser excluídas diretamente.');
        }
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Pedido excluído.');
    }

    public function receber(Compra $compra)
{
    if ($compra->status !== 'pendente') {
        return back()->with('error', 'Apenas pedidos pendentes podem ser recebidos.');
    }

    if ($compra->itens->count() == 0) {
        return back()->with('error', 'O pedido precisa ter itens para ser recebido.');
    }

    // Dar entrada no estoque e registrar histórico
    foreach ($compra->itens as $item) {
        $produto = $item->produto;
        
        // Incrementa estoque
        $produto->increment('estoque', $item->quantidade);

        // Atualizar preço de custo
        $produto->update(['preco_custo' => $item->preco_unitario]);

        // Histórico
        \App\Models\MovimentacaoEstoque::create([
            'produto_id' => $produto->id,
            'tipo' => 'entrada',
            'quantidade' => $item->quantidade,
            'observacao' => "Compra #" . $compra->id
        ]);
    }

    $compra->status = 'recebido';
    $compra->data_entrega = now();
    $compra->save();

    // ✅ 🔥 AQUI ENTRA O FINANCEIRO (NOVO)
    \App\Models\LancamentoFinanceiro::create([
        'user_id' => auth()->id(),
        'tipo' => 'despesa',
        'descricao' => 'Compra #' . $compra->id,
        'valor' => $compra->total,
        'data_vencimento' => now(),
        'data_pagamento' => now(),
        'status' => 'pago',
        'compra_id' => $compra->id
    ]);

    return back()->with('success', 'Mercadorias recebidas! Estoque atualizado com sucesso.');
}
}
