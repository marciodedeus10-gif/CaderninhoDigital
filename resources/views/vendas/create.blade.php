@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Nova Venda</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('vendas.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Cliente --}}
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Cliente</label>
                        <select name="cliente_id"
                                class="form-control @error('cliente_id') is-invalid @enderror">

                            <option value="">Selecione um cliente</option>

                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }}
                                </option>
                            @endforeach

                        </select>

                        @error('cliente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botão cadastrar cliente --}}
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <a href="{{ route('clientes.create') }}" class="btn btn-outline-secondary w-100">
                            ➕ Novo Cliente
                        </a>
                    </div>

                    {{-- Data da venda --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Data da Venda</label>
                        <input type="date" name="data_venda"
                                class="form-control @error('data_venda') is-invalid @enderror"
                                value="{{ old('data_venda', date('Y-m-d')) }}">

                        @error('data_venda')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('vendas.index') }}" class="btn btn-secondary">
                        ← Voltar
                    </a>

                    <button type="submit" class="btn btn-success">
                        💾 Criar Venda
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
