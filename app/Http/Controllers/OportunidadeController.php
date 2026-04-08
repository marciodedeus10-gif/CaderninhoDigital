<?php

namespace App\Http\Controllers;

use App\Models\Oportunidade;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OportunidadeController extends Controller
{
    public function index()
    {
        $hoje = Carbon::today();
        
        $oportunidadesHoje = Oportunidade::with('cliente')
            ->whereDate('data_contato', $hoje)
            ->orderBy('created_at', 'desc')
            ->get();

        $todasOportunidades = Oportunidade::with('cliente')
            ->orderBy('data_contato', 'desc')
            ->paginate(10);

        $clientes = Cliente::all();

        return view('oportunidades.index', compact('oportunidadesHoje', 'todasOportunidades', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|string',
            'data_contato' => 'required|date',
            'descricao' => 'nullable|string'
        ]);

        Oportunidade::create($request->all());

        return redirect()->route('oportunidades.index')
            ->with('success', 'Oportunidade registrada com sucesso!');
    }

    public function update(Request $request, Oportunidade $oportunidade)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|string',
            'data_contato' => 'required|date',
            'descricao' => 'nullable|string'
        ]);

        $oportunidade->update($request->all());

        return redirect()->route('oportunidades.index')
            ->with('success', 'Oportunidade atualizada!');
    }

    public function destroy(Oportunidade $oportunidade)
    {
        $oportunidade->delete();

        return redirect()->route('oportunidades.index')
            ->with('success', 'Oportunidade removida.');
    }
}
