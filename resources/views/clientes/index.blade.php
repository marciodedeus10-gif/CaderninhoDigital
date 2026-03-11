@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            + Novo Cliente
        </a>
    </div>

    <hr>

    <form method="GET" action="{{ route('clientes.index') }}" style="margin-bottom:20px;">

        <input type="text" name="nome" placeholder="Nome"
            value="{{ request('nome') }}">

        <!-- Cidade -->
        <select name="cidade">
            <option value="">Todas Cidades</option>
            @foreach($cidades as $cidade)
                <option value="{{ $cidade }}"
                    {{ request('cidade') == $cidade ? 'selected' : '' }}>
                    {{ $cidade }}
                </option>
            @endforeach
        </select>

        <!-- Bairro -->
        <select name="bairro">
            <option value="">Todos Bairros</option>
            @foreach($bairros as $bairro)
                <option value="{{ $bairro }}"
                    {{ request('bairro') == $bairro ? 'selected' : '' }}>
                    {{ $bairro }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filtrar</button>
        <a href="{{ route('clientes.index') }}">Limpar</a>

    </form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Bairro</th>
                <th>Rua</th>
                <th>Cep</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->cidade }}</td>
                    <td>{{ $cliente->Rua }}</td>
                    <td>{{ $cliente->cep }}</td>
                    <td>{{ $cliente->Ações }}</td>
                    <td>
                        <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
