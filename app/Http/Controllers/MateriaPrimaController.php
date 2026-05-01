<?php

namespace App\Http\Controllers;

use App\Models\MateriaPrima;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class MateriaPrimaController extends Controller
{
    public function index()
    {
        $materiaPrimas = MateriaPrima::with('fornecedor')->orderBy('nome')->paginate(10);
        return view('materia_primas.index', compact('materiaPrimas'));
    }

    public function create()
    {
        $fornecedores = Fornecedor::where('ativo', true)->orderBy('nome')->get();
        return view('materia_primas.create', compact('fornecedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'unidade_medida' => 'required',
            'custo_unitario' => 'required|numeric|min:0',
            'estoque_atual' => 'required|numeric',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo') ? 1 : 0;
        
        // Clean up formatting
        $dados['custo_unitario'] = str_replace(',', '.', $dados['custo_unitario']);
        $dados['estoque_atual'] = str_replace(',', '.', $dados['estoque_atual']);
        $dados['estoque_minimo'] = str_replace(',', '.', $dados['estoque_minimo'] ?? 0);

        MateriaPrima::create($dados);
        return redirect()->route('materia_primas.index')->with('success', 'Matéria Prima cadastrada!');
    }

    public function edit(MateriaPrima $materia_prima)
    {
        $fornecedores = Fornecedor::where('ativo', true)->orderBy('nome')->get();
        return view('materia_primas.edit', compact('materia_prima', 'fornecedores'));
    }

    public function update(Request $request, MateriaPrima $materia_prima)
    {
        $request->validate([
            'nome' => 'required',
            'unidade_medida' => 'required',
            'custo_unitario' => 'required|numeric|min:0',
            'estoque_atual' => 'required|numeric',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo') ? 1 : 0;
        
        // Clean up formatting
        $dados['custo_unitario'] = str_replace(',', '.', $dados['custo_unitario']);
        $dados['estoque_atual'] = str_replace(',', '.', $dados['estoque_atual']);
        $dados['estoque_minimo'] = str_replace(',', '.', $dados['estoque_minimo'] ?? 0);

        $materia_prima->update($dados);
        return redirect()->route('materia_primas.index')->with('success', 'Matéria Prima atualizada!');
    }

    public function destroy(MateriaPrima $materia_prima)
    {
        $materia_prima->delete();
        return redirect()->route('materia_primas.index')->with('success', 'Matéria Prima removida!');
    } // Show form to add stock entry for a raw material
    public function addStockForm(MateriaPrima $materia_prima)
    {
        return view('materia_primas.add_stock', [
            'materia_prima' => $materia_prima,
            'estoque_atual' => $materia_prima->estoque_atual,
            'estoque_minimo' => $materia_prima->estoque_minimo ?? 0,
        ]);
    }

    // Process stock entry after confirmation
    public function addStock(Request $request, MateriaPrima $materia_prima)
    {
        $request->validate([
            'quantidade' => 'required|numeric|min:0.01',
            'custo' => 'required|numeric|min:0',
            'confirmar' => 'accepted',
        ]);

        // Update stock only after confirmation
        $novaQuantidade = $materia_prima->estoque_atual + $request->input('quantidade');
        $materia_prima->update([
            'estoque_atual' => $novaQuantidade,
            // Optionally update unit cost average or latest cost
            'custo_unitario' => $request->input('custo'),
        ]);

        return redirect()->route('materia_primas.index')
            ->with('success', 'Estoque atualizado com sucesso!');
    }


}
