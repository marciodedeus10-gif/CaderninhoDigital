<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with(['cliente', 'produto'])->latest()->get();
        return view('vendas.index', compact('vendas'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('vendas.create', compact('clientes','produtos'));
    }

    public function store(Request $request)
    {
        Venda::create($request->all());

        return redirect()->route('vendas.index')
        ->with('success','Venda cadastrada com sucesso');
    }


    public function edit(Venda $venda)
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('vendas.edit', compact('venda', 'clientes', 'produtos'));
    }

    public function update(Request $request, Venda $venda)
    {
        $valorTotal = $request->valor - ($request->desconto ?? 0);

        $venda->update([
            'cliente_id' => $request->cliente_id,
            'produto_id' => $request->produto_id,
            'valor' => $request->valor,
            'desconto' => $request->desconto ?? 0,
            'valor_total' => $valorTotal,
            'data_venda' => $request->data_venda,
            'data_vencimento' => $request->data_vencimento,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()->route('vendas.index')
                        ->with('success', 'Venda atualizada!');
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
        return redirect()->route('vendas.index')
                        ->with('success', 'Venda excluída!');
    }

}
