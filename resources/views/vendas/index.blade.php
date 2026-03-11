@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Histórico de Vendas</h2>

    <a href="{{ route('vendas.create') }}" class="btn btn-success mb-3">
        Nova Venda
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Valor Total</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $venda)
            <tr>
                <td>{{ $venda->cliente->nome }}</td>
                <td>{{ $venda->produto->nome }}</td>
                <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                <td>{{ $venda->data_venda }}</td>
                <td>
                    <a href="{{ route('vendas.edit', $venda) }}" class="btn btn-primary btn-sm">Editar</a>

                    <form action="{{ route('vendas.destroy', $venda) }}" method="POST" style="display:inline;">
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