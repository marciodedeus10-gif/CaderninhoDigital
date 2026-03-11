@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Serviços</h2>

    <a href="{{ route('servicos.create') }}" class="btn btn-success mb-3">
        Novo Serviço
    </a>

    

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Validade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicos as $servico)
            <tr>
                <td>{{ $servico->nome }}</td>
                <td>R$ {{ number_format($servico->preco, 2, ',', '.') }}</td>
                <td>{{ $servico->categoria }}</td>
                <td>{{ $servico->validade_dias }} dias</td>
                <td>
                    <a href="{{ route('servicos.edit', $servico) }}" class="btn btn-primary btn-sm">Editar</a>

                    <form action="{{ route('servicos.destroy', $servico) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection