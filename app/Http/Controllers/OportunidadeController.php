<?php

namespace App\Http\Controllers;

use App\Models\Oportunidade;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OportunidadeController extends Controller
{
    public function index(Request $request)
    {
        $hoje = \Carbon\Carbon::today();
        
        $oportunidadesHoje = Oportunidade::with('cliente')
            ->whereDate('data_contato', $hoje)
            ->orderBy('created_at', 'desc')
            ->get();

        $query = Oportunidade::with('cliente');

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data_contato', [$request->data_inicio, $request->data_fim]);
        } elseif ($request->filled('data_inicio')) {
            $query->where('data_contato', '>=', $request->data_inicio);
        } elseif ($request->filled('data_fim')) {
            $query->where('data_contato', '<=', $request->data_fim);
        }

        if ($request->filled('cidade')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('cidade', $request->cidade);
            });
        }

        if ($request->filled('bairro')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('bairro', $request->bairro);
            });
        }

        $todasOportunidades = $query->orderBy('data_contato', 'desc')
            ->paginate(10)
            ->appends($request->all());

        $clientes = Cliente::all();
        $cidades = Cliente::distinct()->whereNotNull('cidade')->pluck('cidade');
        $bairros = Cliente::distinct()->whereNotNull('bairro')->pluck('bairro');

        return view('oportunidades.index', compact(
            'oportunidadesHoje', 
            'todasOportunidades', 
            'clientes', 
            'cidades', 
            'bairros'
        ));
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
