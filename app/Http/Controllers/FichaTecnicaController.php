<?php

namespace App\Http\Controllers;

use App\Models\FichaTecnica;
use App\Models\Produto;
use App\Models\Servico;
use Illuminate\Http\Request;

class FichaTecnicaController extends Controller
{
    public function storeProduto(Request $request, Produto $produto)
    {
        $request->validate([
            'materia_prima_id' => 'required|exists:materia_primas,id',
            'quantidade' => 'required|numeric|min:0.001'
        ]);

        FichaTecnica::create([
            'user_id' => auth()->id(),
            'produto_id' => $produto->id,
            'materia_prima_id' => $request->materia_prima_id,
            'quantidade' => str_replace(',', '.', $request->quantidade)
        ]);

        return back()->with('success', 'Matéria Prima adicionada à ficha técnica do produto!');
    }

    public function storeServico(Request $request, Servico $servico)
    {
        $request->validate([
            'materia_prima_id' => 'required|exists:materia_primas,id',
            'quantidade' => 'required|numeric|min:0.001'
        ]);

        FichaTecnica::create([
            'user_id' => auth()->id(),
            'servico_id' => $servico->id,
            'materia_prima_id' => $request->materia_prima_id,
            'quantidade' => str_replace(',', '.', $request->quantidade)
        ]);

        return back()->with('success', 'Matéria Prima adicionada à ficha técnica do serviço!');
    }

    public function destroy($id)
    {
        $ficha = FichaTecnica::findOrFail($id);
        $ficha->delete();
        return back()->with('success', 'Item removido da ficha técnica!');
    }
}
