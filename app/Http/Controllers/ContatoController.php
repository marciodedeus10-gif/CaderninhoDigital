<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function index()
    {
        $contatos = Contato::all();
        return view('contatos.index', compact('contatos'));
    }

    public function create()
    {
        return view('contatos.create');
    }

    public function store(Request $request)
    {
        Contato::create($request->all());

        return redirect()->route('contatos.index')
            ->with('success', 'Contato cadastrado com sucesso!');
    }

    public function show(Contato $contato)
    {
        return view('contatos.show', compact('contato'));
    }

    public function edit(Contato $contato)
    {
        return view('contatos.edit', compact('contato'));
    }

    public function update(Request $request, Contato $contato)
    {
        $contato->update($request->all());

        return redirect()->route('contatos.index')
            ->with('success', 'Contato atualizado!');
    }

    public function destroy(Contato $contato)
    {
        $contato->delete();

        return redirect()->route('contatos.index')
            ->with('success', 'Contato excluído!');
    }
}