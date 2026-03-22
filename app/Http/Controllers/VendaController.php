<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with('cliente')->get();
        return view('vendas.index', compact('vendas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('vendas.create', compact('clientes'));
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
        ]);

        return redirect()->route('vendas.show', $venda->id)->with('success', 'Venda criada com sucesso!');
    }

    public function show($id)
    {
        $venda = Venda::with('itens', 'itens.produto', 'itens.servico')->findOrFail($id);
        // TOTAL BRUTO (sem desconto geral)
        $total = $venda->itens->sum(function ($item) {
            return ($item->preco * $item->quantidade) - $item->desconto;
        });
        $produtos = Produto::all();
        $servicos = Servico::all();
        return view('vendas.show', compact('venda', 'total', 'produtos', 'servicos'));
    }

    public function addItem(Request $request, Venda $venda)
    {
        $subtotal = $request->quantidade * $request->preco;
        $subtotalComDesconto = $subtotal - $request->desconto;
        ItemVenda::create([
            'venda_id' => $venda->id,
            'produto_id' => $request->produto_id,
            'servico_id' => null,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'desconto' => $request->desconto,
            'subtotal' => $subtotalComDesconto
        ]);

        $venda->total += $subtotalComDesconto;
        $venda->desconto_total += $request->desconto;
        $venda->save();
        return redirect()->route('vendas.show', $venda->id)->with('success', 'Item adicionado com sucesso!');
    }

    public function addServico(Request $request, Venda $venda)
    {
        $subtotal = $request->quantidade * $request->preco;
        $subtotalComDesconto = $subtotal - $request->desconto;
        ItemVenda::create([
            'venda_id' => $venda->id,
            'produto_id' => null,
            'servico_id' => $request->servico_id,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'desconto' => $request->desconto,
            'subtotal' => $subtotalComDesconto
        ]);

        $venda->total += $subtotalComDesconto;
        $venda->desconto_total += $request->desconto;
        $venda->save();
        return redirect()->route('vendas.show', $venda->id)->with('success', 'Serviço adicionado com sucesso!');
    }

    public function removeItem($id)
    {
        $item = ItemVenda::findOrFail($id);
        $vendaId = $item->venda_id;
        $item->delete();
        return redirect()->route('vendas.show', $vendaId)
            ->with('success', 'Item removido!');
    }

    public function updateItem(Request $request, $id)
    {
        $item = ItemVenda::findOrFail($id);
        $request->validate([
            'quantidade' => 'required|integer|min:1'
        ]);
        $item->quantidade = $request->quantidade;
        $item->save();
        return back()->with('success', 'Quantidade atualizada!');
    }

        public function updateDesconto(Request $request, $id)
    {
        $venda = Venda::findOrFail($id);
        $venda->desconto_total = $request->desconto_total;
        $venda->save();
        return redirect()->back()->with('success', 'Desconto atualizado com sucesso!');
    }

        public function aplicarDesconto(Request $request, $id)
    {
        $venda = Venda::findOrFail($id);
        $venda->desconto = $request->desconto;
        $venda->save();
        return response()->json(['success' => true]);
    }

        public function finalizar($id)
    {
        $venda = Venda::findOrFail($id);
        $venda->status = 'finalizada'; // ou 1
        $venda->save();
        return redirect()->back()->with('success', 'Venda finalizada com sucesso!');
    }
}
