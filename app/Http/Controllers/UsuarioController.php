<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Buscar apenas usuários do mesmo "dono" (empresa)
        $usuarios = User::where('user_id', $user->id)
            ->orWhere('id', $user->id)
            ->with('roles')
            ->get();

        $roles = Role::all();

        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $user = Auth::user();

        // Verificar limite de usuários do plano
        if (!$user->podeCriarUsuario()) {
            return back()->with('error', 'Seu plano não permite criar mais usuários');
        }

        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name'
        ]);

        $user = Auth::user();

        // Verificar limite de usuários
        if (!$user->podeCriarUsuario()) {
            return back()->with('error', 'Seu plano não permite criar mais usuários');
        }

        $novoUsuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_id' => $user->id // Vincular ao usuário "dono"
        ]);

        $novoUsuario->assignRole($request->role);

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $usuario)
    {
        // Verificar se o usuário pertence à mesma empresa
        if ($usuario->user_id !== Auth::id() && $usuario->id !== Auth::id()) {
            abort(403);
        }

        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        // Verificar se o usuário pertence à mesma empresa
        if ($usuario->user_id !== Auth::id() && $usuario->id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'role' => 'required|exists:roles,name'
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        $usuario->syncRoles([$request->role]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $usuario)
    {
        // Verificar se o usuário pertence à mesma empresa
        if ($usuario->user_id !== Auth::id() && $usuario->id !== Auth::id()) {
            abort(403);
        }

        // Não permitir deletar o próprio usuário
        if ($usuario->id === Auth::id()) {
            return back()->with('error', 'Você não pode deletar seu próprio usuário');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário removido com sucesso!');
    }
}