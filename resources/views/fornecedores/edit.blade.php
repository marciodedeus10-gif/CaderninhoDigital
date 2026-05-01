@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Editar Fornecedor: {{ $fornecedore->nome }}</h2>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('fornecedores.update', $fornecedore) }}" method="POST">
                @csrf
                @method('PUT')
                @include('fornecedores.form', ['forn' => $fornecedore])
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Atualizar Fornecedor</button>
                    <a href="{{ route('fornecedores.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
