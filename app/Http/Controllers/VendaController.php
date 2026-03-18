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
        $venda = Venda::with('itens', 'itens.produtos', 'itens.servicos')->findOrFail($id);

        $descontoTotal = $venda->itens->sum('desconto');
        $total = $venda->itens->sum('subtotal');

        $produtos = Produto::all();
        $servicos = Servico::all();

        return view('vendas.show', compact('venda', 'descontoTotal', 'total', 'produtos', 'servicos'));
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
}
