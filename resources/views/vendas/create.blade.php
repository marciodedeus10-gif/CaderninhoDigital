@extends('layouts.app')

@section('content')
    <h2>Nova Venda</h2>

    <form action="{{ route('vendas.store') }}" method="POST">

        @csrf

        <label>Cliente</label>

        <select name="cliente_id" class="form-control">

            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
            @endforeach

        </select>

        <input type="date" name="data_venda" class="form-control"><br><br>

        <br>

        <a href="{{ route('clientes.create') }}" class="btn btn-secondary">
            Cadastrar Cliente
        </a>

        <br><br>

        <button class="btn btn-primary">
            Criar Venda
        </button>

    </form>
@endsection
