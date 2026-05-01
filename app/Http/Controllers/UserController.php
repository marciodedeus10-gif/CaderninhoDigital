<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Venda;

class UserController extends Controller
{

    public function show()
    {
        $user = Auth::user();

        $totalClientes = Cliente::count();
        $totalVendas = Venda::count();

        return view('perfil.show', compact(
            'user',
            'totalClientes',
            'totalVendas'
        ));
    }
// Mostrar tela
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    // Atualizar dados
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telefone = $request->telefone;
        $user->tipo = $request->tipo;
        $user->tema = $request->tema;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fotos_perfil', 'public');
            $user->foto = $path;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('perfil.edit')->with('success', 'Dados atualizados!');
    }
}
