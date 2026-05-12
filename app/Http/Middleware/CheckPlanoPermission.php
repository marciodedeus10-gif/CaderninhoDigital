<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPlanoPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $recurso): Response
    {
        $user = Auth::user();

        // Verificar se usuário tem assinatura ativa
        if (!$user->temAssinaturaAtiva()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Assinatura expirada ou inexistente',
                    'message' => 'Renove sua assinatura para continuar usando o sistema'
                ], 403);
            }
            return redirect()->route('assinaturas.index')->with('error', 'Sua assinatura expirou. Renove ou faça upgrade para continuar.');
        }

        // Verificar se o plano permite o recurso
        if (!$user->podeAcessarRecurso($recurso)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Recurso não disponível no seu plano',
                    'message' => 'Atualize seu plano para acessar esta funcionalidade'
                ], 403);
            }
            return redirect()->route('assinaturas.index')->with('error', 'Este recurso não está disponível no seu plano atual. Faça um upgrade para acessar!');
        }

        return $next($request);
    }
}