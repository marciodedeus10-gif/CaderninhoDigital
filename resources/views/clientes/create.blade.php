@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Novo Cliente</h2>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Cidade</label>
            <input type="text" name="cidade" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bairro</label>
            <input type="text" name="bairro" class="form-control">
        </div>

        <div class="mb-3">
            <label>Rua</label>
            <input type="text" name="endereco" class="form-control">
        </div>

        <div class="mb-3">
            <label>CEP</label>
            <input type="text" name="cep" class="form-control">
        </div>

        <div class="mb-3">
            <label>Número</label>
            <input type="text" name="numero" class="form-control">
        </div>

        <div class="mb-3">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>

    </form>

</div>
@endsection
