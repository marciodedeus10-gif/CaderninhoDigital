<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index()
    {
        $servicos = Servico::orderBy('created_at', 'desc')->get();
        return view('servicos.index', compact('servicos'));
    }

    public function create()
    {
        return view('servicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:255',
            'validade_dias' => 'nullable|integer|min:0',
        ]);

        Servico::create($request->all());

        return redirect()->route('servicos.index')
            ->with('success', 'Serviço criado com sucesso!');
    }

    public function show(Servico $servico)
    {
        return view('servicos.show', compact('servico'));
    }

    public function edit(Servico $servico)
    {
        $servico->load('fichaTecnicas.materiaPrima');
        $materiaPrimas = \App\Models\MateriaPrima::where('ativo', true)->orderBy('created_at', 'desc')->get();
        return view('servicos.edit', compact('servico', 'materiaPrimas'));
    }

    public function update(Request $request, Servico $servico)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:255',
            'validade_dias' => 'nullable|integer|min:0',
        ]);

        $servico->update($request->all());

        return redirect()->route('servicos.index')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();

        return redirect()->route('servicos.index')
            ->with('success', 'Serviço excluído com sucesso!');
    }
}