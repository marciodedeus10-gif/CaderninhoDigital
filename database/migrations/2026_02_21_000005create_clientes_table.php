<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
{
    $query = Cliente::query();

    if ($request->filled('nome')) {
        $query->where('nome', 'like', '%' . $request->nome . '%');
    }

    if ($request->filled('cidade')) {
        $query->where('cidade', $request->cidade);
    }

    if ($request->filled('bairro')) {
        $query->where('bairro', $request->bairro);
    }

    $clientes = $query->get();

    // 🔥 pega cidades e bairros únicos cadastrados
    $cidades = Cliente::select('cidade')->distinct()->pluck('cidade');
    $bairros = Cliente::select('bairro')->distinct()->pluck('bairro');

    return view('clientes.index', compact('clientes', 'cidades', 'bairros'));
}

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        Cliente::create([
        
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }








    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome' => 'required'
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente removido!');
    }
}
