@extends('layouts.app')

@section('header_styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendas.index') }}">Vendas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nova Venda</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-0">Nova Venda</h2>
        </div>
        <a href="{{ route('vendas.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-header bg-success py-3 border-0" style="border-radius: 20px 20px 0 0;">
            <h5 class="mb-0 text-white fw-bold">
                <i class="bi bi-cart-plus me-2"></i> Iniciar Nova Venda
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('vendas.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Cliente --}}
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Cliente *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                            <select name="cliente_id" id="cliente_id"
                                    class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">Pesquisar cliente...</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ (old('cliente_id') == $cliente->id || (isset($selected_cliente_id) && $selected_cliente_id == $cliente->id)) ? 'selected' : '' }}>
                                        {{ $cliente->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Botão cadastrar cliente --}}
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <a href="{{ route('clientes.create', ['origin' => 'venda']) }}" class="btn btn-outline-primary w-100 shadow-sm" style="height: 38px;">
                            <i class="bi bi-person-plus me-1"></i> Cadastrar Novo
                        </a>
                    </div>

                    {{-- Data da venda --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Data da Venda *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="data_venda"
                                    class="form-control @error('data_venda') is-invalid @enderror"
                                    value="{{ old('data_venda', date('Y-m-d')) }}" required>
                            @error('data_venda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success px-5 py-2 shadow" style="border-radius: 10px;">
                        <i class="bi bi-arrow-right-circle me-1"></i> Continuar para Itens
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect("#cliente_id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Digite para buscar um cliente...",
            noResultsText: "Nenhum cliente encontrado"
        });
    });
</script>

<style>
    body.dark-mode .card { background-color: #1a1a2e !important; }
    body.dark-mode .bg-white, body.dark-mode .input-group-text { background-color: #0f0f1a !important; color: #e0e0f0; border-color: #2a2a4a; }
    body.dark-mode .text-dark { color: #e0e0f0 !important; }
    body.dark-mode .form-control, body.dark-mode .form-select {
        background-color: #0f0f1a;
        border-color: #2a2a4a;
        color: #e0e0f0;
    }

    /* Tom Select Dark Mode */
    body.dark-mode .ts-control {
        background-color: #0f0f1a !important;
        color: #e0e0f0 !important;
        border-color: #2a2a4a !important;
    }
    body.dark-mode .ts-dropdown {
        background-color: #1a1a2e !important;
        color: #e0e0f0 !important;
        border-color: #2a2a4a !important;
    }
    body.dark-mode .ts-dropdown .active {
        background-color: #2563eb !important;
        color: #fff !important;
    }
    body.dark-mode .ts-control input {
        color: #e0e0f0 !important;
    }
</style>
@endsection
