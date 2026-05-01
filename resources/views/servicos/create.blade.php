@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Novo Serviço</h2>

    <form action="{{ route('servicos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descrição</label>
            <textarea name="descricao" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Preço</label>
            <input type="number" step="0.01" name="preco" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Categoria</label>
            <input type="text" name="categoria" class="form-control">
        </div>

        <div class="mb-3">
            <label>Validade (dias)</label>
            <input type="number" name="validade_dias" class="form-control">
        </div>

        <button class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection