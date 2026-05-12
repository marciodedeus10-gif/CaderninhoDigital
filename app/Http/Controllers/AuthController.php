<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulário login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Processar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    // Mostrar formulário registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Registrar usuário
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Criar a assinatura Ouro trial de 15 dias para novos usuários
        $planoOuro = \App\Models\Plano::where('nome', 'Ouro')->first();
        if ($planoOuro) {
            \App\Models\Assinatura::create([
                'user_id' => $user->id,
                'plano_id' => $planoOuro->id,
                'status' => 'ativa',
                'data_inicio' => now(),
                // 'data_fim' => now()->addDays(15),
                // 'data_renovacao' => now()->addDays(15),
                'data_fim' => now()->addMinutes(05),
                'data_renovacao' => now()->addMinutes(05),
                'periodicidade' => 'mensal', // ou trial
                'valor' => 0.00
            ]);
        }

        return redirect()->route('login');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function forgot()
    {
        return view('auth.forgot-password');
    }
}