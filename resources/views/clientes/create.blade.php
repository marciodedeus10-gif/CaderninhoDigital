@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo Cliente</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-0">Novo Cliente</h2>
        </div>
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-header bg-success py-3 border-0" style="border-radius: 20px 20px 0 0;">
            <h5 class="mb-0 text-white fw-bold">
                <i class="bi bi-person-plus me-2"></i> Cadastrar Novo Cliente
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                @include('clientes.form')

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success px-5 py-2 shadow" style="border-radius: 10px;">
                        <i class="bi bi-save me-1"></i> Salvar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body.dark-mode .card { background-color: #1a1a2e !important; }
    body.dark-mode .card-header { background-color: #065f46 !important; } /* Darker green for header */
    body.dark-mode .text-dark { color: #e0e0f0 !important; }
    body.dark-mode .form-control, body.dark-mode .form-select {
        background-color: #0f0f1a;
        border-color: #2a2a4a;
        color: #e0e0f0;
    }
    body.dark-mode .form-control:focus, body.dark-mode .form-select:focus {
        background-color: #0f0f1a;
        border-color: #10b981;
        color: #fff;
    }
</style>
@endsection
