<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required|numeric',
            'estoque' => 'nullable|integer',
            'estoque_minimo' => 'nullable|integer',
            'preco_custo' => 'nullable|numeric'
        ]);

        $dados = $request->all();

        // Corrige checkbox
        $dados['ativo'] = $request->has('ativo') ? 1 : 0;

        Produto::create($dados);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        $produto->load('fichaTecnicas.materiaPrima');
        $materiaPrimas = \App\Models\MateriaPrima::where('ativo', true)->orderBy('created_at', 'desc')->get();
        return view('produtos.edit', compact('produto', 'materiaPrimas'));
    }

    public function update(Request $request, Produto $produto)
{
    $request->validate([
        'nome' => 'required',
        'preco' => 'required|numeric',
        'estoque' => 'nullable|integer',
        'estoque_minimo' => 'nullable|integer',
        'preco_custo' => 'nullable|numeric'
    ]);

    $dados = $request->all();

    // Corrige checkbox
    $dados['ativo'] = $request->has('ativo') ? 1 : 0;

    $produto->update($dados);

    return redirect()->route('produtos.index')
        ->with('success', 'Produto atualizado com sucesso!');
}

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto removido com sucesso!');
    }

    public function estoque(Produto $produto)
    {
        $movimentacoes = \App\Models\MovimentacaoEstoque::where('produto_id', $produto->id)
            ->latest()
            ->paginate(15);
            
        return view('produtos.estoque', compact('produto', 'movimentacoes'));
    }

    public function adicionarMovimentacao(Request $request, Produto $produto)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,saida',
            'quantidade' => 'required|integer|min:1',
            'observacao' => 'nullable|string|max:255'
        ]);

        \App\Models\MovimentacaoEstoque::create([
            'produto_id' => $produto->id,
            'tipo' => $request->tipo,
            'quantidade' => $request->quantidade,
            'observacao' => $request->observacao
        ]);

        if ($request->tipo === 'entrada') {
            $produto->increment('estoque', $request->quantidade);
        } else {
            $produto->decrement('estoque', $request->quantidade);
        }

        return back()->with('success', 'Movimentação registrada com sucesso!');
    }
}
