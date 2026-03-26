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

        return redirect()->route('dashboard')
            ->with('success', 'Venda criada com sucesso!');
    }

    public function show($id)
    {
        $venda = Venda::with('itens', 'itens.produto', 'itens.servico')->findOrFail($id);
        // TOTAL BRUTO (sem desconto geral)
        $totalItens = $venda->itens->sum('subtotal');
        $total = $totalItens - $venda->desconto;
        $produtos = Produto::all();
        $servicos = Servico::all();
        return view('vendas.show', compact('venda', 'total', 'produtos', 'servicos'));
    }

    public function addItem(Request $request, Venda $venda)
    {
        $subtotal = $request->quantidade * $request->preco;

ItemVenda::create([
    'venda_id' => $venda->id,
    'produto_id' => $request->produto_id,
    'servico_id' => null,
    'quantidade' => $request->quantidade,
    'preco' => $request->preco,
    'subtotal' => $subtotal
        ]);

$totalItens = $venda->itens()->sum('subtotal');
$venda->total = $totalItens - $venda->desconto;
$venda->save();
        return redirect()->route('vendas.show', $venda->id)->with('success', 'Item adicionado com sucesso!');
    }

    public function addServico(Request $request, Venda $venda)
    {
        $subtotal = $request->quantidade * $request->preco;

ItemVenda::create([
    'venda_id' => $venda->id,
    'produto_id' => null,
    'servico_id' => $request->servico_id,
    'quantidade' => $request->quantidade,
    'preco' => $request->preco,
    'subtotal' => $subtotal
        ]);

        $totalItens = $venda->itens()->sum('subtotal');
        $venda->total = $totalItens - $venda->desconto;
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
$item->quantidade = $request->quantidade;
$item->subtotal = $item->quantidade * $item->preco;
$item->save();

$venda = $item->venda;
$totalItens = $venda->itens()->sum('subtotal');
$venda->total = $totalItens - $venda->desconto;
$venda->save();
        return back()->with('success', 'Quantidade atualizada!');
    }

    public function updateDesconto(Request $request, $id)
    {
        $venda = Venda::findOrFail($id);
$venda->desconto = $request->desconto ?? 0;

$totalItens = $venda->itens()->sum('subtotal');
$venda->total = $totalItens - $venda->desconto;

$venda->save();
        return redirect()->back()->with('success', 'Desconto atualizado com sucesso!');
    }

    public function finalizar($id)
    {
        $venda = Venda::findOrFail($id);
        $venda->status = 'finalizada'; // ou 1
        $venda->save();
        return redirect()->back()->with('success', 'Venda finalizada com sucesso!');
    }

    // Mostrar tela de edição
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    // Atualizar dados
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'telefone' => 'nullable',
            'tipo' => 'required',
            'foto' => 'nullable|image',
            'tema' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telefone = $request->telefone;
        $user->tipo = $request->tipo;
        $user->tema = $request->tema;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('usuarios', 'public');
            $user->foto = $path;
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return back()->with('success', 'Atualizado com sucesso!');
    }
}

