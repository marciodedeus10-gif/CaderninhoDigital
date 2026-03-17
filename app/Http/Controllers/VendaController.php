<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\ItemVenda;
use App\Models\Produto;
use App\Models\Cliente;
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
        $produtos = Produto::all();

        return view('vendas.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'user_id' => auth()->id(),
            'data_venda' => $request->data_venda,
            'data_vencimento' => $request->data_vencimento,
            'observacoes' => $request->observacoes,
        ]);

        $total = 0;

        foreach ($request->produtos as $index => $produto_id) {

            $produto = Produto::find($produto_id);
            $quantidade = $request->quantidades[$index];

            $subtotal = $produto->preco * $quantidade;

            ItemVenda::create([
                'venda_id' => $venda->id,
                'produto_id' => $produto_id,
                'quantidade' => $quantidade,
                'valor_unitario' => $produto->preco,
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;
        }

        $venda->update([
            'valor_total' => $total
        ]);

        return redirect()->route('vendas.index');
    }

    public function show($id)
    {
        $venda = Venda::with('itens.produto')->findOrFail($id);
        return view('vendas.show', compact('venda'));
    }

    public function destroy($id)
    {
        Venda::destroy($id);
        return redirect()->route('vendas.index');
    }
}