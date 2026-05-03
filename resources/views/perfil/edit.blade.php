@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5>Atualizar Perfil</h5>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nome --}}
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control mb-2">

                    {{-- Email --}}
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control mb-2">

                    {{-- Telefone --}}
                    <input type="text" name="telefone" value="{{ $user->telefone }}" class="form-control mb-2"
                        placeholder="WhatsApp">

                    {{-- Tipo --}}
                    <select name="tipo" class="form-control mb-2">
                        <option value="vendedor" {{ $user->tipo == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                        <option value="admin" {{ $user->tipo == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>

                    {{-- Tema --}}
                    <select name="tema" class="form-control mb-2">
                        <option value="claro" {{ $user->tema == 'claro' ? 'selected' : '' }}>Claro</option>
                        <option value="escuro" {{ $user->tema == 'escuro' ? 'selected' : '' }}>Escuro</option>
                    </select>

                    {{-- Foto --}}
                    <input type="file" name="foto" class="form-control mb-2">
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" width="80" class="mb-2 rounded-circle">
                    @endif

                    {{-- Senha --}}
                    <input type="password" name="password" class="form-control mb-2" placeholder="Nova senha">

                    <button class="btn btn-success">Salvar</button>
                </form>

        <!-- Formulário para excluir a conta -->
        <form action="{{ route('perfil.delete') }}" method="POST" style="margin-top:15px;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.')">
                Excluir Conta
            </button>
        </form>
            </div>
        </div>

    </div>
@endsection
