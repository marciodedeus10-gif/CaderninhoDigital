@extends('layouts.app')

@section('content')
    <div class="container">

        <h2>Perfil do Usuário</h2>

        <div class="card p-4">

            <div class="text-center">

                <img src="/img/user.png" width="120" style="border-radius:50%">

            </div>

            <hr>

            <p><strong>Nome:</strong> {{ $user->name }}</p>

            <p><strong>Email:</strong> {{ $user->email }}</p>

            <p><strong>Data de cadastro:</strong>
                {{ $user->created_at->format('d/m/Y') }}
            </p>

            <hr>

            <h4>Informações do Sistema</h4>

            <p><strong>Clientes cadastrados:</strong> {{ $totalClientes }}</p>

            <p><strong>Total de vendas:</strong> {{ $totalVendas }}</p>

            <hr>

            <a href="{{ route('perfil.edit') }}" class="btn btn-primary">
                Atualizar Cadastro
            </a>

            <form action="{{ route('perfil.delete') }}" method="POST" style="margin-top:10px;">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger">
                    Excluir Conta
                </button>

            </form>

        </div>

    </div>
@endsection
