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

    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('perfil.show')
        ->with('success','Cadastro atualizado');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/');
    }

}
