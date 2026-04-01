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

        return redirect()->route('vendas.show', $venda->id)
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
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:1'
        ]);

        if ($venda->status !== 'aberta') {
            return back()->with('error', 'Venda já finalizada!');
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

        return back()->with('success', 'Item adicionado!');
    }

    public function addServico(Request $request, Venda $venda)
    {
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

        return back()->with('success', 'Serviço adicionado!');
    }

    public function removeItem($id)
    {
        $item = ItemVenda::findOrFail($id);

        if ($item->venda->status !== 'aberta') {
            return back()->with('error', 'Não pode remover item!');
        }

        $item->delete();

        return back()->with('success', 'Item removido!');
    }

    public function updateItem(Request $request, ItemVenda $item)
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
        $request->validate([
            'desconto' => 'required|numeric|min:0'
        ]);

        $venda = Venda::findOrFail($id);

        if ($venda->status !== 'aberta') {
            return back()->with('error', 'Venda finalizada!');
        }

        $venda->desconto = $request->desconto;

        $totalItens = $venda->itens()->sum('subtotal');
        $venda->total = $totalItens - $venda->desconto;

        $venda->save();

        return back()->with('success', 'Desconto atualizado!');
    }

    public function finalizar($id)
    {
        $venda = Venda::with('itens')->findOrFail($id);

        if ($venda->itens->count() == 0) {
            return back()->with('error', 'Adicione itens antes de finalizar!');
        }

        $venda->status = 'finalizada';
        $venda->save();

        return back()->with('success', 'Venda finalizada!');
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
