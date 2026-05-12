<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssinaturaController extends Controller
{
    public function index()
    {
        $assinatura = Auth::user()->assinatura;
        $planos = Plano::ativo()->get();

        return view('assinaturas.index', compact('assinatura', 'planos'));
    }

    public function create()
    {
        $planos = Plano::ativo()->get();
        return view('assinaturas.create', compact('planos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'periodicidade' => 'required|in:mensal,anual'
        ]);

        $plano = Plano::findOrFail($request->plano_id);
        $user = Auth::user();

        // Verificar se já existe assinatura ativa
        if ($user->temAssinaturaAtiva()) {
            return back()->error('Você já possui uma assinatura ativa');
        }

        $valor = $request->periodicidade === 'anual' ? $plano->preco_anual : $plano->preco_mensal;
        $dataFim = $request->periodicidade === 'anual'
            ? now()->addYear()
            : now()->addMonth();

        Assinatura::create([
            'user_id' => $user->id,
            'plano_id' => $plano->id,
            'status' => 'ativa',
            'data_inicio' => now(),
            'data_fim' => $dataFim,
            'data_renovacao' => $dataFim,
            'periodicidade' => $request->periodicidade,
            'valor' => $valor
        ]);

        return redirect()->route('dashboard')->with('success', 'Assinatura criada com sucesso!');
    }

    public function upgrade(Request $request)
    {
        $request->validate([
            'plano_id' => 'required|exists:planos,id'
        ]);

        $user = Auth::user();
        $novoPlano = Plano::findOrFail($request->plano_id);

        if ($user->assinatura && $user->assinatura->plano_id == $novoPlano->id) {
            return back()->with('error', 'Você já possui este plano');
        }

        // Atualizar assinatura existente ou criar nova
        if ($user->assinatura) {
            $user->assinatura->update([
                'plano_id' => $novoPlano->id,
                'valor' => $user->assinatura->periodicidade === 'anual' ? $novoPlano->preco_anual : $novoPlano->preco_mensal
            ]);
        } else {
            $this->store($request);
            return;
        }

        return redirect()->route('assinaturas.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function cancelar()
    {
        $user = Auth::user();

        if (!$user->assinatura || !$user->assinatura->estaAtiva()) {
            return back()->with('error', 'Não há assinatura ativa para cancelar');
        }

        $user->assinatura->update(['status' => 'cancelada']);

        return redirect()->route('assinaturas.index')->with('success', 'Assinatura cancelada com sucesso!');
    }


    // Nova funcionalidade: criar assinatura gratuita para o plano Bronze
    public function gratis()
    {
        $user = Auth::user();
        // Verificar se usuário já tem assinatura ativa
        if ($user->temAssinaturaAtiva()) {
            return back()->with('error', 'Você já possui uma assinatura ativa');
        }
        // Encontrar o plano Bronze
        $plano = Plano::where('nome', 'Bronze')->first();
        if (!$plano) {
            return back()->with('error', 'Plano Bronze não encontrado');
        }
        // Criar assinatura gratuita (mensal)
        Assinatura::create([
            'user_id' => $user->id,
            'plano_id' => $plano->id,
            'status' => 'ativa',
            'data_inicio' => now(),
            'data_fim' => now()->addMonth(),
            'data_renovacao' => now()->addMonth(),
            'periodicidade' => 'mensal',
            'valor' => 0.00,
        ]);

        return redirect()->route('dashboard')->with('success', 'Assinatura Bronze gratuita criada com sucesso!');
    }
}