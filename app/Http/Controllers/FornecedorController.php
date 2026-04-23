<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::orderBy('nome')->paginate(10);
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create()
    {
        return view('fornecedores.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required']);
        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo') ? 1 : 0;
        Fornecedor::create($dados);
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado!');
    }

    public function show(Fornecedor $fornecedore)
    {
        return view('fornecedores.show', compact('fornecedore'));
    }

    public function edit(Fornecedor $fornecedore)
    {
        return view('fornecedores.edit', compact('fornecedore'));
    }

    public function update(Request $request, Fornecedor $fornecedore)
    {
        $request->validate(['nome' => 'required']);
        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo') ? 1 : 0;
        $fornecedore->update($dados);
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado!');
    }

    public function destroy(Fornecedor $fornecedore)
    {
        $fornecedore->delete();
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor removido!');
    }
}
