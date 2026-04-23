@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Produtos</h2>
        <a href="{{ route('produtos.create') }}" class="btn btn-success">
            Novo Produto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código/SKU</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
            <tr>
                <td>{{ $produto->codigo_sku ?? '-' }}</td>
                <td>{{ $produto->nome }}</td>
                <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                <td>
                    @if($produto->estoque <= 5)
                        <span class="badge bg-danger">{{ $produto->estoque }} {{ $produto->unidade_medida }}</span>
                    @else
                        <span class="badge bg-success">{{ $produto->estoque }} {{ $produto->unidade_medida }}</span>
                    @endif
                </td>
                <td>{{ $produto->categoria }}</td>
                <td>
                    <a href="{{ route('produtos.estoque', $produto) }}" class="btn btn-info btn-sm text-white">📦 Estoque</a>
                    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-warning btn-sm">Editar</a>

                    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" style="display:inline;">
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
