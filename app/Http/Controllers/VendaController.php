<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
//use App\Models\Servico;
use App\Models\ItemVenda;
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

        $venda = Venda::create([
            'user_id' => 1,
            'cliente_id' => $request->cliente_id,
            'produto_id' => null,
            'valor' => 0,
            'desconto' => 0,
            'valor_total' => 0,
            'data_venda' => now(),
            'data_vencimento' => null,
            'observacoes' => null
        ]);

        return redirect()->route('vendas.show', $venda->id);
    }

    public function show($id)
    {
        $venda = Venda::with(['cliente', 'itens.produto', 'itens.servico'])->findOrFail($id);
        $produtos = Produto::all();

        $itens = ItemVenda::where('venda_id', $id)->get(); // itens da venda

        $total = 0;
        $descontoTotal = 0;

        foreach ($venda->itens as $item) {
            $subtotal = $item->preco * $item->quantidade;
            $subtotalComDesconto = $subtotal - $item->desconto;

            $total += $subtotalComDesconto;
            $descontoTotal += $item->desconto;
        }

        return view('vendas.show', compact('venda', 'total', 'descontoTotal', 'produtos'));
    }

    public function addItem(Request $request, Venda $venda)
    {
        $subtotal = $request->quantidade * $request->preco;
        $subtotalComDesconto = $subtotal - $request->desconto;

        ItemVenda::create([
            'venda_id' => $venda->id,
            'produto_id' => $request->produto_id,
            'servico_id' => $request->servico_id ?? null,
            'quantidade' => $request->quantidade,
            'preco' => $request->preco,
            'desconto' => $request->desconto,
            'subtotal' => $subtotalComDesconto
        ]);

        $venda->total += $subtotalComDesconto;
        $venda->desconto_total += $request->desconto;
        $venda->save();
    }
}
