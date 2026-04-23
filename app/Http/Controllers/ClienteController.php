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

    $clientes = $query->orderBy('nome', 'asc')->paginate(10);

    // 🔥 pega cidades, bairros e nomes únicos cadastrados para os filtros e autocomplete
    $cidades = Cliente::select('cidade')->distinct()->pluck('cidade');
    $bairros = Cliente::select('bairro')->distinct()->pluck('bairro');
    $nomesClientes = Cliente::select('nome')->orderBy('nome')->distinct()->pluck('nome');

    return view('clientes.index', compact('clientes', 'cidades', 'bairros', 'nomesClientes'));
}

    public function create()
    {
        return view('clientes.create');
    }

public function store(Request $request)
{
    $cliente = Cliente::create([
        'nome' => $request->nome,
        'telefone' => $request->telefone,
        'email' => $request->email,
        'endereco' => $request->endereco,
        'bairro' => $request->bairro,
        'cidade' => $request->cidade,
        'estado' => $request->estado,
        'cep' => $request->cep,
        'numero' => $request->numero,
        'cpf_cnpj' => $request->cpf_cnpj,
        'observacoes' => $request->observacoes,
        'ativo' => $request->ativo ?? 1
    ]);

    if ($request->origin === 'venda') {
        return redirect()->route('vendas.create', ['cliente_id' => $cliente->id])
            ->with('success', 'Cliente cadastrado e selecionado!');
    }

    return redirect()->route('clientes.index')
        ->with('success', 'Cliente cadastrado com sucesso!');
}


    public function show(Cliente $cliente)
    {
        $cliente->load(['vendas' => function($query) {
            $query->orderBy('data_venda', 'desc');
        }, 'vendas.itens.produto', 'vendas.itens.servico']);

        return view('clientes.show', compact('cliente'));
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
