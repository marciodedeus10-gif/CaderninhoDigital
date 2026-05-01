<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function index()
    {
        $contatos = Contato::latest()->get();
        return view('contatos.index', compact('contatos'));
    }

    public function create()
    {
        return view('contatos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
            'mensagem' => 'required'
        ]);

        Contato::create($request->all());

        return redirect()->route('contatos.create')
            ->with('success', 'Mensagem enviada com sucesso!');
    }

    public function show(Contato $contato)
    {
        return view('contatos.show', compact('contato'));
    }

    public function destroy(Contato $contato)
    {
        $contato->delete();

        return redirect()->route('contatos.index')
            ->with('success', 'Mensagem excluída!');
    }
}