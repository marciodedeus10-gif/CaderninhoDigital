<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Servico;
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
'cliente_id'=>$request->cliente_id,
'data_venda'=>now(),
'status'=>'Em andamento'
]);

return redirect()->route('vendas.show',$venda->id);

}

public function show($id)
{

$venda = Venda::findOrFail($id);

$produtos = Produto::all();

$servicos = Servico::all();

return view('vendas.show',compact('venda','produtos','servicos'));

}

public function addItem(Request $request,$venda)
{

$venda = Venda::findOrFail($venda);

$subtotal = $request->quantidade * $request->preco;

ItemVenda::create([
'venda_id'=>$venda->id,
'produto_id'=>$request->produto_id,
'servico_id'=>$request->servico_id,
'quantidade'=>$request->quantidade,
'preco'=>$request->preco,
'subtotal'=>$subtotal
]);

$venda->total += $subtotal;
$venda->save();

return back();

}

public function status($venda)
{

$venda = Venda::findOrFail($venda);

$venda->status = 'Finalizada';

$venda->save();

return back();

}

}
