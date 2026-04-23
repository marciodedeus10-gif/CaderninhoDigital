@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Novo Pedido de Compra</h2>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('compras.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Fornecedor *</label>
                        <select name="fornecedor_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            @foreach($fornecedores as $forn)
                                <option value="{{ $forn->id }}">{{ $forn->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Data da Compra *</label>
                        <input type="date" name="data_compra" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Criar Pedido</button>
                    <a href="{{ route('compras.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
